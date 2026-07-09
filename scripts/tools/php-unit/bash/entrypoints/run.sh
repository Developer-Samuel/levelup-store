#!/bin/bash
set -euo pipefail

# ────────────── Load Config ──────────────
source scripts/tools/php-unit/bash/config/php-unit.config.sh

# ────────────── Load Functions ──────────────
source scripts/tools/common/bash/bootstrap.sh
source scripts/tools/php-unit/bash/functions/php-unit.sh

# ────────────── Execute ──────────────
bootstrap
run_phpunit
