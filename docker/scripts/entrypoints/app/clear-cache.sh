#!/bin/bash
set -e

if [ "${REDIS_ENABLED}" = "true" ]; then
    echo "🧹 Clearing Redis cache..."
    redis-cli -h "$REDIS_HOST" -p "$REDIS_PORT" flushall
    echo "✅ Redis cache cleared."
else
    echo "⏭️ Redis disabled, skipping Redis cache clear."
fi
