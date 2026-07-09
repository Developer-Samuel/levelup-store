#!/bin/bash
set -e

composer db-setup

echo "✅ Done! Database is ready."