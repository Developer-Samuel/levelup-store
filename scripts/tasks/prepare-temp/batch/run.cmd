@echo off

REM ==============================
REM Prepare var\tmp folder
REM ==============================

echo Checking if var\tmp exists...

IF NOT EXIST "var\tmp" (
    echo Folder not found, creating var\tmp...
    mkdir "var\tmp"
) ELSE (
    echo Folder already exists, skipping...
)

echo Done.
