@echo off

REM ────────────── Ensure 'tools' directory in 'var' exists ──────────────
call scripts\tools\common\batch\directory\create.cmd var\tools

REM ────────────── Setup PDepend tools directory ──────────────
call scripts\tools\common\batch\directory\create.cmd var\tools\pdepend
call scripts\tools\common\batch\directory\create.cmd var\tools\pdepend\reports
