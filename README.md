# FP-hotel-09
## Links
[FP-hotel-09](https://fountaine-hotel.great-site.net/)

### [Untuk menghindari error:]()

Warning: require(F:\xampp\htdocs\KELAS(11)\SEMESTER-1\PWB\clone\FP-hotel-09\vendor\composer/../symfony/polyfill-ctype/bootstrap.php): Failed to open stream: No such file or directory in F:\xampp\htdocs\KELAS(11)\SEMESTER-1\PWB\clone\FP-hotel-09\vendor\composer\autoload_real.php on line 41

Fatal error: Uncaught Error: Failed opening required 'F:\xampp\htdocs\KELAS(11)\SEMESTER-1\PWB\clone\FP-hotel-09\vendor\composer/../symfony/polyfill-ctype/bootstrap.php' (include_path='F:\xampp\php\PEAR') in F:\xampp\htdocs\KELAS(11)\SEMESTER-1\PWB\clone\FP-hotel-09\vendor\composer\autoload_real.php:41 Stack trace: #0 F:\xampp\htdocs\KELAS(11)\SEMESTER-1\PWB\clone\FP-hotel-09\vendor\composer\autoload_real.php(45): {closure}('320cde22f66dd4f...', 'F:\\xampp\\htdocs...') #1 F:\xampp\htdocs\KELAS(11)\SEMESTER-1\PWB\clone\FP-hotel-09\vendor\autoload.php(25): ComposerAutoloaderInit4880442d6debd2c687de4d213c9a4136::getLoader() #2 F:\xampp\htdocs\KELAS(11)\SEMESTER-1\PWB\clone\FP-hotel-09\connection\google_config.php(3): require_once('F:\\xampp\\htdocs...') #3 F:\xampp\htdocs\KELAS(11)\SEMESTER-1\PWB\clone\FP-hotel-09\index.php(6): require_once('F:\\xampp\\htdocs...') #4 {main} thrown in F:\xampp\htdocs\KELAS(11)\SEMESTER-1\PWB\clone\FP-hotel-09\vendor\composer\autoload_real.php on line 41

## jalankan perintah berikut di `terminal`:
```
composer dump-autoload
composer install
composer self-update
```

Untuk bisa menggunakan fitur Login dengan `Google` dan `GitHub` anda harus membuat:

+ `OAuth Apps GitHub` dan `OAuth Apps Google`
+ Setelah itu, kaian harus konfigurasi ulang `CLIENT_SECRET`, `CLIENT_ID` dan `Redirect uri` yang ada di file `google_config.php` **(untuk Google)**.
+ dan konfigurasi ulang `CLIENT_SECRET` dan `CLIENT_ID` yang ada di file `.env` **(untuk GitHub)**.
