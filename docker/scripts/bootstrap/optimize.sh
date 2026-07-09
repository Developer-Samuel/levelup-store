#!/bin/bash
set -e

echo "🧹 Clearing cache..."
rm -rf var/cache/*
echo "✅ Cache cleared."

echo "⚡ Warming up Composer cache..."
composer cache:warmup
echo "✅ Composer cache warmed up."