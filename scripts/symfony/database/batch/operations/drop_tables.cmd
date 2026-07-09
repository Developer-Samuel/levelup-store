@echo off

REM ================================
REM Drop all tables from the database
REM ================================

echo "Dropping all tables..."

php bin\console doctrine:schema:drop --force --full-database
