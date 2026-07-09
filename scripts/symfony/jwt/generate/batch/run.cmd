@echo off

setlocal enabledelayedexpansion

set "envFile=.env"
set "jwtDir=config\jwt"

REM ============================================
REM Check .env exists
REM ============================================

if not exist "%envFile%" (
    echo ERROR: .env file not found. Run env/generate and env/secret first.
    exit /b 1
)

REM ============================================
REM Read JWT_PASSPHRASE from .env
REM ============================================

set "JWT_PASSPHRASE="
for /f "usebackq tokens=1* delims==" %%A in ("%envFile%") do (
    if /i "%%A"=="JWT_PASSPHRASE" set "JWT_PASSPHRASE=%%B"
)

if "!JWT_PASSPHRASE!"=="" (
    echo ERROR: JWT_PASSPHRASE not found in .env. Run env/secret first.
    exit /b 1
)

REM ============================================
REM Remove old keys and create jwt directory
REM ============================================

if exist "%jwtDir%\private.pem" del /f "%jwtDir%\private.pem"
if exist "%jwtDir%\public.pem" del /f "%jwtDir%\public.pem"

if not exist "%jwtDir%" mkdir "%jwtDir%"

REM ============================================
REM Generate private key
REM ============================================

openssl genpkey -algorithm RSA ^
    -out "%jwtDir%\private.pem" ^
    -aes256 ^
    -pass pass:!JWT_PASSPHRASE! ^
    -pkeyopt rsa_keygen_bits:4096

if errorlevel 1 (
    echo ERROR: Failed to generate private.pem
    exit /b 1
)

REM ============================================
REM Generate public key
REM ============================================

openssl pkey ^
    -in "%jwtDir%\private.pem" ^
    -out "%jwtDir%\public.pem" ^
    -pubout ^
    -passin pass:!JWT_PASSPHRASE!

if errorlevel 1 (
    echo ERROR: Failed to generate public.pem
    exit /b 1
)

echo JWT private.pem and public.pem generated in %jwtDir%

endlocal
