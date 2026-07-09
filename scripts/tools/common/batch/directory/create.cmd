@echo off

SET DIR=%1

IF NOT EXIST "%DIR%" (
    echo Directory %DIR% does not exist, creating...
    mkdir "%DIR%"
) ELSE (
    echo Directory %DIR% already exists, continuing execution...
)
