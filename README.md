# Sistema de Referidos - Universal Gold

Sistema completo de gestión de referidos para la joyería Universal Gold, desarrollado con Laravel 12, Livewire 3 y Tailwind CSS.

## Características

- ✅ Panel de administración con métricas y gestión de influencers
- ✅ Panel de influencer con dashboard personal y estadísticas
- ✅ Sistema de captura de leads mediante landing page pública
- ✅ Generación automática de cupones QR únicos
- ✅ Escáner QR para canjear cupones en tienda
- ✅ Registro de ventas con cálculo automático de comisiones
- ✅ Sistema de roles (Admin/Influencer)
- ✅ Diseño responsive con colores de marca Universal Gold

## Instalación

### 1. Instalar dependencias de PHP

```bash
composer install
```

Esto instalará:
- Livewire 3
- Simple QRCode

### 2. Instalar dependencias de Node.js

```bash
npm install
```

Esto instalará:
- html5-qrcode (para el escáner)

### 3. Configurar el entorno

Copia el archivo `.env.example` a `.env` (si no existe) y configura:

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Ejecutar migraciones

```bash
php artisan migrate
```

### 5. Crear usuario administrador

```bash
php artisan db:seed
```

Esto creará un usuario admin con:
- **Email:** admin@universalgold.com
- **Password:** password

**⚠️ IMPORTANTE:** Cambia la contraseña después del primer inicio de sesión.

### 6. Crear enlace simbólico para storage

```bash
php artisan storage:link
```

Esto permite que las imágenes QR sean accesibles públicamente.

### 7. Compilar assets

```bash
npm run build
```

O para desarrollo con hot reload:

```bash
npm run dev
```

### 8. Iniciar servidor

```bash
php artisan serve
```

## Uso del Sistema

### Como Administrador

1. Inicia sesión con las credenciales del seeder
2. Accede al **Dashboard** para ver métricas generales
3. Ve a **Influencers** para gestionar influencers:
   - Crear nuevos influencers
   - Editar porcentajes de comisión y descuento
   - Activar/desactivar influencers
4. Usa **Escanear QR** para:
   - Escanear cupones de clientes
   - Registrar ventas
   - Aplicar descuentos automáticamente

### Como Influencer

1. El admin te crea una cuenta
2. Inicia sesión con tus credenciales
3. En tu dashboard verás:
   - Tu código de referido y QR
   - Estadísticas de tus leads
   - Tus comisiones ganadas
   - Historial de ventas

### Para Clientes

1. El influencer comparte su link: `/r/{CODIGO}`
2. El cliente completa el formulario
3. Recibe un cupón único con QR
4. Presenta el QR en la tienda para obtener su descuento

## Estructura del Proyecto

```
app/
├── Http/Controllers/
│   ├── AuthController.php          # Autenticación
│   └── LandingController.php       # Landing pública
├── Livewire/
│   ├── Admin/
│   │   ├── Dashboard.php           # Dashboard admin
│   │   ├── InfluencerManager.php   # CRUD influencers
│   │   └── QrScanner.php           # Escáner y registro ventas
│   └── Influencer/
│       └── Dashboard.php           # Dashboard influencer
└── Models/
    ├── User.php                    # Usuarios (admin/influencer)
    ├── Lead.php                    # Leads/clientes potenciales
    ├── Coupon.php                  # Cupones
    └── Sale.php                    # Ventas

resources/views/
├── layouts/
│   ├── app.blade.php               # Layout principal
│   └── auth.blade.php              # Layout autenticación
├── admin/                          # Vistas admin
├── influencer/                     # Vistas influencer
├── landing/                        # Landing pública
└── livewire/                       # Componentes Livewire
```

## Colores de la Marca

- **Primario (Verde):** #1e5128
- **Secundario (Dorado):** #bc9313
- **Fondo:** #FFFFFF

## Tecnologías Utilizadas

- **Backend:** Laravel 12
- **Frontend:** Livewire 3, Tailwind CSS 4
- **QR Codes:** SimpleSoftwareIO/Simple-QrCode
- **QR Scanner:** html5-qrcode (JavaScript)
- **Base de Datos:** SQLite (configurado por defecto)

## Notas Importantes

1. **Permisos de Cámara:** El escáner QR requiere permisos de cámara del navegador
2. **Storage:** Asegúrate de ejecutar `php artisan storage:link` para que los QR sean accesibles
3. **Seguridad:** Cambia las credenciales por defecto en producción
4. **HTTPS:** Para usar la cámara, el sitio debe estar en HTTPS (o localhost)

## Desarrollo

Para desarrollo activo:

```bash
# Terminal 1: Servidor Laravel
php artisan serve

# Terminal 2: Vite (hot reload)
npm run dev
```

## Despliegue en Producción

### Checklist Pre-Despliegue

1. **Variables de Entorno**
   - Configura `.env` con `APP_ENV=production` y `APP_DEBUG=false`
   - Configura la base de datos de producción
   - Establece `APP_URL` con HTTPS

2. **Comandos en el Servidor**
   ```bash
   # Instalar dependencias (sin dev)
   composer install --optimize-autoloader --no-dev
   
   # Compilar assets
   npm install
   npm run build
   
   # Ejecutar migraciones
   php artisan migrate --force
   
   # Crear admin inicial
   php artisan db:seed --class=AdminSeeder
   
   # Optimizar Laravel
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   
   # Enlace simbólico de storage
   php artisan storage:link
   ```

3. **Permisos**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

4. **HTTPS (Importante)**
   - El escáner QR **requiere HTTPS** para funcionar
   - Configura SSL/TLS en tu servidor
   - Actualiza `APP_URL` en `.env` con `https://`

### Solución de Problemas de Certificados CA

Si encuentras errores de certificados CA durante el despliegue:

- El `composer.json` ya está configurado para usar los certificados del sistema
- En servidores Linux/Heroku, Composer usará automáticamente los certificados del sistema
- Si es necesario, puedes descargar certificados manualmente:
  ```bash
  curl -o cacert.pem https://curl.se/ca/cacert.pem
  export COMPOSER_CAFILE="$(pwd)/cacert.pem"
  ```

### Notas de Seguridad

- ✅ Cambia la contraseña del admin después del primer login
- ✅ Usa `APP_DEBUG=false` en producción
- ✅ Configura HTTPS para el escáner QR
- ✅ Revisa permisos de archivos y directorios

## Licencia

Proyecto desarrollado para Universal Gold.
