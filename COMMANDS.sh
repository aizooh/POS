# ══════════════════════════════════════════════════
#  MAMICAR POS — Migrations, Models & Seeders Setup
# ══════════════════════════════════════════════════


# ── STEP 1: FILE PLACEMENT ──────────────────────────
#
# MIGRATIONS → database/migrations/
#   2025_01_01_000002_create_products_table.php
#   2025_01_01_000003_create_services_table.php
#   2025_01_01_000004_create_transactions_table.php
#   2025_01_01_000005_create_transaction_items_table.php
#   2025_01_01_000006_create_mpesa_callbacks_table.php
#
# MODELS → app/Models/
#   Product.php
#   Service.php
#   Transaction.php
#   TransactionItem.php
#   MpesaCallback.php
#
# SEEDERS → database/seeders/
#   ProductSeeder.php       (new file)
#   ServiceSeeder.php       (new file)
#   DatabaseSeeder.php      (replace existing)


# ── STEP 2: RUN COMMANDS ────────────────────────────

# Run new migrations
php artisan migrate

# Seed products and services
php artisan db:seed

# Clear caches
php artisan config:clear
php artisan route:clear

# Confirm tables exist
php artisan migrate:status
