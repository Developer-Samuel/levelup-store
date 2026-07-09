# 🗃️ Composer: Database Scripts

This file documents all custom database-related Composer scripts defined in `composer.json`.

---

### db-setup

- **Command**: `scripts/symfony/database/launcher.php`
- **Purpose**: Runs the full database setup including creation, dropping tables, migration, and seeding.
- **Timeout Disabled** via `Composer\\Config::disableProcessTimeout`.
