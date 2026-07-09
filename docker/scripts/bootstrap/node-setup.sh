#!/bin/bash
set -e

cd /var/www

if [ ! -d "node_modules" ] || [ -z "$(ls -A node_modules)" ]; then
  echo "⬇️ Dependencies not found or empty, running 'npm install' to install packages..."
  npm install
  echo "✅ npm install finished."
else
  echo "⚙️ Dependencies found, running 'npm update' to ensure packages are up to date..."
  npm update
  echo "✅ node_modules exists, updated with npm update."
fi
