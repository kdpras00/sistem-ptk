# 📚 Dokumentasi Sistem Pengarsipan PTK

## Deskripsi Sistem
Sistem Pengarsipan PTK (Pendidikan dan Tenaga Kependidikan) adalah aplikasi web berbasis Laravel yang dirancang untuk mengelola data dan dokumen PTK di lingkungan sekolah. Sistem ini mengimplementasikan role-based access control dengan 4 aktor utama.

---

## 🎭 Aktor dan Hak Akses

### 1. **Admin**
**Hak Akses:**
- ✅ Login ke sistem
- ✅ Kelola Data PTK (Create, Read, Update, Delete)
- ✅ Kelola Kategori Dokumen (CRUD)
- ✅ Pencarian & Filter Data PTK
- ✅ Melihat statistik dan aktivitas sistem

**Use Cases:**
- Menambah data PTK baru beserta akun login
- Mengubah informasi PTK yang sudah ada
- Menghapus data PTK
- Mengelola kategori dokumen (ijazah, SK, sertifikat, dll)
- Monitoring aktivitas sistem

### 2. **Staf TU (Tata Usaha)**
**Hak Akses:**
- ✅ Login ke sistem
- ✅ Mengunggah Dokumen PTK
- ✅ Mengelola Dokumen (Create, Read, Update, Delete)
- ✅ Cetak Laporan Pengarsipan
- ✅ Pencarian & Filter Dokumen

**Use Cases:**
- Upload dokumen PTK (format: PDF, DOC, DOCX, JPG, PNG)
- Edit metadata dokumen
- Download dokumen
- Generate laporan pengarsipan dengan filter kategori dan tanggal
- Hapus dokumen yang tidak diperlukan

### 3. **Guru**
**Hak Akses:**
- ✅ Login ke sistem
- ✅ Melihat Data Diri (Read-only)
- ✅ Melihat Dokumen Terkait

**Use Cases:**
- Melihat informasi pribadi (NIP, NUPTK, alamat, dll)
- Melihat data kepegawaian (jabatan, pangkat/golongan, TMT)
- Melihat daftar dokumen yang berkaitan dengan dirinya

### 4. **Kepala Sekolah**
**Hak Akses:**
- ✅ Login ke sistem
- ✅ Melihat Data Semua PTK
- ✅ Pencarian & Filter Data PTK
- ✅ Melihat Detail PTK dan Dokumennya
- ❌ Tidak dapat mencetak laporan (revisi dari diagram)

**Use Cases:**
- Monitoring jumlah dan status kepegawaian PTK
- Melihat detail lengkap setiap PTK
- Pencarian PTK berdasarkan nama, NIP, jabatan
- Filter PTK berdasarkan status kepegawaian

---

## 🗄️ Struktur Database

### 1. **users**
Tabel untuk menyimpan akun login semua pengguna sistem.

| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint (PK) | ID user |
| name | varchar | Nama lengkap |
| email | varchar (unique) | Email untuk login |
| password | varchar | Password terenkripsi |
| role | enum | admin, staf_tu, guru, kepala_sekolah |
| is_active | boolean | Status aktif akun |
| created_at | timestamp | - |
| updated_at | timestamp | - |

### 2. **ptk**
Tabel untuk menyimpan data lengkap PTK.

| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint (PK) | ID PTK |
| user_id | bigint (FK) | Relasi ke users |
| nip | varchar (unique) | Nomor Induk Pegawai |
| nama_lengkap | varchar | Nama lengkap PTK |
| nuptk | varchar | Nomor Unik PTK |
| jenis_kelamin | enum | L / P |
| tanggal_lahir | date | - |
| tempat_lahir | varchar | - |
| alamat | text | Alamat lengkap |
| no_telepon | varchar | - |
| email | varchar | Email PTK |
| status_kepegawaian | enum | PNS, PPPK, GTT, PTT, Honorer |
| jabatan | varchar | Jabatan (Guru, Staf, dll) |
| pangkat_golongan | varchar | - |
| tmt_pengangkatan | date | Terhitung Mulai Tanggal |
| pendidikan_terakhir | varchar | S1, S2, dll |
| jurusan | varchar | - |
| foto | varchar | Path foto profil |
| created_at | timestamp | - |
| updated_at | timestamp | - |

