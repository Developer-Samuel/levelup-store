import { test, expect, type Page } from '@playwright/test'

import { APP_URL } from '@/tests/e2e/config'

import { TEST_USER } from '@/tests/e2e/data/users'

import { LoginPage } from '@/tests/e2e/pages/auth/LoginPage'
import { OrderCreatePage } from '@/tests/e2e/pages/orders/OrderCreatePage'

const VALID_ORDER = {
  personal: { email: TEST_USER.email, firstName: TEST_USER.firstName, lastName: TEST_USER.lastName },
  billing: { country: 1, street: 'Test Billing 1', postalCode: '12345', city: 'Bratislava' },
  shipping: { country: 1, street: 'Test Shipping 1', postalCode: '12345', city: 'Prague' },
}

async function addProductToCart(page: Page): Promise<void> {
  await page.goto(`${APP_URL}/products`, { waitUntil: 'load' })
  await expect(page.locator('.products')).toBeVisible({ timeout: 15_000 })

  const [csrfToken, variantId] = await page.evaluate(() => {
    const csrf = document.querySelector<HTMLInputElement>('#csrf-cart-store')
    const buyBtn = document.querySelector<HTMLElement>('.buy-btn[data-variant-id]')
    return [csrf?.value ?? '', buyBtn?.dataset['variantId'] ?? '']
  })

  if (!csrfToken || !variantId) {
    throw new Error(`Cart add: csrf=${csrfToken ? 'ok' : 'missing'}, variantId=${variantId ? 'ok' : 'missing'}`)
  }

  const response = await page.request.post(`${APP_URL}/cart/store`, {
    form: { variant_id: variantId, _csrf_token: csrfToken },
    timeout: 30_000,
  })

  if (!response.ok()) {
    throw new Error(`Cart add failed: HTTP ${response.status()}`)
  }
}

test.describe.configure({ mode: 'serial' })

