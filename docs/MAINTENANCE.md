# Maintenance

This document describes **dependency maintenance procedures**.
It is intended for **existing projects**, not first-time setup.

⚠️ Important: Do NOT run these commands blindly in production. Always validate changes first.

---

## 1. PHP Dependencies (Composer)

#### Update dependencies

```bash
composer update
```

#### Post-update validation (required)

```bash
composer test
composer phpmd
composer phpstan
```

- Run the full test suite to ensure no regressions were introduced.
- Static analysis must pass before committing dependency updates.
- Treat failures as blockers, not warnings.

⚠️ If any failures occur, fix them immediately or rollback `composer.lock` before committing.

## 2. Frontend Dependencies (pnpm / npm)

#### Update dependencies

```bash
# pnpm
pnpm update

# or npm
npm update
```

#### Post-update validation (required)

```bash
# pnpm
pnpm run vitest

# or npm
npm run vitest
```

- All frontend tests must pass after dependency updates
- If failures occur, resolve them before committing

⚠️ Consider running these commands in a separate branch or environment before merging to main.

#### Quality Checks (Optional)

These checks are recommended but not mandatory for dependency updates.

```bash
# TypeScript linting
pnpm run eslint
pnpm run eslint:fix

# or npm
npm run eslint
npm run eslint:fix
```

```bash
# SCSS linting
pnpm run lint
pnpm run lint:fix

# or npm
npm run lint
npm run lint:fix
```

⚠️ `eslint:fix` may modify code automatically - review changes before committing.

---

## Commit Policy

When updating dependencies, always commit together:

- `composer.json` + `composer.lock`
- `package.json` + `pnpm-lock.yaml` or `package-lock.json`

Never update dependencies without corresponding test verification.

⚠️ Dependency updates without validation are considered invalid changes.
