@echo off

REM ================================
REM Clean directory function
REM ================================

set DIR=%1

if exist "%DIR%" (
    echo Removing old %DIR% folder...
    rmdir /s /q "%DIR%"
) else (
    echo Directory %DIR% does not exist, skipping...
)
