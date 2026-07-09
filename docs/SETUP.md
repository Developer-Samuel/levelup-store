# ⚙️ SETUP.md

Minimal setup guide for **environment variables and runtime configuration**.

**Source of truth:**  
- `.env.example` (default, Docker / shared setup)  
- `.env.local.example` (local development overrides)

This file explains **only the steps required to prepare configuration**.  
It does not document individual variable meanings - those live inline in the `.env.example` files.

---

## 1. Preparation

Before configuring environment variables, make sure the project dependencies are installed.

Complete **steps 1 and 2** from [INSTALL.md](INSTALL.md):

---

## 2. Environment Variables & Services

All environment variables and configuration options are fully documented inline in
`.env.example` and `.env.local.example`.
Review comments carefully before editing to avoid misconfiguration.

Core variables to check / configure:

- **HMAC Secret**  
  `HMAC_SECRET`  
  Used for signing tokens, cookies, or hidden inputs. Must be a secure, random secret.
  
- **Database**  
  `DATABASE_URL`  
  Supports PostgreSQL or MySQL.

- **Redis**  
  `REDIS_URL`  
  Used for cache and sessions. Disable if not required.

- **Mailer**  
  `MAILER_DSN`  
  SMTP / email service configuration.

- **Payments**  
  `STRIPE_PUBLIC`, `STRIPE_SECRET`

- **PDF Generation (wkhtmltopdf)**  
  `WKHTMLTOPDF_PATH`

  - **Linux / macOS / Docker (default):**

    ```env
    WKHTMLTOPDF_PATH="/usr/local/bin/wkhtmltopdf"
    ```

  - **Windows (native, e.g. XAMPP):**
    - Download and install **[wkhtmltopdf](https://wkhtmltopdf.org/downloads.html)** from the official website.
    - Set the full path to the executable in `.env` or `.env.local.example`:
    
      ```env
      WKHTMLTOPDF_PATH="C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"
      ```

> ⚠️ Reminder:
- `.env.example` is the primary source of documentation.
- `.env.local.example` is intended only for overriding values when running outside Docker (e.g. native Windows setup).

---

## 3. Advanced Config Files (edit only if necessary)
Defaults for: 
- PostgreSQL
- Redis (cache, sessions, rate limiting)

Modify these framework configs only for engine-level changes (e.g., switching adapters):
- `config/packages/cache.yaml` -> Cache adapter (`Redis`/`filesystem`)
- `config/packages/doctrine.yaml` -> Database engine (`PostgreSQL` or `MySQL`)
- `config/packages/framework.yaml` -> Session handler (`Redis` or `Native`)

---

> ⚠️ Final note
- This document is solely for **setting up environment variables and runtime configuration**.
- All variable documentation must live as inline comments inside
  `.env.example` or `.env.local.example`.
