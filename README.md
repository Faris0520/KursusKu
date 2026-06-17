# KursusKu - Platform Kursus Online

<img width="900" alt="Screenshot" src="https://github.com/user-attachments/assets/0dbfd6c3-bc49-44cf-9883-d2b662c6ba7a">
<br></br>

Platform kursus online berbasis Laravel 12 yang menghubungkan **Siswa**, **Mentor**, dan **Admin** dalam satu ekosistem pembelajaran. Mendukung kursus gratis maupun berbayar (via **Midtrans Sandbox**), dengan materi video YouTube + PDF, kuis pilihan ganda auto-grade, dan sistem review.

Dibangun sebagai project UAS mata kuliah **Pemrograman Berbasis Platform**.

---

## Fitur Utama

### Autentikasi
- Register sebagai **siswa** atau **mentor** (tanpa verifikasi email)
- Login / logout
- Redirect otomatis sesuai role setelah login

### Untuk Siswa
- **Browse & search kursus** dengan filter kategori dan status gratis/berbayar
- **Detail kursus**: deskripsi, list materi, dan review
- **Enroll kursus gratis** -- langsung terdaftar
- **Beli kursus berbayar** via Midtrans Snap
- **Akses materi** berupa video YouTube embed + download PDF
- **Kerjakan kuis pilihan ganda** dengan auto-grade dan langsung lihat score
- **Tulis review & rating** (1-5) untuk kursus yang sudah di-enroll
- **Dashboard**: daftar kursus saya + riwayat transaksi
- **Navigasi prev/next** antar materi

### Untuk Mentor
- Wajib **diverifikasi admin** sebelum bisa membuat kursus
- **CRUD kursus**: judul, deskripsi, harga, thumbnail, status draft/published
- **CRUD materi per kursus**: YouTube URL + upload PDF + atur urutan
- **CRUD kuis & soal pilihan ganda** (4 opsi + kunci jawaban) per kursus
- Lihat **daftar peserta** per kursus
- Lihat **review** dari siswa
- **Dashboard** dengan statistik kursus dan peserta

### Untuk Admin
- **Dashboard** statistik: jumlah user, kursus, transaksi, enrollment
- **Manajemen user**: list, search, filter role, ubah role, hapus
- **Verifikasi mentor**: approve / reject pendaftar mentor
- **CRUD kategori** kursus
- **Monitoring transaksi** seluruh platform

---

## Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| **Framework** | Laravel 12.x |
| **PHP** | ^8.2 |
| **Database** | MySQL (default project) |
| **Frontend** | Blade + Tailwind CSS 3.x + Alpine.js |
| **Build Tool** | Vite 7 |
| **Authentication** | Laravel Breeze |
| **Authorization** | Spatie Laravel Permission |
| **Payment Gateway** | Midtrans Snap (Sandbox) |
| **Testing** | PHPUnit 11 |

---

## Instalasi

### Prasyarat
- **PHP** >= 8.2
- **Composer**
- **Node.js** & **NPM**
- **MySQL** (atau MariaDB)
- **Akun Midtrans Sandbox** (untuk payment gateway)

### Langkah Instalasi

1. **Clone repository & masuk folder**
   ```bash
   git clone <repository-url>
   cd project-uas
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database di `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kursusku
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Lalu buat database `kursusku` di MySQL.

5. **Konfigurasi Midtrans Sandbox di `.env`**
   ```env
   MIDTRANS_SERVER_KEY=your-sandbox-server-key
   MIDTRANS_CLIENT_KEY=your-sandbox-client-key
   MIDTRANS_IS_PRODUCTION=false
   ```

6. **Migrasi dan seeding**
   ```bash
   php artisan migrate --seed
   ```

7. **Build frontend & jalankan server**
   ```bash
   npm run build
   php artisan serve
   ```
   Akses: **http://localhost:8000**

   Untuk development dengan hot reload:
   ```bash
   composer run dev
   ```

---

## Development

### Menjalankan semua service sekaligus
```bash
composer run dev
```
Menjalankan bersamaan: web server, queue worker, log viewer (pail), dan Vite dev server.

### Testing
```bash
php artisan test
# atau
vendor/bin/phpunit
```

### Code style
```bash
vendor/bin/pint
```

### Artisan commands berguna
```bash
php artisan migrate:fresh --seed   # Reset DB + seed ulang
php artisan route:list             # Lihat semua route
php artisan storage:link           # Symlink storage (untuk upload PDF/thumbnail)
php artisan tinker                 # Interactive shell
```

---

## Struktur Project

