## [1.0.0] - 2026-07-12

### 🚀 Features

#### E-Commerce Core
- Product catalog with taxonomy (Categories → Types → Subtypes), filters, sorting, pagination
- Product detail with variants, stock, images, descriptions, discounts
- Cart management (add, update, remove) with real-time stock validation
- Checkout flow - personal, billing, shipping details capture
- Payments via Stripe (card) and cash-on-delivery
- Downloadable PDF invoices with unique codes (wkhtmltopdf)
- Order history and status tracking
- Wishlist (add/remove products)
- Reviews with like/dislike reactions
- Full-text product search

#### Admin Panel
- Dashboard analytics - orders per month, paid/unpaid ratio, user growth (ApexCharts)
- CRUD for brands, banners, products, variants, users, orders
- Order status management

#### Authentication & Security
- JWT access + refresh token pattern (HTTP-only cookies)
- Email verification and password reset flows
- Role-based access control (guest, user, admin)
- Rate limiting on auth endpoints

### 🏗️  Architecture
- Hexagonal Architecture (Ports & Adapters)
- Domain-Driven Design (DDD) with rich domain model
- CQRS - explicit command/query separation
- Event-Driven - domain events for email notifications
- Specification Pattern for product variant availability

### 📦 Infrastructure
- Docker Compose with PostgreSQL 17, Redis 7, Nginx, Adminer
- Symfony Scheduler - stock and EAN sync every 15 minutes
- Redis for caching and session storage with TTL-based invalidation
- Prometheus + Grafana for metrics, Sentry for error tracking

### 🔌 Integrations
- Stripe API - card payments and refunds
- Symfony Mailer - emails (verification, reset, order confirmation...)
- apicountries.com - country data with Redis cache
- wkhtmltopdf - PDF invoice generation

### 🧪 Tests      
- Backend: PHPUnit (Unit / Integration / Feature), PHPStan (lvl. 10), Deptrac, PHPMD
- Frontend: Vitest (Unit / Integration / Functional), Playwright E2E (auth flows)
- All implemented tests pass at 100%
