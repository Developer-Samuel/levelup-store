# 🧪 Testing Tools

This document describes the main **testing tools** used in the project.  
Testing ensures code correctness, prevents regressions, and improves maintainability.

---

### Backend

- **PHPUnit** - Unit, Integration, and Feature testing for PHP.  
  Run tests via `composer php-unit`.  
  Tests are organized into **Unit, Integration, Feature, and Support** folders according to their purpose.

#### Integration Tests - Database

Integration tests run against a dedicated `levelup_store_test` database - never the main `levelup_store`.  
Create and migrate it once before running integration tests locally:

```bash
composer db-setup
```

### Frontend

- **Vitest** - Unit, Integration, and Functional testing for TypeScript.  
  Run tests via `npm run vitest` or `pnpm vitest`.  
  For continuous testing during development, use `npm run vitest:watch` or `pnpm vitest:watch` to automatically rerun tests on file changes.

- **Playwright** - End-to-end testing against a running local server.  
  Run tests via `npx playwright test`.  
  Requires the `levelup_store_test` database (see [Integration Tests - Database](#integration-tests---database) above).  
  Configure the target URL and test user credentials in `.env.test`:

  ```env
  APP_URL=http://127.0.0.1:8000
  TEST_USER_EMAIL=test@example.com
  TEST_USER_PASSWORD=Test123@
  ```

---

## 📊 Diagrams

- [Testing Tools](../diagrams/graphs/devops/testing.mmd)
