

# Sekolah App

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat-square&logo=php)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql)](https://www.mysql.com/)
[![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-06B6D4?style=flat-square&logo=tailwindcss)](https://tailwindcss.com/)
[![Vite](https://img.shields.io/badge/Vite-646CFF?style=flat-square&logo=vite)](https://vitejs.dev/)
[![Pest](https://img.shields.io/badge/Pest-000000?style=flat-square)](https://pestphp.com/)
[![Midtrans](https://img.shields.io/badge/Midtrans-0080FF?style=flat-square)](https://midtrans.com/)
[![License: MIT](https://img.shields.io/badge/License-MIT-success.svg)](LICENSE)

> Sistema de Gestión de Información Escolar basado en Laravel 12 que apoya la gestión académica, asistencia, finanzas, y el pago de SPP (cuotas escolares) de forma integrada utilizando Midtrans.

Sekolah App es el resultado del desarrollo del proyecto **Pesantren App** que ha sido renombrado y desarrollado aún más para satisfacer las necesidades de administración escolar moderna.

---

# Destacados

- Multirol (Admin, Profesor, Estudiante)
- Dashboard de Estadísticas
- Gestión de Datos Escolares
- Importación de Datos Excel
- Recapitulación de Asistencia
- Pago de SPP en Línea
- Integración Midtrans Snap
- Laravel 12 + Vite + Tailwind CSS

---

# Estado del Proyecto

| Componente | Estado |
|----------|--------|
| Desarrollo | 🟢 Activo |
| Pruebas | 🟢 En curso |
| Documentación | 🟢 Completa |
| Midtrans | 🟢 Integrado |

---

# Capturas de Pantalla

| Dashboard | Datos de Estudiantes | SPP |
|-----------|------------|-----|
| TODO | TODO | TODO |

---

# Tabla de Contenidos

- [Características](#fitur)
- [Tecnologías](#tech-stack)
- [Desarrollado con](#built-with)
- [Arquitectura](#arsitektur)
- [Estructura de Carpetas](#struktur-folder)
- [Roles y Permisos](#role--permission)
- [Requisitos del Sistema](#persyaratan-sistem)
- [Instalación](#instalasi)
- [Configuración del Entorno](#konfigurasi-environment)
- [Base de Datos](#database)
- [Ejecutar en Desarrollo](#menjalankan-development)
- [Ejecutar en Producción](#menjalankan-production)
- [Pruebas](#testing)
- [Flujo de Pago](#payment-flow)
- [Flujo de Trabajo de Desarrollo](#development-workflow)
- [Hoja de Ruta](#roadmap)
- [Contribuidores](#kontributor)
- [Licencia](#license)

---

# Características

## Admin

- Dashboard
- CRUD de Datos de Estudiantes
- CRUD de Datos de Profesores
- CRUD de Materias
- CRUD de Horarios de Clases
- CRUD de Asistencia
- Recapitulación de Asistencia
- Importación de Datos de Estudiantes (Excel)
- Generación de Facturas de SPP
- Pago de SPP
- Gestión Financiera

## Profesor

- Dashboard del Profesor
- Verificar Horarios de Enseñanza
- Verificar Datos Académicos

## Estudiante

- Dashboard del Estudiante
- Verificar Horarios
- Verificar Historial de Asistencia
- Verificar Facturas de SPP
- Pago de SPP

---

# Tecnologías

| Componente | Tecnología |
|---------|-----------|
| Backend | Laravel 12 |
| Lenguaje | PHP 8.3+ |
| Base de Datos | MySQL |
| Frontend | Blade |
| CSS | Tailwind CSS |
| JavaScript | Alpine.js |
| Herramientas de Compilación | Vite |
| Pasarela de Pago | Midtrans Snap |
| Pruebas | Pest PHP |

---

# Desarrollado con

- Laravel Framework
- Laravel Breeze
- Laravel Eloquent ORM
- Tailwind CSS
- Alpine.js
- Vite
- Pest PHP
- Maatwebsite Laravel Excel
- Midtrans PHP SDK

---

# Arquitectura

```text
Browser
    │
    ▼
Laravel Routes
    │
    ▼
Controllers
    │
    ▼
Services
    │
    ▼
Models
    │
    ▼
MySQL Database
```

La aplicación implementa el patrón **MVC (Model-View-Controller)** con una **Capa de Servicios** para mantener la lógica de negocio separada de los Controladores.

---

# Estructura de Carpetas

```
app/
 ├── Http/
 │    ├── Controllers
 │    └── Middleware
 │
 ├── Models
 │
 ├── Services
 │
 └── Providers

database/
 ├── migrations
 ├── factories
 └── seeders

resources/
 ├── views
 ├── css
 └── js

routes/
 └── web.php

tests/
 ├── Feature
 └── Unit

public/
config/
```

---

# Roles y Permisos

| Módulo | Admin | Profesor | Estudiante |
|--------|:----:|:----:|:----:|
| Dashboard | ✅ | ✅ | ✅ |
| Datos de Estudiantes | ✅ | ❌ | ❌ |
| Datos de Profesores | ✅ | ❌ | ❌ |
| Materias | ✅ | ❌ | ❌ |
| Horarios | ✅ | ✅ | ✅ |
| Asistencia | ✅ | ✅ | ✅ |
| Resumen de Asistencia | ✅ | ❌ | ❌ |
| Finanzas | ✅ | ❌ | ❌ |
| Pago de SPP | ✅ | ❌ | ✅ |

---

# Requisitos del Sistema

- PHP >= 8.3
- Composer >= 2
- Node.js >= 22
- npm >= 10
- MySQL >= 8.0

---

# Instalación

```bash
git clone https://github.com/AnandaAnugrahHandyanto/sekolah-app.git

cd sekolah-app

composer install

npm install

cp .env.example .env

php artisan key:generate

php artisan migrate

npm run build
```

Si se utiliza seeder:

```bash
php artisan db:seed
```

---

# Configuración del Entorno

Asegúrese de que la siguiente configuración esté ajustada.

```env
APP_NAME=Sekolah App

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sekolah_app
DB_USERNAME=root
DB_PASSWORD=

MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_IS_PRODUCTION=false
```

---

# Base de Datos

La base de datos utiliza **MySQL**.

Las tablas principales incluyen:

- users
- siswas
- gurus
- mata_pelajarans
- jadwals
- absensis
- spp_bills
- payment_transactions
- keuangans

---

# Ejecutar en Desarrollo

```bash
php artisan serve

npm run dev
```

---

# Ejecutar en Producción

```bash
composer install --no-dev

php artisan config:cache

php artisan route:cache

php artisan view:cache

npm run build
```

---

# Pruebas

El proyecto utiliza **Pest PHP**.

Ejecutar todas las pruebas:

```bash
php artisan test
```

Formato de código:

```bash
vendor/bin/pint
```

Ver lista de rutas:

```bash
php artisan route:list
```

---

# Flujo de Pago

```text
Admin
   │
Generar Factura
   │
   ▼
Estudiante Inicia Sesión
   │
Seleccionar Factura
   │
Checkout Midtrans
   │
Pago
   │
Webhook Midtrans
   │
Estado del Pago Actualizado
```

---

# Flujo de Trabajo de Desarrollo

```text
Rama de Característica
      │
      ▼
Desarrollo
      │
      ▼
Pruebas
      │
      ▼
Revisión de Código
      │
      ▼
Fusionar a Main
```

---

# Hoja de Ruta

- [ ] Análisis en Dashboard
- [ ] Exportar a PDF
- [ ] Exportar a Excel
- [ ] REST API
- [ ] Código QR de Asistencia
- [ ] Multi Año Académico
- [ ] Notificaciones por WhatsApp
- [ ] Mejora de Compatibilidad Móvil

---

# Contribuidores

### Desarrollador Principal

- **Ananda Anugrah Handyanto**

---

# Licencia

Este proyecto utiliza la **Licencia MIT**.

---

<p align="center">
Desarrollado con ❤️ utilizando Laravel 12
</p>
