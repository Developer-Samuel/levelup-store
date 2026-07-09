@echo off

REM ================================
REM Main entrypoint for Deptrac
REM ================================

call scripts\tools\deptrac\batch\bootstrap\clean.cmd
call scripts\tools\deptrac\batch\bootstrap\setup.cmd

echo Running Deptrac analysis...

REM Running Deptrac analysis with JSON formatter
deptrac analyse --config-file=deptrac.yaml --cache-file=var\tools\deptrac\.deptrac.cache --formatter json > var\tools\deptrac\reports\report.json

echo Deptrac reports generated successfully.