test.describe('Order Create Page', () => {
  let sharedPage: Page
  let orderPage: OrderCreatePage

  test.beforeAll(async ({ browser }) => {
    test.setTimeout(120_000)

    if (!TEST_USER.email || !TEST_USER.password) return

    const context = await browser.newContext()

    sharedPage = await context.newPage()

    const loginPage = new LoginPage(sharedPage)
    await loginPage.goto()
    await loginPage.login(TEST_USER.email, TEST_USER.password)
    await sharedPage.waitForURL((url) => !url.pathname.includes('/login'), { waitUntil: 'commit' })

    await addProductToCart(sharedPage)
  })

  test.beforeEach(async () => {
    if (!TEST_USER.email || !TEST_USER.password || !sharedPage) {
      test.skip(true, 'TEST_USER_EMAIL / TEST_USER_PASSWORD not set in .env.test')
      return
    }

    orderPage = new OrderCreatePage(sharedPage)

    await orderPage.goto()
    await orderPage.dismissCookies()
  })

  // ── Page load ──────────────────────────────────────────────────────────────

  test('should load the order create page', async () => {
    await expect(orderPage.root).toBeVisible()
    await expect(orderPage.form).toBeVisible()
  })

  test('should display all sections', async () => {
    await expect(orderPage.personalSection).toBeVisible()
    await expect(orderPage.billingSection).toBeVisible()
    await expect(orderPage.shippingSection).toBeVisible()
    await expect(orderPage.paymentSection).toBeVisible()
  })

  test('should display personal data fields', async () => {
    await expect(orderPage.emailInput).toBeVisible()
    await expect(orderPage.firstNameInput).toBeVisible()
    await expect(orderPage.lastNameInput).toBeVisible()
  })

  test('should display billing data fields', async () => {
    await expect(orderPage.billingStreetInput).toBeVisible()
    await expect(orderPage.billingPostalCodeInput).toBeVisible()
    await expect(orderPage.billingCountrySelect).toBeVisible()
    await expect(orderPage.billingCityInput).toBeVisible()
  })

  test('should display payment method options', async () => {
    await expect(orderPage.paymentSection).toBeVisible()
    await expect(orderPage.cardRadio).toBeVisible()
  })

  test('should display total price and submit button', async () => {
    await expect(orderPage.totalPrice).toBeVisible()
    await expect(orderPage.submitBtn).toBeVisible()
  })

  // ── Shipping toggle ────────────────────────────────────────────────────────

  test('should disable shipping fields when send_shipping is unchecked', async () => {
    await orderPage.toggleSendShipping(false)

    await expect(orderPage.shippingStreetInput).toBeDisabled()
    await expect(orderPage.shippingCityInput).toBeDisabled()
  })

  test('should enable shipping fields when send_shipping is checked', async () => {
    await orderPage.toggleSendShipping(true)

    await expect(orderPage.shippingStreetInput).toBeEnabled()
    await expect(orderPage.shippingCityInput).toBeEnabled()
  })

  // ── Form interaction ───────────────────────────────────────────────────────

  test('should allow typing into personal data fields', async () => {
    const { email, firstName, lastName } = VALID_ORDER.personal

    await orderPage.fillPersonal(email, firstName, lastName)

    await expect(orderPage.emailInput).toHaveValue(email)
    await expect(orderPage.firstNameInput).toHaveValue(firstName)
    await expect(orderPage.lastNameInput).toHaveValue(lastName)
  })

  test('should allow typing into billing data fields', async () => {
    const { street, postalCode, city } = VALID_ORDER.billing

    await orderPage.billingStreetInput.fill(street)
    await orderPage.billingPostalCodeInput.fill(postalCode)
    await orderPage.billingCityInput.fill(city)

    await expect(orderPage.billingStreetInput).toHaveValue(street)
    await expect(orderPage.billingPostalCodeInput).toHaveValue(postalCode)
    await expect(orderPage.billingCityInput).toHaveValue(city)
  })

  test('should allow typing into shipping data fields when enabled', async () => {
    await orderPage.toggleSendShipping(true)

    const { country, street, postalCode, city } = VALID_ORDER.shipping

    await orderPage.shippingCountrySelect.selectOption({ index: country })
    await orderPage.shippingStreetInput.fill(street)
    await orderPage.shippingPostalCodeInput.fill(postalCode)
    await orderPage.shippingCityInput.fill(city)

    await expect(orderPage.shippingStreetInput).toHaveValue(street)
    await expect(orderPage.shippingPostalCodeInput).toHaveValue(postalCode)
    await expect(orderPage.shippingCityInput).toHaveValue(city)
  })

  // ── Validation ─────────────────────────────────────────────────────────────

  test('should show validation feedback when submitting empty form', async () => {
    await orderPage.submit()

    await orderPage.page.waitForFunction(
      () => {
        const errors = document.querySelectorAll('.order__card-form-group .error')
        const alert = document.querySelector('#order-page .alert.alert--visible')
        const hasFieldError = Array.from(errors).some((el) => (el.textContent?.trim() ?? '') !== '')
        return hasFieldError || alert !== null
      },
      { timeout: 8_000 },
    )
  })

  // ── Successful order ───────────────────────────────────────────────────────

  test('should redirect to success page after cash on delivery submission', async () => {
    test.setTimeout(90_000)

    const { email, firstName, lastName } = VALID_ORDER.personal
    const { country, street, postalCode, city } = VALID_ORDER.billing

    await orderPage.fillPersonal(email, firstName, lastName)
    await orderPage.billingCountrySelect.selectOption({ index: country })
    await orderPage.billingStreetInput.fill(street)
    await orderPage.billingPostalCodeInput.fill(postalCode)
    await orderPage.billingCityInput.fill(city)

    await orderPage.cashRadio.evaluate((el) => {
      const input = el as HTMLInputElement
      input.checked = true
      input.dispatchEvent(new Event('change', { bubbles: true }))
    })

    await orderPage.submit()
    await orderPage.page.waitForURL('**/orders/success', { waitUntil: 'commit', timeout: 60_000 })

    await expect(orderPage.page.locator('#order-success')).toBeVisible({ timeout: 10_000 })
  })
})
