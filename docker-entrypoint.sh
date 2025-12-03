#!/bin/bash
set -e

# Limpiar cache de configuración
php artisan config:clear

# Ejecutar migraciones
php artisan migrate --force

# Cachear configuraciones
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar Apache
apache2-foreground
```

## Variable adicional en Railway:

Si usas Apache, agrega esta variable:
```
PORT=80