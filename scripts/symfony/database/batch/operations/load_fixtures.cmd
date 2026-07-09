@echo off

REM ================================
REM Load database fixtures
REM ================================

echo "Loading fixtures..."

php bin\console doctrine:fixtures:load --no-interaction
