<?php

namespace App\Services;

use App\Models\Aturan;
use App\Models\Gejala;
use App\Models\Masalah;
use Illuminate\Support\Collection;

/**
 * Mesin Inferensi Forward Chaining
 * 
 * Service ini mengimplementasikan algoritma forward chaining untuk diagnosis sistem pakar.
 * Mengambil gejala yang dipilih pengguna dan mencocokkannya dengan aturan yang telah ditentukan
 * untuk menentukan masalah dan solusi yang paling mungkin.
 */
class ForwardChainingEngine
{
    // Ambang batas skor minimum untuk kecocokan yang valid (70%)
    private const MIN_MATCH_THRESHOLD = 70.0;

    // Faktor bobot untuk algoritma penilaian
    private const RULE_MATCH_WEIGHT = 0.7;
    private const USER_MATCH_WEIGHT = 0.3;

    /**
     * Jalankan inferensi forward chaining
     * 
     * @param array $selectedSymptoms Array ID gejala yang dipilih pengguna
     * @param string $userType Tipe pengguna (Vendor/Internal)
     * @return array Hasil diagnosis dengan masalah, solusi, dan skor kepercayaan
     */
    public function diagnose(array $selectedSymptoms, string $userType): array
    {
        // Langkah 1: Validasi dan filter gejala berdasarkan tipe pengguna
        $validSymptoms = $this->getValidSymptoms($selectedSymptoms, $userType);

        if (empty($validSymptoms)) {
            return $this->createNoMatchResult('Tidak ditemukan gejala yang valid untuk tipe pengguna: ' . $userType);
        }

        // Langkah 2: Ambil semua aturan yang tersedia
        $rules = $this->getAllRules();

        if ($rules->isEmpty()) {
            return $this->createNoMatchResult('Tidak ada aturan diagnosis yang tersedia');
        }

        // Langkah 3: Cari semua aturan yang 100% terpenuhi
        $fullySatisfiedRules = $this->findFullySatisfiedRules($rules, $validSymptoms);

        // Jika ada aturan yang terpenuhi 100%, langsung kembalikan yang paling relevan
        if (!empty($fullySatisfiedRules)) {
            usort($fullySatisfiedRules, fn($a, $b) => $b['score'] <=> $a['score']);
            $best = $fullySatisfiedRules[0];
            return $this->createSuccessResult($best['masalah'], $validSymptoms, $best['score']);
        }

        // Jika tidak ada aturan 100% terpenuhi, cari partial match terbaik
        $bestPartial = $this->findBestPartialMatch($rules, $validSymptoms);

        return $bestPartial ?: $this->createNoMatchResult('Tidak ditemukan aturan yang cocok untuk gejala yang dipilih');
    }

    /**
     * Validasi dan filter gejala berdasarkan tipe pengguna
     */
    private function getValidSymptoms(array $selectedSymptoms, string $userType): array
    {
        if (empty($selectedSymptoms)) {
            return [];
        }

        return Gejala::whereIn('id', $selectedSymptoms)
            ->where(function ($query) use ($userType) {
                $query->where('tipe_pengguna', $userType)
                    ->orWhere('tipe_pengguna', 'Both');
            })
            ->pluck('id')
            ->toArray();
    }

    /**
     * Ambil semua aturan diagnosis yang tersedia
     */
    private function getAllRules(): Collection
    {
        return Aturan::with('masalah')->get();
    }

    /**
     * Cari semua aturan yang gejalanya 100% terpenuhi
     */
    private function findFullySatisfiedRules(Collection $rules, array $validSymptoms): array
    {
        $satisfied = [];

        foreach ($rules as $rule) {
            if (!$this->isValidRule($rule)) continue;

            $ruleSymptoms = $rule->gejala_ids;
            $matching = array_intersect($validSymptoms, $ruleSymptoms);

            // Cek: apakah SEMUA gejala di aturan terpenuhi?
            if (count($matching) === count($ruleSymptoms)) {
                $score = $this->calculateMatchScore($matching, $ruleSymptoms, $validSymptoms);
                $satisfied[] = [
                    'masalah' => $rule->masalah,
                    'score' => $score,
                    'matching' => $matching
                ];
            }
        }

        return $satisfied;
    }

    /**
     * Temukan aturan yang paling cocok dari semua aturan yang tersedia
     */
    // private function findBestMatchingRule(Collection $rules, array $validSymptoms): ?array
    // {
    //     $bestMatch = null;
    //     $bestScore = 0.0;

    //     foreach ($rules as $rule) {
    //         $ruleResult = $this->evaluateRule($rule, $validSymptoms);

    //         if (!$ruleResult) {
    //             continue;
    //         }

    //         // Kecocokan sempurna - kembalikan segera
    //         if ($ruleResult['is_perfect_match']) {
    //             return $this->createSuccessResult($rule->masalah, $validSymptoms, 100.0);
    //         }

    //         // Lacak kecocokan parsial terbaik
    //         if ($ruleResult['score'] >= self::MIN_MATCH_THRESHOLD && $ruleResult['score'] > $bestScore) {
    //             $bestMatch = $rule;
    //             $bestScore = $ruleResult['score'];
    //         }
    //     }

