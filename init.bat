@echo off
echo ====================================
echo Inicializando Sistema Universal Gold
echo ====================================
echo.

echo [0/5] Instalando dependencias de Composer (Livewire, QR, etc)...
composer install
echo.

echo [1/5] Ejecutando migraciones...
php artisan migrate --force
echo.

echo [2/5] Creando usuario administrador...
php artisan db:seed --class=AdminSeeder
echo.

echo [3/5] Creando enlace simbolico de storage...
php artisan storage:link
echo.

echo [4/5] Limpiando cache...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
echo.

echo [5/5] Compilando assets frontend...
call npm run build
echo.
php artisan config:clear
php artisan cache:clear
echo.

echo ====================================
echo ¡Inicializacion completada!
echo ====================================
echo.
echo Credenciales de administrador:
echo Email: admin@universalgold.com
echo Password: password
echo.
echo IMPORTANTE: Cambia la contraseña despues del primer inicio de sesion.
echo.
pause

