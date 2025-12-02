# Instrucciones de Inicio Rápido

## Para ejecutar las migraciones y crear el usuario administrador:

### Opción 1: Desde Laragon (Recomendado)

1. Abre Laragon
2. Haz clic derecho en el proyecto "refers"
3. Selecciona "Terminal" o "Open Terminal Here"
4. Ejecuta los siguientes comandos uno por uno:

```bash
php artisan migrate --force
php artisan db:seed --class=AdminSeeder
php artisan storage:link
```

### Opción 2: Usando el script automático

1. Doble clic en el archivo `init.bat` en la raíz del proyecto
2. Esto ejecutará automáticamente todas las migraciones y creará el usuario

### Opción 3: Desde la terminal de Laragon

Si tienes acceso a la terminal de Laragon con PHP en el PATH:

```bash
cd F:\laragon\www\refers
php artisan migrate --force
php artisan db:seed --class=AdminSeeder
php artisan storage:link
```

## Credenciales de Acceso

Después de ejecutar el seeder, podrás iniciar sesión con:

- **Email:** `admin@universalgold.com`
- **Password:** `password`

⚠️ **IMPORTANTE:** Cambia la contraseña después del primer inicio de sesión por seguridad.

## Si el usuario ya existe

El seeder está configurado para actualizar el usuario existente y restablecer la contraseña a "password" si ya existe, así que puedes ejecutarlo de nuevo sin problemas.

## Verificar que funcionó

Después de ejecutar los comandos, intenta iniciar sesión nuevamente. Si aún no funciona, verifica:

1. Que las migraciones se ejecutaron correctamente (no debería haber errores)
2. Que el seeder se ejecutó sin errores
3. Que estás usando exactamente: `admin@universalgold.com` y `password`

