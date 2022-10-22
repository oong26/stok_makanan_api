# stok_makanan_api

Api ini digunakan untuk mengkoneksikan antara Flutter dan SqlServer

## Cara konfigurasi

1. Pastikan sudah menginstal xampp, jika belum harap download dan install : [Download](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.4.30/xampp-windows-x64-7.4.30-1-VC15-installer.exe/download)
2. Setelah itu copy semua file yang ada di folder konfigurasi & paste di dalam folder xampp/php/ext
3. Masuk ke folder xampp/php/ kemudian cari file php.ini lalu buka file tersebut
3. Import library ke dalam file php.ini
    - extension=php_sqlsrv.dll
    - extension=php_pdo_sqlsrv.dll
4. Save php.ini & close
5. Buka aplikasi xampp control panel
6. Start apache server
7. Enjoy!!
