@echo off

REM ================================
REM Main entrypoint for PDepend
REM ================================

call scripts\tools\pdepend\batch\bootstrap\clean.cmd
call scripts\tools\pdepend\batch\bootstrap\setup.cmd

echo Running PDepend analysis...

REM Running PDepend analysis with summary XML
pdepend --summary-xml=var/tools/pdepend/reports/pdepend-summary.xml --jdepend-xml=var/tools/pdepend/reports/pdepend-jdepend.xml src/

echo Done! PDepend reports generated.
