@echo off

REM ================================
REM Ensure .env exists
REM ================================
IF NOT EXIST ".env" (
    copy .env.example .env
    echo [OK] .env file created from .env.example
) ELSE (
    echo [INFO] .env file already exists, skipping creation
)
