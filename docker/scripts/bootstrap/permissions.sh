#!/bin/bash
set -e

echo "🛠️ Creating required directories..."
mkdir -p \
  /var/www/var/sessions \
  /var/www/var/cache \
  /var/www/var/log \
  /var/www/var/tmp

echo "🔧 Setting permissions for directories..."
chmod 775 /var/www/var/cache /var/www/var/sessions /var/www/var/log /var/www/var/tmp

echo "📄 Creating log file if missing..."
if [ ! -f /var/www/var/log/app.log ]; then
  touch /var/www/var/log/app.log
  echo "📝 Created empty app.log file"
fi
chmod 664 /var/www/var/log/app.log

echo "🔧 Fixing permissions inside cache and sessions..."
find /var/www/var/cache -type d -exec chmod 775 {} \;
find /var/www/var/cache -type f -exec chmod 664 {} \;
find /var/www/var/sessions -type d -exec chmod 775 {} \;
find /var/www/var/sessions -type f -exec chmod 664 {} \;

# 📢 Hot reload file
[ -f /var/www/public/hot ] && chown www-data:www-data /var/www/public/hot

# 📦 Frontend build assets directory
[ -d /var/www/public/build ] && chown -R www-data:www-data /var/www/public/build

# 📦 Node-related files
[ -f /var/www/package-lock.json ] && chown www-data:www-data /var/www/package-lock.json
[ -d /var/www/node_modules ] && chown -R www-data:www-data /var/www/node_modules

echo "✅ Permissions and logging setup complete."
