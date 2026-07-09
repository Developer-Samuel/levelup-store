#!/bin/bash
set -e

echo "🟢 Setting up Node.js..."
curl -fsSL https://deb.nodesource.com/setup_22.x | bash -
apt-get install -y nodejs
