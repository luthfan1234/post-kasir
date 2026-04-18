# 🚀 QPOS - Point of Sale System

**QPOS** adalah sistem kasir (Point of Sale) modern berbasis web yang dirancang untuk kecepatan, kemudahan penggunaan, dan estetika premium. Aplikasi ini telah diperbarui dengan tema **Sky Blue Minimalist** dan data lokal Indonesia.

---

## ✨ Fitur Utama
- **Dashboard Modern:** Pantau ringkasan penjualan dengan tampilan *Flat-Minimalist*.
- **Mesin Kasir (POS):** Transaksi cepat dengan fitur pencarian produk dan cetak struk.
- **Manajemen Inventaris:** Atur Produk, Kategori, Brand, dan Stok dengan mudah.
- **Akses Role & Permission:** Pembagian tugas untuk Admin, Kasir, dan Sales.
- **Laporan Lengkap:** Laporan penjualan, stok, dan ringkasan bisnis.
- **Global Loading State:** UX yang mulus dengan indikator loading modern.

---

## 🛠️ Persyaratan Sistem
- **Docker** & **Docker Compose**
- Browser Modern (Chrome, Edge, Firefox)

---

## 🚀 Cara Menjalankan Project (Docker)

1. **Clone Repository**
   ```bash
   git clone https://github.com/luthfan1234/post-kasir.git
   cd qpos
   ```

2. **Jalankan Docker Containers**
   ```bash
   docker-compose up -d
   ```

3. **Inisialisasi Database (Reset & Seed)**
   Jika ingin mereset database ke data awal Indonesia:
   ```bash
   docker exec -i qpos-app php artisan migrate:fresh --seed
   ```

4. **Akses Aplikasi**
   Buka browser dan navigasikan ke: **[http://localhost](http://localhost)**

---

## 🔑 Akun Login (Demo Data)

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `demo@qtecsolution.net` | `87654321` |
| **Kasir** | `cashier@gmail.com` | `12345678` |
| **Sales** | `sales@gmail.com` | `12345678` |

---

## 🎨 Teknologi yang Digunakan
- **Backend:** Laravel 10
- **Frontend:** HTML5, Vanilla CSS (Modern Theme), React (POS Components)
- **Database:** MySQL 8.0
- **Container:** Docker

---

## 📝 Catatan Pengembangan
Seluruh pengaturan visual terpusat pada file:
`public/css/modern-theme.css`

Jika Anda melakukan perubahan pada CSS atau JS, pastikan untuk melakukan **Hard Refresh (Ctrl + F5)** pada browser untuk melihat hasilnya.

---
*Dikembangkan dengan ❤️ untuk kemudahan bisnis Anda.*
