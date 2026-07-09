#!/bin/bash
set -e

# ────────────── Clean old Deptrac folder ──────────────
source scripts/tools/common/bash/directory/clean.sh
clean_directory "var/tools/deptrac"
