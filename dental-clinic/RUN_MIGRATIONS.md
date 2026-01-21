# Run Migrations - Git Bash Commands

## Why Database is Empty?

The database is empty because **migrations haven't been run yet**. The migrations are created but not executed.

## Run Migrations

### Step 1: Navigate to Project
```bash
cd dental-clinic
```

### Step 2: Run Migrations
```bash
php artisan migrate
```

This will create all tables:
- ✅ users (already exists, will be enhanced)
- ✅ appointments
- ✅ services
- ✅ schedules
- ✅ concerns
- ✅ audit_logs

### Step 3: Verify in phpMyAdmin

After running migrations, check phpMyAdmin:
- You should see all tables created
- Tables should have proper structure
- Foreign keys should be set up

## Migration Order

The migrations will run in this order:
1. `0001_01_01_000000_create_users_table` (already run)
2. `0001_01_01_000001_create_cache_table` (already run)
3. `0001_01_01_000002_create_jobs_table` (already run)
4. `2024_01_01_000003_create_appointments_table` (NEW)
5. `2024_01_01_000004_create_services_table` (NEW)
6. `2024_01_01_000005_create_schedules_table` (NEW)
7. `2024_01_01_000006_create_concerns_table` (NEW)
8. `2024_01_01_000007_create_audit_logs_table` (NEW)
9. `2024_01_01_000009_enhance_users_table` (NEW - adds fields to users)

## If Migration Fails

### Check Database Connection
```bash
php artisan migrate:status
```

### Reset and Re-run (⚠️ Deletes all data)
```bash
php artisan migrate:fresh
```

### Check .env File
Make sure your `.env` has:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toothstack
DB_USERNAME=root
DB_PASSWORD=your_password
```

## After Migrations

Once migrations are complete, you'll have:
- ✅ Complete database structure
- ✅ All relationships set up
- ✅ Ready for data entry

Then you can:
- Create users
- Add services
- Create schedules
- Book appointments
