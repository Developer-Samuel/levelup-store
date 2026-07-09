#!/bin/bash
set -euo pipefail

# ────────────── Load Config ──────────────
source scripts/tools/pdepend/bash/config/pdepend.config.sh

# ────────────── Load Functions ──────────────
source scripts/tools/common/bash/bootstrap.sh
source scripts/tools/pdepend/bash/functions/pdepend.sh

# ────────────── Execute ──────────────
bootstrap
run_pdepend
