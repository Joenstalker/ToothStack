# Fix XAMPP MySQL Collation Error

## Problem

XAMPP's MySQL (usually MySQL 5.7 or MariaDB) doesn't support `utf8mb4_0900_ai_ci` collation which is for MySQL 8.0+.

## Solution

The database config has been updated to use `utf8mb4_unicode_ci` which is compatible with XAMPP.

## Steps to Fix

### 1. Clear Config Cache
```bash
cd dental-clinic
php artisan config:clear
```

### 2. Test Connection
```bash
php artisan db:show
```

### 3. Run Migrations
```bash
php artisan migrate
```

## Alternative: Update .env

You can also set the collation in `.env`:

```env
DB_COLLATION=utf8mb4_unicode_ci
```

Then clear config:
```bash
php artisan config:clear
```

## What Changed

- **Before:** `utf8mb4_0900_ai_ci` (MySQL 8.0+ only)
- **After:** `utf8mb4_unicode_ci` (Compatible with XAMPP/MySQL 5.7/MariaDB)

Both collations support full Unicode including emojis, but `utf8mb4_unicode_ci` is more widely compatible.
