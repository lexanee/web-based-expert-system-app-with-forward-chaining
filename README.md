# Expert System for E-Procurement Technical Issue Diagnosis

<p align="center">
<img src="https://img.shields.io/badge/Laravel-12.x-red.svg" alt="Laravel Version">
<img src="https://img.shields.io/badge/PHP-8.3+-blue.svg" alt="PHP Version">
<img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
<img src="https://img.shields.io/badge/Database-MySQL-orange.svg" alt="Database">
</p>

## 📋 Overview

This is a **Web-Based Expert System Application** designed for diagnosing technical issues in E-Procurement systems using the **Forward Chaining** inference method. The system provides intelligent diagnosis capabilities based on symptoms and user types, along with comprehensive reporting features.

### 🎯 Key Features

- **🔍 Public Diagnosis System** - No login required for basic diagnosis
- **📊 Forward Chaining Engine** - Intelligent rule-based inference system
- **👥 Multi-User Support** - Vendor and Internal user types
- **📝 Issue Reporting** - Comprehensive problem reporting with file attachments
- **🎛️ Admin Dashboard** - Complete CRUD operations for system management
- **📈 Analytics & Reporting** - Export capabilities (PDF, Excel)
- **🔐 Secure Authentication** - Laravel Breeze with email verification

## 🚀 Quick Start

### Prerequisites

- **OS**: Windows/Linux/macOS
- **Web Server**: Apache/Nginx (or Laragon 8 for Windows)
- **PHP**: 8.3 or higher
- **Database**: MySQL 8.0+ or MariaDB 10.3+
- **Node.js**: LTS version (for Vite/Tailwind)
- **Composer**: 2.0 or higher

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd web-based-expert-system-app-with-forward-chaining
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install frontend dependencies**
   ```bash
   npm install
   ```

<<<<<<< HEAD
4. **Setup database**
   ```bash
   # Create MySQL database
   mysql -u root -p
   CREATE DATABASE expert_system;
   CREATE USER 'expert_user'@'localhost' IDENTIFIED BY 'your_password';
   GRANT ALL PRIVILEGES ON expert_system.* TO 'expert_user'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   
   # Update .env file with database credentials
   # Then run migrations
   php artisan migrate --seed
   ```

5. **Run the application**
   
   **Option A: All processes in parallel**
   ```bash
   composer run dev
   ```
   
   **Option B: Manual separate terminals**
   ```bash
   # Terminal 1
   php artisan serve
   
   # Terminal 2
   npm run dev
   ```

6. **Access the application**
   - **Public Site**: http://127.0.0.1:8000/
   - **Admin Dashboard**: http://127.0.0.1:8000/dashboard

### 🔑 Default Admin Credentials

| Role | Email | Password |
|------|-------|----------|
| Super Admin | admin@example.com | password |

> ⚠️ **Security Note**: Change default passwords immediately in production!

## 🏗️ System Architecture

### Core Components

=======
4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Setup database**
   ```bash
   # Create MySQL database
   mysql -u root -p
   CREATE DATABASE db_expert_system_fwc;
   EXIT;
   
   # Update .env file - uncomment and configure these lines:
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=db_expert_system_fwc
   # DB_USERNAME=root
   # DB_PASSWORD=
   
   # Then run migrations
   php artisan migrate --seed
   ```

6. **Run the application**
   
   **Option A: All processes in parallel**
   ```bash
   composer run dev
   ```
   
   **Option B: Manual separate terminals**
   ```bash
   # Terminal 1
   php artisan serve
   
   # Terminal 2
   npm run dev
   ```

7. **Access the application**
   - **Public Site**: http://127.0.0.1:8000/
   - **Admin Dashboard**: http://127.0.0.1:8000/dashboard

### 🔑 Default Admin Credentials

| Role | Email | Password |
|------|-------|----------|
| Super Admin | admin@example.com | password |

> ⚠️ **Security Note**: Change default passwords immediately in production!

## 🏗️ System Architecture

### Core Components

>>>>>>> 70af008 (chore: update environment configuration and enhance README for Expert System)
- **Forward Chaining Engine** (`App\Services\ForwardChainingEngine`)
- **Models**: Gejala (Symptoms), Masalah (Problems), Aturan (Rules)
- **Authentication**: Laravel Breeze with email verification
- **Database**: MySQL with JSON data seeders
- **Frontend**: Tailwind CSS + Alpine.js + Vite

### Database Schema

```
Users (Admin accounts)
├── Gejala (Symptoms) - G1, G2, G3...
├── Masalah (Problems) - M1, M2, M3...
├── Aturan (Rules) - IF G1 AND G2 THEN M1
├── RiwayatDiagnosis (Diagnosis History)
└── RiwayatLaporMasalah (Issue Reports)
```

## 🔄 Forward Chaining Process

### How It Works

1. **Input**: Selected symptom IDs + user type (Vendor/Internal)
2. **Validation**: Check symptoms match user type
3. **Rule Matching**: 
   - Find rules with 100% symptom match (highest score wins)
   - If no exact match, use weighted partial matching (70% rule coverage + 30% user symptom coverage)
   - Minimum threshold: 70%
4. **Output**: Problem identification with confidence level

### Algorithm Flow

```
Input Symptoms → Validate User Type → Match Rules → Calculate Scores → Return Diagnosis
```

## 📱 User Features

### Public Access (No Login Required)

#### 🩺 Diagnosis Process
1. **Step 1**: Select User Type (Vendor/Internal)
2. **Step 2**: Choose Process Stage
3. **Step 3**: Select Relevant Symptoms
4. **Step 4**: View Diagnosis Results with Solutions

#### 📋 Issue Reporting
- Report technical issues, bugs, or suggestions
- Attach files (JPG, PNG, PDF, DOC, DOCX up to 10MB)
- Track reports with unique IDs

