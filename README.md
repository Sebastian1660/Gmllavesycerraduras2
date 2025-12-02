# 🔐 Sistema de Agendamiento - GM Llaves y Cerraduras

Sistema web para gestión y agendamiento de citas de servicios de cerrajería, desarrollado con Laravel 11.

## 👥 Autores
- **Sebastian Correa Henao**
- **Maria Camila Rios Rojas**

**Institución:** SENA - Servicio Nacional de Aprendizaje

## 📋 Descripción del Proyecto

Sistema completo de agendamiento de citas en línea para GM Llaves y Cerraduras, que permite a los clientes agendar servicios de cerrajería y a los administradores gestionar todas las citas de manera eficiente.

## ✨ Características Principales

### Para Clientes:
- ✅ Registro e inicio de sesión
- 📅 Agendamiento de citas en línea
- 🔍 Visualización de historial de citas
- ❌ Cancelación de citas
- 📧 Notificaciones por email
- 💬 Consultas de productos

### Para Administradores:
- 📊 Dashboard con estadísticas
- ✔️ Confirmación de citas
- 🕐 Gestión de agenda diaria
- 📝 Notas y seguimiento
- 📧 Envío automático de confirmaciones

## 🛠️ Tecnologías Utilizadas

- **Framework:** Laravel 11.x
- **Lenguaje:** PHP 8.1+
- **Base de Datos:** MySQL 8.0
- **Frontend:** Blade Templates + CSS personalizado
- **Autenticación:** Laravel Breeze
- **Servidor Local:** XAMPP

## 📦 Instalación

### Requisitos Previos
- PHP 8.1 o superior
- Composer
- MySQL
- Node.js y NPM
- XAMPP (recomendado para desarrollo local)

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/Sebastian1660/Gmllavesycerraduras.git
cd Gmllavesycerraduras
Instalar dependencias de PHP
composer install
Instalar dependencias de JavaScript
npm install
Configurar variables de entorno
cp .env.example .env
php artisan key:generate
Configurar base de datos
Edita el archivo .env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gmllavesycerraduras
DB_USERNAME=root
DB_PASSWORD=
Crear la base de datos
En phpMyAdmin, crea una base de datos llamada gmllavesycerraduras
Ejecutar migraciones y seeders
php artisan migrate
php artisan db:seed
Iniciar el servidor
php artisan serve
Accede a: http://localhost:8000


👤 Usuarios por Defecto
Administrador:
Email: gmllaves@gmail.com
Contraseña: admin123
Cliente de Prueba:
Email: cliente@ejemplo.com
Contraseña: password


## 📁 Estructura del Proyecto
```
Gmllavesycerraduras/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Controladores (lógica de negocio)
│   │   │   ├── HomeController.php
│   │   │   ├── AppointmentController.php
│   │   │   └── Admin/
│   │   └── Middleware/           # Filtros de peticiones
│   ├── Models/                   # Modelos Eloquent (BD)
│   │   ├── User.php
│   │   ├── Service.php
│   │   ├── Appointment.php
│   │   └── BusinessHour.php
│   └── Mail/                     # Clases de Email
├── database/
│   ├── migrations/               # Estructura de base de datos
│   └── seeders/                  # Datos iniciales
├── resources/
│   └── views/                    # Vistas Blade (frontend)
│       ├── welcome.blade.php
│       ├── appointments/
│       └── admin/
├── routes/
│   └── web.php                   # Definición de rutas
├── public/
│   ├── css/                      # Estilos CSS
│   └── imagenes/                 # Imágenes del sitio
├── .env.example                  # Plantilla de configuración
├── composer.json                 # Dependencias PHP
└── README.md                     # Este archivo
```


---

## 🗄️ Base de Datos

### Diagrama Entidad-Relación

El sistema utiliza las siguientes tablas principales:

| Tabla | Descripción |
|-------|-------------|
| `users` | Usuarios del sistema (clientes y administradores) |
| `services` | Catálogo de servicios de cerrajería |
| `appointments` | Citas agendadas con toda la información |
| `business_hours` | Horarios de atención del negocio |
| `appointment_statuses` | Estados posibles de las citas |
| `product_inquiries` | Consultas sobre productos |

### Relaciones Principales:
- Un **usuario** puede tener muchas **citas** (1:N)
- Un **servicio** puede tener muchas **citas** (1:N)
- Una **cita** pertenece a un **usuario** y un **servicio**

---

🎯 Funcionalidades por Módulo

✅ Módulo de Autenticación
-Registro de nuevos usuarios
-Login con email y contraseña
-Recuperación de contraseña
-Sistema de roles (Admin/Cliente)
-Protección de rutas con middleware

🕒 Módulo de Agendamiento
-Selección de servicio
-Calendario de disponibilidad
-Selección de fecha y hora
-Formulario de datos del cliente
-Confirmación de cita
-Envío de email automático

👤 Módulo de Gestión (Admin)
-Dashboard con métricas
-Lista de todas las citas
-Filtros por estado (pendiente, confirmada, etc.)
-Vista de agenda diaria
-Confirmación/cancelación de citas
-Sistema de notas internas

🔐 Módulo de Servicios
-Catálogo de servicios con precios
-Descripción detallada
-Duración estimada
-Categorización por tipo


🔒 Seguridad
El sistema implementa las siguientes medidas de seguridad:
✅ Contraseñas hasheadas con bcrypt
✅ Protección CSRF en formularios
✅ Validación de datos en servidor
✅ Prevención de SQL Injection (Eloquent ORM)
✅ Protección XSS (Blade auto-escape)
✅ Middleware de autenticación
✅ Control de acceso basado en roles
✅ Sesiones seguras

🚀 Características Futuras
[ ] Integración con Google Calendar
[ ] Notificaciones SMS
[ ] Sistema de pagos en línea
[ ] Aplicación móvil
[ ] Reportes y estadísticas avanzadas

📄 Licencia
Este proyecto fue desarrollado como proyecto educativo para el SENA.

📞 Contacto
GM Llaves y Cerraduras
📱 Teléfono: +57 302 238 70 20
📧 Email: gmllaves@gmail.com
Desarrollado con ❤️ por Sebastian Correa Henao y Maria Camila Rios Rojas
