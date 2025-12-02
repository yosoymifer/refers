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

## Licencia

Proyecto desarrollado para Universal Gold.
