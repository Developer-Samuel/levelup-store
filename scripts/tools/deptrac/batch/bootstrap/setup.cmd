@echo off

REM ────────────── Ensure 'tools' directory in 'var' exists ──────────────
call scripts\tools\common\batch\directory\create.cmd var\tools

REM ────────────── Setup Deptrac tools directory ──────────────
call scripts\tools\common\batch\directory\create.cmd var\tools\deptrac
call scripts\tools\common\batch\directory\create.cmd var\tools\deptrac\reports