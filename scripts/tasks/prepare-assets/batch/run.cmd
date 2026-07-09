@echo off

REM ==============================
REM Prepare assets/controllers folder
REM ==============================

echo Checking if assets\controllers exists...

IF NOT EXIST "assets\controllers" (
    echo Folder not found, creating assets\controllers...
    mkdir "assets\controllers"
) ELSE (
    echo Folder already exists, skipping...
)

echo Done.
