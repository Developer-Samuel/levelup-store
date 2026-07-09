#!/bin/bash
set -euo pipefail

# ────────────── Load Config ──────────────
source scripts/tools/deptrac/bash/config/deptrac.config.sh

# ────────────── Load Functions ──────────────
source scripts/tools/common/bash/bootstrap.sh
source scripts/tools/deptrac/bash/functions/deptrac.sh

# ────────────── Execute ──────────────
bootstrap
run_deptrac