### Admin Features (Login Required)

#### 🎛️ Dashboard Management
- **Symptoms Management** (`/admin/gejala`)
- **Problems Management** (`/admin/masalah`)
- **Rules Management** (`/admin/aturan`)
- **Diagnosis History** (`/admin/riwayat-diagnosis`)
- **Issue Reports** (`/admin/riwayat-lapor-masalah`)

#### 📊 Export Capabilities
- PDF exports for Problems and Rules
- Excel/PDF exports for History and Reports
- Individual report PDF generation

## 🛠️ Development

### Project Structure

```
app/
├── Http/Controllers/     # Application controllers
├── Models/              # Eloquent models
├── Services/            # Business logic (Forward Chaining Engine)
├── Exports/             # Excel/PDF export classes
└── Providers/           # Service providers

database/
├── data/                # JSON seed data (gejala.json, masalah.json, aturan.json)
├── migrations/          # Database migrations
└── seeders/             # Database seeders

resources/
├── views/               # Blade templates
├── css/                 # Tailwind CSS
└── js/                  # Alpine.js components

routes/
├── web.php              # Web routes
└── auth.php             # Authentication routes
```

### Available Scripts

```bash
# Development
composer run dev          # Run all dev processes in parallel
npm run dev              # Vite dev server
php artisan serve        # Laravel dev server

# Production
npm run build            # Build frontend assets
php artisan optimize     # Optimize application

# Database
php artisan migrate --seed    # Run migrations with seeders
php artisan db:seed          # Run seeders only
php artisan migrate:fresh --seed  # Fresh migration with seeders

# Storage
php artisan storage:link     # Link storage for file uploads
```

### Technology Stack

| Component | Technology |
|-----------|------------|
| **Backend** | Laravel 12, PHP 8.3+ |
| **Database** | MySQL 8.0+, MariaDB 10.3+ |
| **Frontend** | Tailwind CSS, Alpine.js, Vite |
| **Authentication** | Laravel Breeze |
| **Exports** | DomPDF, Maatwebsite Excel |
| **File Storage** | Laravel Storage with Symbolic Links |

## 📊 Data Management

### Seed Data Structure

The system uses JSON files for initial data:

- **`database/data/gejala.json`** - Symptoms data
- **`database/data/masalah.json`** - Problems data  
- **`database/data/aturan.json`** - Rules data

### Rule Format

Rules follow the pattern: `"IF G3 AND G4 THEN M4"`

Example rule structure:
```json
{
  "kode": "R1",
  "masalah_id": 1,
  "gejala_ids": [1, 2, 3],
  "deskripsi": "IF G1 AND G2 AND G3 THEN M1"
}
```

## 🔧 Configuration

### Environment Setup

```bash
# Copy environment file
cp .env.example .env

<<<<<<< HEAD
# Key configurations
APP_NAME="Expert System E-Procurement"
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expert_system
DB_USERNAME=your_username
DB_PASSWORD=your_password
=======
# Key configurations (uncomment the DB_* lines in .env)
APP_NAME="Expert System Forward Chaining"
APP_URL=http://localhost
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_expert_system_fwc
DB_USERNAME=root
DB_PASSWORD=
>>>>>>> 70af008 (chore: update environment configuration and enhance README for Expert System)
```

### Storage Configuration

```bash
# Create storage link for file uploads
php artisan storage:link
```

### Queue Configuration (Optional)

For production environments, configure queue workers:

```bash
# Run queue worker
php artisan queue:work

# Or use supervisor for daemon process
```

## 🚀 Production Deployment

### Build Steps

1. **Install dependencies**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install
   ```

2. **Build assets**
   ```bash
   npm run build
   ```

3. **Optimize application**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

4. **Set permissions**
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

### Server Requirements

- PHP 8.3+
- MySQL 8.0+ or MariaDB 10.3+
- PDO MySQL extension
- OpenSSL extension
- Mbstring extension
- Tokenizer extension
- XML extension
- Ctype extension
- JSON extension
- BCMath extension

## 🛡️ Security & Best Practices

### Security Recommendations

- ✅ Change default admin passwords
- ✅ Use HTTPS in production
- ✅ Regular database backups
- ✅ Secure file upload validation
- ✅ Email verification for admin accounts
- ✅ CSRF protection on all forms

### Backup Strategy

```bash
# Backup MySQL database
mysqldump -u username -p database_name > backups/database_$(date +%Y%m%d).sql

# Backup uploaded files
tar -czf backups/storage_$(date +%Y%m%d).tar.gz storage/app/public/
```

## 🐛 Troubleshooting

### Common Issues

| Issue | Solution |
|-------|----------|
| 404 on `/storage/...` URLs | Run `php artisan storage:link` |
| Migration errors | Check database connection and credentials in `.env` |
| Can't login with default credentials | Run `php artisan db:seed` |
| Rules not working | Check symptom codes (G1, G2) match JSON data |
| Assets not loading | Run `npm run build` for production |

### Debug Commands

```bash
# Check application status
php artisan about

# View logs
php artisan pail

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## 📈 Performance Optimization

### Database Optimization

- MySQL indexes are configured on frequently queried columns
- Connection pooling for better performance
- Eager loading used to prevent N+1 queries
- Query optimization with proper indexing

### Frontend Optimization

```bash
# Production build with optimization
npm run build

# Analyze bundle size
npm run build -- --analyze
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines

- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation for API changes
- Use semantic commit messages

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

## 📞 Support

For technical support or questions:

- � **Documentation**: Check this README and inline code comments
- 🐛 **Issues**: Create an issue on the repository
- � **Discussions**: Use the repository discussions for questions

---

*Built with ❤️ using Laravel 12 and modern web technologies*
