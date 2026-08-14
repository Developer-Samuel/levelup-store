# 🛠️ DevOps

This document describes **Docker services, CI/CD pipelines, and testing tools** for this project.
Everything is set up to make development smooth, automated, and maintainable.

## Principles

- **Automation First** - All builds, tests, and deployments are fully automated.
- **Fast Feedback** - Each pipeline provides immediate feedback on failures.
- **Clear & Maintainable** - All steps and services are easy to understand and modify.

---

## 🐳 Docker Services

The project runs fully on Docker, providing isolated and reproducible environments.
All services are grouped under `Docker Containers`.

---

## 🧱 CI/CD Pipelines

All pipelines are implemented using GitHub Actions, ensuring automated builds, tests, and deploys.

#### Pipeline Details:

- **main.yml** - Triggered on every push to main. Runs PHP lint & static analysis, architecture check, assets lint, PHPUnit (PHP 8.2 / 8.3), Vitest, and Playwright E2E.
- **pull-request.yml** - Triggered on every pull request to main. Runs PHP lint & static analysis, architecture check, assets lint, PHPUnit (PHP 8.2 / 8.3), and Vitest.
- **release.yml** - Triggered on GitHub Release creation. Automatically prepends release notes to `CHANGELOG.md` and commits it to main.

Pipelines ensure early detection of issues and maintain a deployable state at all times.

---

## 🧪 Testing

Developers can run local testing tools to verify code before pushing:

**Backend**
- **PHPStan** - Static analysis (Level 10)
- **PHPMD** - Mess detection
- **Deptrac** - Architecture dependency enforcement
- **PHPUnit** - Unit, integration & feature tests

**Frontend**
- **TypeScript** - Type checking
- **ESLint / Stylelint** - Linting
- **Vitest** - Unit, integration & functional tests
- **Playwright** - End-to-end tests (auth flows)

Local testing mirrors CI/CD pipelines to prevent failing builds or broken deployments.

---

## 🎯 DevOps Guidelines

- Every push or pull request triggers pipelines automatically.
- Builds fail if deployments or tests fail.
- Immediate feedback is provided on any errors.
- Pipelines are standardized and fully documented for consistency.
- Docker ensures all developers use the same environment, reducing “it works on my machine” issues.

---

## 📊 Diagrams

- [Docker Services](../diagrams/graphs/devops/docker.mmd)
- [CI/CD Pipelines](../diagrams/graphs/devops/pipelines.mmd)
