#!/bin/bash
set -e

bash "$(dirname "$0")/services/database.sh"
bash "$(dirname "$0")/services/redis.sh"

echo "✅ All required services are ready."