```
project-uas/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/             # Dashboard, User, Category, MentorVerification, Transaction
│   │   │   ├── Mentor/            # Dashboard, Course, Lesson, Quiz, Question
│   │   │   ├── Siswa/             # Dashboard, Learning, Quiz, Review
│   │   │   ├── Auth/              # Breeze auth controllers
│   │   │   ├── CourseController.php       # Publik: browse & detail
│   │   │   ├── EnrollmentController.php   # Enroll gratis
│   │   │   ├── TransactionController.php  # Midtrans integration
│   │   │   └── HomeController.php         # Landing page
│   │   └── Middleware/
│   │       ├── RoleMiddleware.php
│   │       └── VerifiedMentorMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Course.php
│       ├── Category.php
│       ├── Lesson.php
│       ├── Quiz.php
│       ├── Question.php
│       ├── QuizAttempt.php
│       ├── Enrollment.php
│       ├── Transaction.php
│       └── Review.php
├── database/
│   ├── migrations/                # 10 domain tables + 5 Spatie tables
│   ├── seeders/                   # CourseSeeder, PermissionSeeder, DatabaseSeeder
│   └── factories/
├── resources/
│   └── views/                     # Blade templates
├── routes/
│   ├── web.php                    # Route utama (public + per role)
│   ├── auth.php                   # Breeze auth routes
│   └── console.php
├── tests/
│   ├── Feature/                   # Auth, Profile, Registration, dll
│   └── Unit/
├── config/
│   ├── midtrans.php
│   └── permission.php
├── docs/
│   ├── prd.md                     # Product Requirements Document
│   ├── erd.dbml                   # Entity Relationship Diagram
│   └── design.md                  # Design system Upskill
└── public/
    └── css/welcome.css            # CSS landing page
```

---

## Database Schema

10 tabel domain + 5 tabel dari Spatie Laravel Permission.

### Domain Tables

| Tabel | Deskripsi |
|-------|-----------|
| `users` | User dengan field `role` (admin/mentor/siswa), `is_verified`, `avatar`, `bio` |
| `categories` | Kategori kursus (slug unik) |
| `courses` | Kursus: mentor, kategori, harga (0 = gratis), thumbnail, status draft/published |
| `lessons` | Materi: `youtube_url`, `pdf_path` (opsional), `order` |
| `enrollments` | Relasi siswa-kursus (unique: 1 siswa 1 enroll per kursus) |
| `transactions` | Catatan pembayaran Midtrans: `midtrans_order_id`, status pending/paid/failed/expired |
| `quizzes` | Kuis per kursus |
| `questions` | Soal pilihan ganda: option a/b/c/d + `correct_answer` |
| `quiz_attempts` | Hasil pengerjaan: `score`, `total_questions`, `completed_at` |
| `reviews` | Rating 1-5 + komentar (unique: 1 siswa 1 review per kursus) |

### Spatie Tables
`roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`.

---

## Role & Hak Akses

| Role | Prefix Route | Middleware | Status |
|------|--------------|------------|--------|
| **Admin** | `/admin/*` | `auth`, `role:admin` | Langsung aktif |
| **Mentor** | `/mentor/*` | `auth`, `role:mentor` | Butuh `verified_mentor` untuk akses dashboard & buat kursus |
| **Siswa** | `/siswa/*` | `auth`, `role:siswa` | Langsung aktif |

**Catatan:** Mentor yang baru register otomatis berstatus `is_verified = false` dan di-redirect ke halaman `mentor.pending` sampai admin approve.

---

## Payment Flow (Midtrans Sandbox)

```
Siswa klik "Beli Kursus"
   |
   v
Backend buat transaction (pending) + request Snap token
   |
   v
Frontend tampilkan Midtrans Snap popup
   |
   v
Siswa bayar (test credentials)
   |
   v
Midtrans kirim callback ke /api/midtrans/callback
   |
   v
Backend update status -> jika paid, auto-buat enrollment
   |
   v
Siswa bisa akses materi kursus
```

- **Kursus gratis** -> klik "Daftar Gratis" -> langsung enrollment, tanpa transaksi.
- **Kursus berbayar** -> lewat flow Midtrans di atas.
- **Transaksi pending/expired** -> siswa bisa resume dari halaman Riwayat Transaksi.

---

## Design System

Halaman beranda (landing page) menggunakan desain sederhana dengan fokus pada UX dan aksesibilitas. Berikut beberapa elemen desain utama:

- **Font**: Inter (400, 500, 600, 700, 800)
- **Primary**: `#2563eb` (biru), **CTA gradient**: `#1e40af -> #2563eb -> #1d4ed8`
- **Aksen**: Orange `#f97316` (badge Beginner), Yellow `#fde047` (highlight), Star `#f59e0b`
- **Max width container**: 1200px, padding 24px
- **Breakpoints**: 1024px, 900px, 600px (mobile-first)
- **CSS**: `public/css/welcome.css`

---

## Halaman

### Public (tanpa login)
- Landing page (hero, kursus populer, kategori)
- Daftar kursus (search, filter)
- Detail kursus
- Login & Register

### Siswa (auth)
- Dashboard siswa
- Halaman belajar (video + sidebar materi)
- Halaman quiz
- Hasil quiz
- Riwayat transaksi

### Mentor (auth + verified)
- Halaman pending (jika belum diverifikasi)
- Dashboard mentor
- CRUD kursus
- Kelola materi & quiz

### Admin (auth)
- Dashboard admin
- Kelola user, verifikasi mentor, CRUD kategori
- Monitoring transaksi

---

## Lisensi

Project ini dibuat untuk keperluan **UAS (Ujian Akhir Semester)**. Bebas digunakan untuk pembelajaran.

---

## Credits

- Built with [Laravel](https://laravel.com)
- Authentication by [Laravel Breeze](https://laravel.com/docs/starter-kits#breeze)
- Authorization by [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- Payment Gateway by [Midtrans](https://midtrans.com)
