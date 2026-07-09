import type { Page, Locator } from '@playwright/test'

import { APP_URL } from '@/tests/e2e/config'

const COOKIE_DOMAIN = new URL(APP_URL).hostname

export abstract class BasePage {
  constructor(protected readonly _page: Page) {}

  get page(): Page {
    return this._page
  }

  async goto(path: string): Promise<void> {
    await this._page.context().addCookies([
      {
        name: 'cookie_consent',
        value: 'true',
        domain: COOKIE_DOMAIN,
        path: '/',
        expires: -1,
        httpOnly: true,
        secure: false,
        sameSite: 'Lax',
      },
    ])

    await this._page.goto(path, { waitUntil: 'load' })
  }

  async disableNativeValidation(form: Locator): Promise<void> {
    await form.evaluate((f) => {
      ;(f as HTMLFormElement).noValidate = true
    })
  }

  async dismissCookies(): Promise<void> {
    const cookieModal = this._page.locator('.modal.cookies')
    const isVisible = await cookieModal.isVisible().catch(() => false)

    if (!isVisible) return

    const cookieBtn = cookieModal.locator('button').first()

    await cookieBtn.click({ force: true, timeout: 5_000 }).catch(() => {})
    await cookieModal.waitFor({ state: 'hidden', timeout: 5_000 }).catch(() => {})
  }
}
