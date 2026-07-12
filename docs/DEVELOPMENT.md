# ⚒️ Development

## Makefile / Docker Commands

If you have a `Makefile` or want to manage Docker manually, these commands cover **all typical operations**:

### 🚀 Core Commands

```bash
# Start all services in foreground
make up
# or
docker compose up

# Start all services in background (detached)
make up-detached
# or
docker compose up -d

# Stop all services
make down
# or
docker compose down

# Stop and clean all services including volumes and orphan containers
make down-clean
# or
docker compose down --volumes --remove-orphans

# Clean ALL containers and images (⚠️ destructive!)
make clean-all
# or
docker ps -q | xargs -r docker stop
docker ps -aq | xargs -r docker rm -f
docker images -aq | xargs -r docker rmi -f

# Build/rebuild images
make build
# or
docker compose build

# Force recreate all services detached (stop old, remove conflicts)
make force
# or
docker compose up -d --force-recreate

# Force rebuild all images and recreate all services
make build-force
# or
docker compose build
docker compose up -d --force-recreate

# Build/rebuild all Docker images without using cache
make build-cache
# or
docker compose build --no-cache

# Restart all services (clean + up detached)
make restart
# or
docker compose down --volumes --remove-orphans
docker compose up
```

### 🛠️ Setup Commands

```bash
# Build and start setup containers (first time or Dockerfile changes)
make setup-build
# or
docker compose --profile setup up --build

# Start setup containers without rebuilding
make setup-up
# or
docker compose --profile setup up

# Clean and rebuild setup containers (with cache)
make setup-restart-build
# or
docker compose down --volumes --remove-orphans
docker compose --profile setup up --build

# Clean and rebuild setup containers (without cache)
make setup-restart-build-without-cache
# or
docker compose down --volumes --remove-orphans
docker compose build --no-cache
docker compose --profile setup up --build

# Restart setup containers (clean + start without rebuild)
make setup-restart
# or
docker compose down --volumes --remove-orphans
docker compose --profile setup up
```

### 💻 Development Commands

```bash
# Start dev profile services in foreground
make dev
# or
docker compose --profile dev up

# Start dev profile services detached
make dev-detached
# or
docker compose --profile dev up -d
```

### 🔍 Utility Commands

```bash
# Show logs of all services
make logs
# or
docker compose logs -f
```

## 🩺 Health Check

Verify that all services (database, cache, mailer, Stripe, disk, wkhtmltopdf) are running correctly:

```
GET /api/dev/health-check
```

Example response:

```json
{
  "status": "ok",
  "database": "ok",
  "cache": "ok",
  "disk": "ok",
  "mailer": "ok",
  "stripe": "ok",
  "wkhtmltopdf": "ok"
}
```

> `wkhtmltopdf` returns `"disabled"` if `WKHTMLTOPDF_ENABLED=false` and does not affect the overall `status`.
