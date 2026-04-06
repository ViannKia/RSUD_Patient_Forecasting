# 🏥 SISTEM PERAMALAN JUMLAH PASIEN RUMAH SAKIT

![Laravel](https://img.shields.io/badge/Laravel-11.x-red?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple?logo=bootstrap)
![jQuery](https://img.shields.io/badge/jQuery-3.6-lightblue?logo=jquery)
![Excel Import](https://img.shields.io/badge/Excel_Import-Dropzone-blueviolet)
![ApexCharts](https://img.shields.io/badge/ApexCharts-3.x-FF6384?logo=apexcharts)

## 📋 Tentang Project

Sistem peramalan jumlah pasien rumah sakit menggunakan **metode Trend Moment** untuk membantu rumah sakit dalam :

- 📊 Perencanaan kapasitas ruangan
- 👨‍⚕️ Pengaturan jadwal dokter dan perawat
- 💊 Manajemen stok obat dan logistik
- 📈 Optimalisasi sumber daya rumah sakit

## ✨ Fitur Utama

- 🔐 **Autentikasi Multi-User** (Admin, Staff)
- 📅 **Input Data Pasien Bulanan** (rawat inap & rawat jalan)
- 📈 **Visualisasi Data** dengan grafik interaktif
- 🤖 **Prediksi Jumlah Pasien** menggunakan Trend Moment
- 📊 **Dashboard Analisis** performa rumah sakit
- 📑 **Laporan Excel/PDF** untuk manajemen

## 🛠️ Tech Stack

| Kategori | Teknologi |
|----------|-----------|
| **Backend** | Laravel 11, PHP 8.2 |
| **Database** | MySQL 8.0 |
| **Frontend** | Blade, Bootstrap 5, JavaScript |
| **Library** | ApexCharts, SweetAlert2, ParsleyJS, Dropzone, DataTables |

## 🚀 Cara Menjalankan

```bash
# Clone repository
git clone https://github.com/ViannKia/RSUD_Patient_Forecasting.git

# Masuk ke folder project
cd RSUD_Patient_Forecasting

# Install dependensi
composer install

# Copy file environment
copy .env.example .env

# Generate key
php artisan key:generate

# Setup database (edit .env dulu)
php artisan migrate --seed

# Jalankan server
php artisan serve

```

## 👨‍💻 Author

**Adrianus Vianto Eban Kia**

- GitHub: [@ViannKia](https://github.com/ViannKia)
- LinkedIn: [@ViannKia](https://linkedin.com/in/viannkia)

## 📄 License

MIT License - Copyright (c) 2025 Adrianus Vianto Eban Kia
