@echo off

REM ================================
REM Check if the database exists
REM ================================

echo "Checking if database exists..."

php bin\console doctrine:query:sql "SELECT 1" >nul 2>&1

IF %ERRORLEVEL% EQU 0 (
    echo "Database exists, dropping all tables..."
    call scripts/symfony/database/batch/operations/drop_tables.cmd
) ELSE (
    echo "Database does not exist, creating..."
    call scripts/symfony/database/batch/operations/create_database.cmd
)

REM ================================
REM Run migrations
REM ================================

call scripts/symfony/database/batch/operations/run_migrations.cmd

REM ================================
REM Load fixtures
REM ================================

call scripts/symfony/database/batch/operations/load_fixtures.cmd

echo "Done! Database is ready."