    //     return $bestMatch ? $this->createSuccessResult($bestMatch->masalah, $validSymptoms, $bestScore) : null;
    // }

    /**
     * Evaluasi satu aturan terhadap gejala pengguna
     */
    // private function evaluateRule(Aturan $rule, array $validSymptoms): ?array
    // {
    //     // Lewati aturan yang tidak valid
    //     if (!$this->isValidRule($rule)) {
    //         return null;
    //     }

    //     $ruleSymptoms = $rule->gejala_ids;
    //     $matchingSymptoms = array_intersect($validSymptoms, $ruleSymptoms);

    //     // Hitung skor kecocokan
    //     $score = $this->calculateMatchScore($matchingSymptoms, $ruleSymptoms, $validSymptoms);

    //     // Periksa kecocokan sempurna
    //     $isPerfectMatch = $this->isPerfectMatch($matchingSymptoms, $ruleSymptoms, $validSymptoms);

    //     return [
    //         'score' => $score,
    //         'is_perfect_match' => $isPerfectMatch,
    //         'matching_symptoms' => $matchingSymptoms
    //     ];
    // }

    /**
     * Cari partial match terbaik (fallback)
     */
    private function findBestPartialMatch(Collection $rules, array $validSymptoms): ?array
    {
        $bestScore = 0.0;
        $bestRule = null;

        foreach ($rules as $rule) {
            if (!$this->isValidRule($rule)) continue;

            $ruleSymptoms = $rule->gejala_ids;
            $matching = array_intersect($validSymptoms, $ruleSymptoms);
            $score = $this->calculateMatchScore($matching, $ruleSymptoms, $validSymptoms);

            if ($score >= self::MIN_MATCH_THRESHOLD && $score > $bestScore) {
                $bestScore = $score;
                $bestRule = $rule;
            }
        }

        return $bestRule ? $this->createSuccessResult($bestRule->masalah, $validSymptoms, $bestScore) : null;
    }

    /**
     * Periksa apakah aturan memiliki struktur yang valid
     */
    private function isValidRule(Aturan $rule): bool
    {
        return $rule->gejala_ids &&
            is_array($rule->gejala_ids) &&
            !empty($rule->gejala_ids) &&
            $rule->masalah;
    }

    /**
     * Hitung skor kecocokan antara gejala pengguna dan gejala aturan
     * 
     * Menggunakan algoritma berbobot:
     * - Bobot 70% pada berapa banyak gejala aturan yang cocok
     * - Bobot 30% pada berapa banyak gejala pengguna yang tercakup
     */
    private function calculateMatchScore(array $matching, array $ruleSymptoms, array $userSymptoms): float
    {
        if (empty($ruleSymptoms)) {
            return 0.0;
        }

        // Cakupan aturan: persentase gejala aturan yang cocok
        $ruleCoverage = (count($matching) / count($ruleSymptoms)) * 100;

        // Cakupan pengguna: persentase gejala pengguna yang cocok
        $userCoverage = empty($userSymptoms) ? 0 : (count($matching) / count($userSymptoms)) * 100;

        // Skor akhir berbobot
        return ($ruleCoverage * self::RULE_MATCH_WEIGHT) + ($userCoverage * self::USER_MATCH_WEIGHT);
    }

    /**
     * Periksa apakah ini adalah kecocokan sempurna
     * Kecocokan sempurna terjadi ketika semua gejala aturan dan semua gejala pengguna cocok persis
     */
    // private function isPerfectMatch(array $matching, array $ruleSymptoms, array $userSymptoms): bool
    // {
    //     return count($matching) === count($ruleSymptoms) &&
    //         count($matching) === count($userSymptoms) &&
    //         count($matching) > 0;
    // }

    /**
     * Buat hasil diagnosis yang berhasil
     */
    private function createSuccessResult(Masalah $masalah, array $symptoms, float $score): array
    {
        return [
            'found' => true,
            'masalah' => $masalah,
            'solution' => $masalah->solusi,
            'gejala' => $symptoms,
            'score' => round($score, 1),
            'confidence_level' => $this->getConfidenceLevel($score)
        ];
    }

    /**
     * Buat hasil tidak cocok
     */
    private function createNoMatchResult(?string $reason = null): array
    {
        return [
            'found' => false,
            'masalah' => null,
            'solution' => 'Tidak ditemukan solusi yang sesuai. Silakan coba kombinasi gejala lain atau laporkan masalah ini.',
            'gejala' => [],
            'score' => 0.0,
            'confidence_level' => 'None',
            'reason' => $reason
        ];
    }

    /**
     * Dapatkan tingkat kepercayaan berdasarkan skor
     */
    private function getConfidenceLevel(float $score): string
    {
        return match (true) {
            $score >= 95 => 'Very High',
            $score >= 85 => 'High',
            $score >= 75 => 'Medium',
            $score >= 65 => 'Low',
            default => 'Very Low'
        };
    }
}
