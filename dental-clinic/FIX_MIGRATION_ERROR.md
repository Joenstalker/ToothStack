# Fix Migration Error - Table Already Exists

## Problem
The `appointments` table was partially created from a previous failed migration, causing a "table already exists" error.

## Solution

The appointments migration has been updated to drop the table first if it exists.

## Run Migration Again

In Git Bash:

```bash
cd dental-clinic
php artisan migrate
```

## Alternative: Manual Fix in phpMyAdmin

If the migration still fails, you can manually drop the table in phpMyAdmin:

1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Select `toothstack` database
3. Click on `appointments` table
4. Click "Drop" to delete it
5. Then run: `php artisan migrate`

## Or Use Fresh Migration (⚠️ Deletes ALL Data)

```bash
cd dental-clinic
php artisan migrate:fresh
```

This will:
- Drop ALL tables
- Re-run ALL migrations
- **Delete all data!**

Only use this in development!