**Relasi:**
- `belongsTo` → User
- `hasMany` → Document

### 3. **categories**
Tabel untuk menyimpan kategori dokumen.

| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint (PK) | ID kategori |
| nama_kategori | varchar | Nama kategori |
| deskripsi | text | Deskripsi kategori |
| kode_kategori | varchar (unique) | Kode unik kategori |
| is_active | boolean | Status aktif |
| created_at | timestamp | - |
| updated_at | timestamp | - |

**Contoh Kategori:**
- SK Pengangkatan (kode: SK-001)
- Ijazah (kode: IJZ-001)
- Sertifikat Pendidik (kode: SRT-001)
- Surat Keputusan (kode: SK-002)
- dll

**Relasi:**
- `hasMany` → Document

### 4. **documents**
Tabel untuk menyimpan dokumen PTK.

| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint (PK) | ID dokumen |
| ptk_id | bigint (FK) | Relasi ke PTK |
| category_id | bigint (FK) | Relasi ke kategori |
| uploaded_by | bigint (FK) | User yang upload (Staf TU) |
| nomor_dokumen | varchar (unique) | Nomor dokumen |
| nama_dokumen | varchar | Nama dokumen |
| deskripsi | text | Deskripsi dokumen |
| file_path | varchar | Path file di storage |
| file_name | varchar | Nama file asli |
| file_type | varchar | Ekstensi file |
| file_size | integer | Ukuran file (bytes) |
| tanggal_dokumen | date | Tanggal dokumen dibuat |
| tanggal_upload | date | Tanggal upload ke sistem |
| status | enum | aktif, arsip, dihapus |
| created_at | timestamp | - |
| updated_at | timestamp | - |

**Relasi:**
- `belongsTo` → PTK
- `belongsTo` → Category
- `belongsTo` → User (uploader)

### 5. **activity_logs**
Tabel untuk mencatat semua aktivitas di sistem.

| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint (PK) | ID log |
| user_id | bigint (FK) | User yang melakukan aksi |
| activity_type | varchar | create, update, delete, view, upload, download, login, logout |
| model_type | varchar | Jenis model (PTK, Document, Category) |
| model_id | bigint | ID model terkait |
| description | text | Deskripsi aktivitas |
| properties | json | Data before & after |
| ip_address | varchar | IP address user |
| user_agent | varchar | Browser/device info |
| created_at | timestamp | - |
| updated_at | timestamp | - |

**Relasi:**
- `belongsTo` → User

---

## 🔐 Authentication & Authorization

### Middleware: RoleMiddleware
Middleware untuk memvalidasi role pengguna.

```php
// Penggunaan di routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Routes untuk admin
});

Route::middleware(['auth', 'role:staf_tu'])->group(function () {
    // Routes untuk staf TU
});
```

### Helper Methods di Model User
```php
$user->isAdmin()          // Check if admin
$user->isStafTU()         // Check if staf TU
$user->isGuru()           // Check if guru
$user->isKepalaSekolah()  // Check if kepala sekolah
$user->hasRole('admin')   // Generic role check
```

---

## 🛣️ Route Structure

### Public Routes
```
GET  /login              → LoginController@showLoginForm
POST /login              → LoginController@login
POST /logout             → LoginController@logout
```

### Admin Routes
Prefix: `/admin`
```
GET    /admin/dashboard           → Admin\DashboardController@index
Resource /admin/ptk               → Admin\PTKController (CRUD)
Resource /admin/categories        → Admin\CategoryController (CRUD)
```

### Staf TU Routes
Prefix: `/staf-tu`
```
GET    /staf-tu/dashboard               → StafTU\DashboardController@index
Resource /staf-tu/documents             → StafTU\DocumentController (CRUD)
GET    /staf-tu/documents/{id}/download → StafTU\DocumentController@download
GET    /staf-tu/report                  → StafTU\DocumentController@report
```

