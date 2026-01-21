# Connect to XAMPP MySQL

## Current Status

Your system is currently using **SQLite** (not MySQL). To connect to XAMPP's MySQL, you need to update your `.env` file.

## Step 1: Check XAMPP MySQL is Running

1. Open **XAMPP Control Panel**
2. Make sure **MySQL** is **Started** (green)
3. If not started, click **Start**

## Step 2: Update .env File

Edit `dental-clinic/.env` file and update these lines:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toothstack
DB_USERNAME=root
DB_PASSWORD=
```

**Important:**
- `DB_CONNECTION=mysql` (change from `sqlite`)
- `DB_DATABASE=toothstack` (your database name)
- `DB_USERNAME=root` (default XAMPP username)
- `DB_PASSWORD=` (leave empty if no password, or add your MySQL password)

## Step 3: Clear Config Cache

After updating `.env`, run:

```bash
cd dental-clinic
php artisan config:clear
```

## Step 4: Test Connection

Test if connection works:

```bash
php artisan migrate:status
```

If it shows your migrations, connection is working!

## Step 5: Run Migrations

```bash
php artisan migrate
```

## Common XAMPP MySQL Settings

- **Host:** `127.0.0.1` or `localhost`
- **Port:** `3306` (default)
- **Username:** `root` (default)
- **Password:** Usually empty (blank) in XAMPP

## Troubleshooting

### Error: "Access denied"
- Check username/password in `.env`
- XAMPP default: username=`root`, password=empty

### Error: "Can't connect to MySQL server"
- Make sure XAMPP MySQL is **Started**
- Check if port 3306 is available
- Try `127.0.0.1` instead of `localhost`

### Error: "Unknown database 'toothstack'"
- Create database in phpMyAdmin first
- Or run: `php artisan migrate` (will create if doesn't exist)

## Verify Connection

After setup, check in phpMyAdmin:
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. You should see `toothstack` database
3. After migrations, you'll see all tables
