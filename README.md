# Project StarterKit Livewire
Dalam project ini sudah tersedia manajemen user, role, dan permission. Anda cukup mengisi kontennya saja.

## Teknologi
- Livewire 4
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