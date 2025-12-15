@echo off
echo ================================================
echo    SETUP MIDTRANS - SISTEM WISUDA
echo ================================================
echo.

echo [1] Cek konfigurasi Midtrans saat ini
echo [2] Update Midtrans credentials
echo [3] Test koneksi Midtrans
echo [4] Clear cache dan restart
echo [5] Buka Midtrans Dashboard
echo [0] Exit
echo.

set /p choice="Pilih menu (0-5): "

if "%choice%"=="1" goto check
if "%choice%"=="2" goto update
if "%choice%"=="3" goto test
if "%choice%"=="4" goto clear
if "%choice%"=="5" goto dashboard
if "%choice%"=="0" goto end

:check
echo.
echo === CEK KONFIGURASI MIDTRANS ===
echo.
php check_midtrans.php
echo.
pause
goto end

:update
echo.
echo === UPDATE MIDTRANS CREDENTIALS ===
echo.
echo Buka file .env dan isi:
echo.
echo MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxx
echo MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxx
echo MIDTRANS_IS_PRODUCTION=false
echo.
echo Cara mendapatkan credentials:
echo 1. Buka: https://dashboard.midtrans.com/
echo 2. Login
echo 3. Pilih "Sandbox" environment
echo 4. Settings -^> Access Keys
echo 5. Copy Server Key dan Client Key
echo.
notepad .env
echo.
echo Setelah save, jalankan menu [4] untuk clear cache
echo.
pause
goto end

:test
echo.
echo === TEST KONEKSI MIDTRANS ===
echo.
php artisan tinker --execute="echo 'Server Key: ' . substr(env('MIDTRANS_SERVER_KEY'), 0, 20) . '...'; echo PHP_EOL; echo 'Client Key: ' . substr(env('MIDTRANS_CLIENT_KEY'), 0, 20) . '...';"
echo.
pause
goto end

:clear
echo.
echo === CLEAR CACHE DAN RESTART ===
echo.
php artisan config:clear
php artisan cache:clear
php artisan view:clear
echo.
echo Cache cleared! Restart server Laravel:
echo 1. Stop server (Ctrl+C)
echo 2. Run: php artisan serve
echo.
pause
goto end

:dashboard
echo.
echo Membuka Midtrans Dashboard...
start https://dashboard.midtrans.com/
echo.
pause
goto end

:end
echo.
echo Terima kasih!
pause
