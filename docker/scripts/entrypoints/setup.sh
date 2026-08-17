#!/bin/bash
set -e

/usr/local/bin/scripts/bootstrap/check-composer.sh

echo "🔄 Preparing environment file (.env.example -> .env)"
/usr/local/bin/scripts/bootstrap/prepare-env.sh

echo "🔍 Checking node dependencies..."
/usr/local/bin/scripts/bootstrap/node-setup.sh

echo "⚙️ Clearing caches and optimizing configuration..."
/usr/local/bin/scripts/bootstrap/optimize.sh
echo "✅ Optimization script finished."

echo "🧹 Clearing Redis cache..."
/usr/local/bin/scripts/entrypoints/app/clear-cache.sh
echo "✅ Redis cache cleared."

echo "🗃️ Running migrations and seeding database..."
/usr/local/bin/scripts/entrypoints/app/db-setup.sh
echo "✅ Migrations and seeding finished."

echo "🔍 Checking frontend build (npm run build)..."
/usr/local/bin/scripts/entrypoints/app/build.sh

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "✅ App is ready at http://localhost:8000"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
