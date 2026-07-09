#!/bin/bash
set -euo pipefail

# ────────────── Load Config ──────────────
source scripts/tools/php-metrics/bash/config/php-metrics.config.sh

# ────────────── Load Functions ──────────────
source scripts/tools/common/bash/bootstrap.sh
source scripts/tools/php-metrics/bash/functions/php-metrics.sh

# ────────────── Execute ──────────────
bootstrap
run_php_metrics
