#!/bin/bash
set -e

echo "🔨 Installing PHP extensions..."
docker-php-ext-install pdo pdo_pgsql zip

echo "📦 Installing PHP Redis extension..."
pecl install redis && docker-php-ext-enable redis
