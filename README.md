# Novena Studio · Laravel

Reconstrucción en Laravel del sitio de Novena Studio (antes PHP + MySQL): home, tienda con filtro por categoría,
login/registro y panel de administración (categorías y productos con imagen).

## Arranque

```bash
composer install
cp .env.example .env && php artisan key:generate
# crear la base vacía en MySQL:  CREATE DATABASE novena_database;
# poner DB_USERNAME / DB_PASSWORD en .env
php artisan migrate --seed    # crea las tablas y los datos demo
php artisan serve             # http://localhost:8000
```

Usuarios demo: `admin@novena.com / admin123` (admin) y `user@novena.com / user123`.

## Notas

- Esquema en `database/migrations`, datos demo en `database/seeders`. Para reiniciar la base: `php artisan migrate:fresh --seed`.
- Vistas armadas con componentes Blade (`resources/views/components`); validación en Form Requests (`app/Http/Requests`).
- Tests: `php artisan test` (SQLite en memoria, no toca MySQL).
- Sesiones y caché van en archivos (`SESSION_DRIVER=file`, `CACHE_STORE=file`), así que MySQL solo necesita `users`, `categories` y `products`.
- Las imágenes subidas desde el panel se guardan en `public/uploads/` (fuera de git).
