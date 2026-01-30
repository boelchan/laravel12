# Project StarterKit Livewire versi ramah lingkungan
Dalam project ini sudah tersedia manajemen user, role, dan permission. Anda cukup mengisi kontennya saja. dengan beberapa custom component menyerupai FLUXUI

## Stack
- TALL Stack

## Requirement
- PHP 8.3

## Cara Instalasi
Jalankan perintah berikut untuk menyiapkan project:

```bash
composer install
npm install
npm run dev
cp .env.example .env
php artisan migrate:fresh --seed
php artisan serve
```