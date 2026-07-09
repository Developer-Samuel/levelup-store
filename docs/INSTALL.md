# 📦 Install

This file describes the **installation steps** on a fresh checkout.

---

## 1. Install PHP dependencies (Composer)

```bash
composer install
```

- `composer install` installs exact versions from `composer.lock` to ensure reproducibility.
- Dependency updates are handled separately as part of maintenance.

---

## 2. Install TypeScript dependencies (pnpm / npm)

```bash
# pnpm
pnpm install

# or npm
npm install
```

- Dependency updates are intentionally excluded from installation steps.

---

## 3. Check Setup

This file is the **quick-start guide** to get the project running. It complements [SETUP.md](SETUP.md), which covers full environment and configuration setup. Use this when cloning the project fresh.

---

## 4. Prepare Cache & Redis

#### locally

```bash
composer cache:clear
composer cache:warmup
```

#### Redis

```bash
redis-cli -h "$REDIS_HOST" -p "$REDIS_PORT" flushall
```

---

## 5. Run Application

#### Without Docker

```bash
# Local development server
composer serve

# Frontend development (live server)
npm run dev
# or
pnpm dev

# Frontend build
npm run build
# or
pnpm build
```

#### With Docker

### First time setup

```bash
# Using Docker (loads DB and initial data)
docker compose --profile setup up

# Using Makefile
make setup-up
```

### Subsequent starts

```bash
# Using Docker
docker compose up

# Using Makefile
make up
```

---

## 6. Database Setup (if not using Docker)

```bash
composer db-setup
```

---

✅ This `INSTALL.md` is your **quick-start guide** for getting the project running.

- Always start with `composer install` and `pnpm install` or `npm install`.
- Dependency updates are handled as part of regular maintenance. See [MAINTENANCE.md](MAINTENANCE.md).
- For full environment and configuration setup see [SETUP.md](SETUP.md).
- For complete Docker and Makefile command reference see [DEVELOPMENT.md](DEVELOPMENT.md).
