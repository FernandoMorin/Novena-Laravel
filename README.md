# Novena Studio · Laravel

Reconstrucción en Laravel del sitio de Novena Studio (antes PHP + MySQL): home, tienda con filtro por categoría,
login/registro y panel de administración (categorías y productos con imagen).

## Arranque

```bash
composer install
cp .env.example .env && php artisan key:generate
mysql -u root -p < database/novena_database.sql   # crea novena_database con datos demo
# poner DB_USERNAME / DB_PASSWORD en .env
php artisan serve                                  # http://localhost:8000
```

Usuarios demo: `admin@novena.com / admin123` (admin) y `user@novena.com / user123`.

## Notas

- El esquema de MySQL vive en `database/novena_database.sql`; las migraciones lo replican para los tests (`php artisan test`, SQLite en memoria).
- Sesiones y caché van en archivos (`SESSION_DRIVER=file`, `CACHE_STORE=file`), así que MySQL solo necesita `users`, `categories` y `products`.
- Las imágenes subidas desde el panel se guardan en `public/uploads/` (fuera de git).
