# 🛠️ DevOps

This document describes **Docker services and testing tools** for this project.
Everything is set up to make development smooth and maintainable.

## Principles

- **Clear & Maintainable** - All steps and services are easy to understand and modify.

---

## 🐳 Docker Services

The project runs fully on Docker, providing isolated and reproducible environments.
All services are grouped under `Docker Containers`.

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
- **PHPUnit** - Unit, integration & feature tests
- **Playwright** - End-to-end tests (auth flows)

---

## 🎯 DevOps Guidelines

- Docker ensures all developers use the same environment, reducing “it works on my machine” issues.

---

## 📊 Diagrams

- [Docker Services](../diagrams/graphs/devops/docker.mmd)
