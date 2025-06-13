# 🌾 Capstone Project – Laravel-Based Dashboard for Sellers and Users + AI Integration

Sistem ini merupakan backend API berbasis Laravel untuk dashboard penjual dan user dalam konteks pertanian. Mendukung autentikasi manual & Google OAuth, pengelolaan produk, transaksi, keuangan petani, serta sistem rekomendasi berbasis AI.

## ⚙️ Teknologi
- Laravel 11
- JWT Authentication (manual)
- Google OAuth via Socialite
- AI Recommendation Engine
- RESTful API

## 🚀 Instalasi Lokal

```bash
git clone https://github.com/[USERNAME]/[REPO].git
cd [REPO]
composer install
cp .env.example .env
php artisan key:generate
```

Tambahkan variabel `.env`:

```env
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:3000
JWT_SECRET=your_secret_key
MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="DABE@example.com"
MAIL_FROM_NAME="${APP_NAME}"
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_LOGIN=http://127.0.0.1:8000/login/callback
GOOGLE_REDIRECT_REGISTER=http://127.0.0.1:8000/register/callback
```

Lalu migrasi dan seed:

```bash
php artisan migrate --seed
php artisan serve
```

## 🔐 Autentikasi

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `POST` | `/user/login` | Login manual |
| `POST` | `/user/register` | Register manual |
| `GET` | `/pending/verify/{id}` | Verifikasi email via link |
| `GET` | `/login/google` | Login via Google |
| `GET` | `/register/google` | Register via Google |
| `POST` | `/logout` | Logout JWT |

## 👤 Profil

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `POST` | `/profile/update` | Update data profil user (butuh token) |

## 🔑 Reset Password

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `POST` | `/password/forgot` | Kirim email reset |
| `POST` | `/password/reset` | Reset password |

## 📦 Produk

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET` | `/produk/list` | Semua produk |
| `GET` | `/produk/{id}` | Detail produk |
| `POST` | `/produk` | Tambah produk (role: petani) |
| `PUT` | `/produk/{id}` | Update produk |
| `DELETE` | `/produk/{id}` | Hapus produk |
| `GET` | `/produk/rekomendasi` | Produk rekomendasi AI |

## 🛒 Keranjang

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET` | `/keranjang` | Lihat isi keranjang |
| `POST` | `/tambah/keranjang` | Tambah produk ke keranjang |
| `DELETE` | `/keranjang/{id}` | Hapus item dari keranjang |

## ⭐ Ulasan Produk

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `POST` | `/produk/{id_produk}/ulasan` | Tambah ulasan (pembeli) |
| `PATCH` | `/ulasan/{id}` | Update ulasan |
| `GET` | `/produk/{id_produk}/ulasan` | Lihat semua ulasan |

## 💰 Transaksi

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET` | `/transaksi` | Semua transaksi |
| `GET` | `/transaksi/{id}` | Detail transaksi |
| `POST` | `/transaksi` | Tambah transaksi (pembeli) |

## 🧠 AI & Rekomendasi

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `POST` | `/search` | Simpan riwayat pencarian |
| `GET` | `/user/recommendations` | Rekomendasi produk berdasarkan perilaku |
| `GET` | `/data/produk` | Data produk untuk model AI |
| `GET` | `/data/histori` | Riwayat pencarian pengguna |

## 📈 Keuangan Petani

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET` | `/keuangan/saldo` | Lihat saldo saat ini |
| `GET` | `/keuangan/total` | Total pendapatan |
| `GET` | `/keuangan/per-bulan` | Pendapatan bulanan |
| `GET` | `/keuangan/riwayat` | Riwayat keuangan lengkap |

## 🌾 Lahan

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET` | `/lahan` | Semua data lahan |
| `GET` | `/lahan/{id}` | Detail lahan |
| `POST` | `/lahan` | Tambah lahan (login) |
| `PUT` | `/lahan/{id}` | Update data lahan |
| `DELETE` | `/lahan/{id}` | Hapus data lahan |
