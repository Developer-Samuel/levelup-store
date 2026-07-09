@echo off

REM ================================
REM Create the database if it doesn't exist
REM ================================

echo "Creating database..."

php bin\console doctrine:database:create
