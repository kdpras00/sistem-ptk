# 🚀 Quick Start Guide - Sistem Pengarsipan PTK

## Langkah Cepat Setup Sistem

### 1️⃣ Persiapan Database
```bash
# Login ke MySQL
mysql -u root -p

# Buat database baru
CREATE DATABASE sistem_ptk;
exit;
```

### 2️⃣ Konfigurasi Environment
Edit file `.env`:
```env
APP_NAME="Sistem PTK"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_ptk
DB_USERNAME=root
DB_PASSWORD=
```

### 3️⃣ Setup Aplikasi
```bash
# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database dengan data awal
php artisan db:seed

# Create storage link untuk upload files
php artisan storage:link

# Build frontend assets
npm run build
```

### 4️⃣ Jalankan Server
```bash
# Start Laravel development server
php artisan serve

# Buka browser: http://localhost:8000
```

---

## 🔐 Login Pertama Kali

Gunakan salah satu akun berikut:

### Admin
```
Email: admin@ptk.com
Password: admin123
```
**Fitur**: Kelola PTK, Kelola Kategori, Lihat Statistik

### Staf TU
```
Email: staftu@ptk.com
Password: staftu123
```
**Fitur**: Upload Dokumen, Cetak Laporan

### Kepala Sekolah
```
Email: kepsek@ptk.com
Password: kepsek123
```
**Fitur**: Lihat Data PTK, Filter & Search

### Guru (Contoh)
```
Email: budi@ptk.com
Password: guru123
```
**Fitur**: Lihat Data Diri

---

## 📋 Testing Workflow

### Sebagai Admin:
1. Login dengan `admin@ptk.com`
2. Klik menu "Kelola Data PTK"
3. Tambah PTK baru dengan klik "Tambah PTK"
4. Isi form data PTK (NIP, Nama, Status Kepegawaian, dll)
5. Upload foto (opsional)
6. Submit dan lihat data tersimpan

### Sebagai Staf TU:
1. Login dengan `staftu@ptk.com`
2. Klik "Kelola Dokumen"
3. Klik "Upload Dokumen"
4. Pilih PTK, Kategori, Upload file
5. Submit dokumen
6. Lihat dokumen di list

### Sebagai Guru:
1. Login dengan `budi@ptk.com`
2. Langsung melihat data diri sendiri
3. Cek informasi pribadi dan dokumen terkait

### Sebagai Kepala Sekolah:
1. Login dengan `kepsek@ptk.com`
2. Lihat statistik PTK
3. Gunakan search/filter untuk cari PTK
4. Klik "Detail" untuk lihat info lengkap PTK

---

## 🐛 Troubleshooting Umum

### Error: "SQLSTATE[HY000] [1049] Unknown database"
**Solusi**: Pastikan database sudah dibuat
```bash
mysql -u root -p
CREATE DATABASE sistem_ptk;
```

### Error: "No application encryption key"
**Solusi**: Generate key
```bash
php artisan key:generate
```

### Error: "Storage not found" saat upload
**Solusi**: Buat symbolic link
```bash
php artisan storage:link
```

### Error: "Permission denied" di folder storage
**Solusi**: Set permission
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Flowbite/Tailwind tidak muncul
**Solusi**: Build ulang assets
```bash
npm run build
# atau untuk development
npm run dev
```

### CSS/JS tidak update
**Solusi**: Clear cache & rebuild
```bash
php artisan optimize:clear
npm run build
```

---

## 📁 Upload File Configuration

Default: Max **10MB**, Format: **PDF, DOC, DOCX, JPG, PNG**

Untuk mengubah:
1. Edit `app/Http/Controllers/StafTU/DocumentController.php`
2. Cari line: `'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'`
3. Ubah `max:10240` (dalam KB) sesuai kebutuhan

Jangan lupa update di `php.ini`:
```ini
upload_max_filesize = 20M
post_max_size = 20M
```

---

## 🎨 Customization

### Ubah Logo/Branding
Edit: `resources/views/layouts/app.blade.php`
```php
<span class="text-xl font-semibold text-blue-600">
    Sistem PTK <!-- Ganti nama di sini -->
</span>
```

### Ubah Warna Theme
Edit: `resources/css/app.css`
```css
/* Primary color: Blue */
/* Ganti dengan warna pilihan Anda */
```

### Tambah Menu Sidebar
Edit: `resources/views/layouts/partials/sidebar.blade.php`
```php
<li>
    <a href="/custom-route" class="flex items-center p-2...">
        <!-- Icon -->
        <span class="ml-3">Menu Baru</span>
    </a>
</li>
```

---

## 📊 Backup & Restore

### Backup Database
```bash
# Backup
mysqldump -u root -p sistem_ptk > backup_ptk_$(date +%Y%m%d).sql

# Restore
mysql -u root -p sistem_ptk < backup_ptk_20241028.sql
```

### Backup Files
```bash
# Backup storage (dokumen & foto)
tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/app/public/
```

---

## 🚀 Deploy ke Production

### 1. Setup Server
- PHP 8.1+
- MySQL/PostgreSQL
- Composer
- Node.js

### 2. Clone & Setup
```bash
git clone <repo> /var/www/sistem-ptk
cd /var/www/sistem-ptk
composer install --optimize-autoloader --no-dev
npm install && npm run build
```

### 3. Environment
```bash
cp .env.example .env
# Edit .env sesuai production
php artisan key:generate
```

### 4. Permission
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data /var/www/sistem-ptk
```

### 5. Optimize
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6. Setup Nginx/Apache
Configure virtual host untuk point ke `/var/www/sistem-ptk/public`

---

## 📞 Need Help?

- 📖 **Full Documentation**: `SISTEM_PTK_DOCUMENTATION.md`
- 📝 **README**: `README.md`
- 🐛 **Issues**: Buat issue di repository

---

**Happy Coding! 🎉**

