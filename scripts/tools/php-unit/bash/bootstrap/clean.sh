#!/bin/bash
set -e

# ────────────── Clean old PHPUnit folder ──────────────
source scripts/tools/common/bash/directory/clean.sh
clean_directory "var/tools/php-unit"
