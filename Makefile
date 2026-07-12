# ──────────────────────────────────────────────────────────────────────────────
# 📝 Declare all phony targets to prevent conflicts with files
# ────────────────────────────────────────────────────────────────────────────

.PHONY: install cache-clear serve setup \
		up up-detached down down-clean clean-all build force build-force build-cache restart \
        setup-build setup-up setup-restart-build setup-restart-build-without-cache setup-restart \
        dev dev-detached \
		logs

# ──────────────────────────────────────────────────────────────────────────────
# 📦 App Commands
# ──────────────────────────────────────────────────────────────────────────────

# Install dependencies and build assets
install:
	@echo "📦 Installing dependencies and building assets..."
	composer install
	@if command -v pnpm > /dev/null 2>&1; then \
		pnpm install && pnpm run build; \
	else \
		npm install && npm run build; \
	fi

# Clear and warmup Symfony cache (flushes Redis if available)
cache-clear:
	@echo "🧹 Clearing and warming up cache..."
	composer cache:clear
	composer cache:warmup
	@if command -v redis-cli > /dev/null 2>&1; then \
		redis-cli -h "$$REDIS_HOST" -p "$$REDIS_PORT" flushall; \
	fi

# Start local development servers (PHP + frontend)
serve:
	@echo "🚀 Starting local development servers..."
	composer serve &
	@if command -v pnpm > /dev/null 2>&1; then \
		pnpm dev; \
	else \
		npm run dev; \
	fi

# Full local setup: install dependencies + database + cache + serve
setup:
	$(MAKE) install
	composer db-setup
	$(MAKE) cache-clear
	$(MAKE) serve

# ──────────────────────────────────────────────────────────────────────────────
# 🐳 Docker Commands
# ──────────────────────────────────────────────────────────────────────────────

# ── 🚀 Core ──────────────────────────────────────────────────────────────────

# Start all services in foreground
up:
	@echo "▶ Starting all services in foreground..."
	docker compose up

# Start all services in background (detached)
up-detached:
	@echo "▶ Starting all services in detached mode..."
	docker compose up -d

# Stop all services
down:
	@echo "⏹ Stopping all services..."
	docker compose down

# Stop and clean all services including volumes and orphan containers
down-clean:
	@echo "⏹ Cleaning all services and volumes..."
	docker compose down --volumes --remove-orphans

# Clean ALL containers and images (⚠️ destructive!)
clean-all:
	@echo "💣 WARNING: Cleaning ALL containers and images! Full reset!"
	docker ps -q | xargs -r docker stop
	docker ps -aq | xargs -r docker rm -f
	docker images -aq | xargs -r docker rmi -f

# Build/rebuild images
build:
	@echo "🛠 Building all images (using cache)..."
	docker compose build

# Force recreate all services detached (stop old, remove conflicts)
force:
	@echo "⚡ Force recreation of all services in detached mode..."
	docker compose up -d --force-recreate

# Force rebuild all images and recreate all services
build-force:
	@echo "🛠 Force rebuild of all images and recreation of services..."
	docker compose build
	$(MAKE) force

# Build/rebuild all Docker images without using cache
build-cache:
	@echo "🧹 Building all images without using cache..."
	docker compose build --no-cache

# Restart all services (clean + up detached)
restart:
	@echo "🔄 Restarting all services..."
	$(MAKE) down-clean
	$(MAKE) up

# ── 🛠️ Setup ─────────────────────────────────────────────────────────────────

# Build and start setup containers (first time or Dockerfile changes)
setup-build:
	@echo "🛠 Setup: Building and starting setup containers..."
	docker compose --profile setup up --build

# Start setup containers without rebuilding
setup-up:
	@echo "▶ Setup: Starting setup containers without rebuild..."
	docker compose --profile setup up

# Clean and rebuild setup containers (with cache)
setup-restart-build:
	@echo "🔄 Setup: Restarting and rebuilding setup containers (with cache)..."
	$(MAKE) down-clean
	$(MAKE) setup-build

# Clean and rebuild setup containers (without cache)
setup-restart-build-without-cache:
	@echo "🧹 Setup: Restarting setup containers without cache..."
	$(MAKE) down-clean
	$(MAKE) build-cache
	$(MAKE) setup-build

# Restart setup containers (clean + start without rebuild)
setup-restart:
	@echo "🔄 Setup: Restarting setup containers..."
	$(MAKE) down-clean
	$(MAKE) setup-up

# ── 💻 Development ───────────────────────────────────────────────────────────

# Start dev profile services in foreground
dev:
	@echo "▶ Starting dev profile services in foreground..."
	docker compose --profile dev up

# Start dev profile services detached
dev-detached:
	@echo "▶ Starting dev profile services detached..."
	docker compose --profile dev up -d

# ── 🔍 Utility ───────────────────────────────────────────────────────────────

# Show logs of all services
logs:
	@echo "📜 Showing logs of all services..."
	docker compose logs -f