### Guru Routes
Prefix: `/guru`
```
GET    /guru/dashboard  → Guru\DashboardController@index (View data diri)
```

### Kepala Sekolah Routes
Prefix: `/kepala-sekolah`
```
GET    /kepala-sekolah/dashboard     → KepalaSekolah\DashboardController@index
GET    /kepala-sekolah/ptk/{id}      → KepalaSekolah\DashboardController@showPTK
```

---

## 🎨 UI/UX Design

### Framework: Tailwind CSS + Flowbite
- **Tailwind CSS v4**: Utility-first CSS framework
- **Flowbite**: Component library dengan komponen siap pakai

### Komponen Utama:
1. **Login Page**: Modern gradient design dengan card
2. **Dashboard**: Stats cards, charts, tables
3. **Data Tables**: Dengan pagination, search, filter
4. **Forms**: Validation, file upload, datepicker
5. **Modals**: Untuk konfirmasi delete, preview
6. **Alerts**: Success, error, warning notifications
7. **Sidebar Navigation**: Responsive, collapsible

### Color Scheme:
- **Primary**: Blue (#2563eb)
- **Success**: Green (#10b981)
- **Warning**: Yellow (#f59e0b)
- **Danger**: Red (#ef4444)
- **Background**: Gray (#f9fafb)

---

## 📊 Fitur Unggulan

### 1. Pencarian & Filter
- Search by: NIP, Nama, NUPTK, Jabatan
- Filter by: Status Kepegawaian, Jenis Kelamin, Kategori Dokumen
- Real-time search dengan AJAX (opsional)

### 2. Activity Logging
Semua aktivitas penting dicatat:
- Login/Logout
- CRUD PTK
- Upload/Download Dokumen
- Perubahan Kategori

### 3. File Management
- Upload file: PDF, DOC, DOCX, JPG, PNG
- Max size: 10MB
- Storage path: `storage/app/public/documents/`
- Auto-generate unique filename

### 4. Laporan
- Filter by: Kategori, Rentang Tanggal
- Format: HTML (ready to print)
- Include: Nomor, Nama, Kategori, Tanggal

---

## 🔄 Alur Sistem

### Alur Login
```
1. User buka halaman login
2. Input email & password
3. System validasi credentials
4. Jika valid & active:
   - Create session
   - Log activity (login)
   - Redirect berdasarkan role:
     * Admin → /admin/dashboard
     * Staf TU → /staf-tu/dashboard
     * Guru → /guru/dashboard
     * Kepala Sekolah → /kepala-sekolah/dashboard
5. Jika invalid: tampilkan error
```

### Alur CRUD PTK (Admin)
```
CREATE:
1. Admin klik "Tambah PTK"
2. Isi form data PTK + data akun
3. Upload foto (opsional)
4. Submit → Validasi
5. Create User + Create PTK
6. Log activity
7. Redirect dengan success message

UPDATE:
1. Admin klik "Edit" pada data PTK
2. Form terisi data existing
3. Ubah data yang diperlukan
4. Submit → Validasi
5. Update User + Update PTK
6. Log activity
7. Redirect dengan success message

DELETE:
1. Admin klik "Hapus"
2. Konfirmasi delete
3. Delete foto (jika ada)
4. Log activity
5. Delete PTK (cascade ke User)
6. Redirect dengan success message
```

### Alur Upload Dokumen (Staf TU)
```
1. Staf TU klik "Upload Dokumen"
2. Pilih PTK dari dropdown
3. Pilih Kategori dokumen
4. Isi metadata (nomor, nama, tanggal, deskripsi)
5. Upload file
6. Submit → Validasi:
   - File type valid?
   - File size < 10MB?
   - Nomor dokumen unique?
7. Simpan file ke storage
8. Create record di database
9. Log activity (upload)
10. Redirect dengan success message
```

### Alur Cetak Laporan (Staf TU)
```
1. Staf TU buka halaman "Cetak Laporan"
2. Set filter (kategori, rentang tanggal)
3. Klik "Generate Laporan"
4. System query dokumen sesuai filter
5. Log activity (report)
6. Tampilkan halaman laporan (print-friendly)
7. User bisa print via browser (Ctrl+P)
```

### Alur View Data Diri (Guru)
```
1. Guru login
2. Auto redirect ke dashboard
3. System load data PTK berdasarkan user_id
4. Tampilkan:
   - Data pribadi (NIP, nama, alamat, dll)
   - Data kepegawaian (jabatan, status, TMT)
   - Daftar dokumen terkait
5. Guru hanya bisa view (read-only)
```

### Alur View PTK (Kepala Sekolah)
```
DASHBOARD:
1. Kepala Sekolah login
2. Tampilkan statistik:
   - Total PTK
   - Total Dokumen
   - PTK by Status Kepegawaian
3. Tampilkan tabel daftar PTK
4. Search & filter available

DETAIL PTK:
1. Kepala Sekolah klik "Detail" pada PTK
2. Tampilkan:
   - Foto & info dasar
   - Data pribadi lengkap
   - Data kepegawaian
   - Daftar dokumen
3. Read-only (tidak bisa edit/delete)
```

---

## 🚀 Instalasi & Setup

### 1. Requirements
- PHP >= 8.1
- Composer
- MySQL/PostgreSQL
- Node.js & NPM

### 2. Installation Steps

```bash
# Clone repository
git clone <repo-url>
cd sistemPTK

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database di .env
DB_DATABASE=sistem_ptk
DB_USERNAME=root
DB_PASSWORD=

# Run migrations
php artisan migrate

# Create storage link
php artisan storage:link

# Build assets
npm run build

# Run development server
php artisan serve
```

### 3. Seeder (Optional)
Buat seeder untuk data awal:
```bash
php artisan make:seeder UserSeeder
php artisan make:seeder CategorySeeder
php artisan db:seed
```

### 4. Default Accounts
Buat akun default untuk testing:

**Admin:**
- Email: admin@ptk.com
- Password: admin123
- Role: admin

**Staf TU:**
- Email: staftu@ptk.com
- Password: staftu123
- Role: staf_tu

**Guru:**
- Email: guru@ptk.com
- Password: guru123
- Role: guru

**Kepala Sekolah:**
- Email: kepsek@ptk.com
- Password: kepsek123
- Role: kepala_sekolah

---

## 📝 Catatan Penting

### Security
1. **Password**: Gunakan Hash::make() untuk enkripsi
2. **CSRF Protection**: Semua form harus include @csrf
3. **Middleware**: Pastikan semua routes protected dengan auth & role
4. **File Upload**: Validasi file type & size
5. **SQL Injection**: Gunakan Eloquent/Query Builder (avoid raw SQL)

### Performance
1. **Eager Loading**: Gunakan with() untuk prevent N+1 query
2. **Pagination**: Limit data per halaman (10-20 items)
3. **Image Optimization**: Compress foto sebelum upload
4. **Caching**: Consider cache untuk data statistik

### Best Practices
1. **Validation**: Selalu validasi input user
2. **Error Handling**: Gunakan try-catch untuk operasi critical
3. **Logging**: Log semua aktivitas penting
4. **Backup**: Regular backup database & files
5. **Testing**: Write tests untuk fitur critical

---

## 🐛 Troubleshooting

### Error: "Class 'Flowbite' not found"
```bash
# Flowbite diload via CDN, tidak perlu install via npm
# Pastikan ada di layout:
<link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" />
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
```

### Error: "Storage link not found"
```bash
php artisan storage:link
```

### Error: "Permission denied" saat upload
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## 📞 Support

Untuk pertanyaan atau issues, silakan hubungi:
- Email: support@ptk.com
- Documentation: /docs

---

**© 2024 Sistem Pengarsipan PTK. All rights reserved.**

