@echo off

REM ================================
REM Run database migrations
REM ================================

echo "Running migrations..."

php bin\console doctrine:migrations:migrate --no-interaction
