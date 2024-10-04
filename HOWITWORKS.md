# Database install
- [ CMD command]
### migration:
php artisan migrate --path=database\migrations\2024_09_17_042311_db_refinds1.php

### rollback db refinds
php artisan migrate:rollback --path=database\migrations\2024_09_17_042311_db_refinds1.php

### seeding db refinds
php artisan db:seed SeederDbRefinds
4. 

# CORS
1. Cross-Origin Resource Sharing (CORS)
install CORS In Laravel Project:
composer require fruitcake/laravel-cors

// Since your frontend and backend are likely running on different ports (e.g., Next.js on localhost:3000 and Laravel on localhost:8000), Laravel's CORS settings need to allow the frontend to communicate with the backend. 

# axios
1. Install axios in next.js project
npm install axios
// berfungsi untuk mengirim data registrasi kepada Backend Laravel

# Migration


# Sanctum
Otentikasi API dalam konteks ini adalah proses untuk memastikan bahwa seseorang yang mencoba mengakses aplikasi atau layanan Anda adalah benar-benar pengguna yang sah.

Sanctum adalah paket yang disediakan oleh Laravel untuk menangani otentikasi API menggunakan token

Method createToken(). This method is part of Laravel's Sanctum or Passport package for API token authentication, which allows you to create and manage API tokens for users.




