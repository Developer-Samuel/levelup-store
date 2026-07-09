import { submitFormData } from '@/ts/core/http/_services/submitFormData'

import { query } from '@/ts/shared/utils/dom/query'

import type { CartResponse } from '@/ts/features/cart/types'

type CartResult = Promise<CartResponse | null>

function getCsrfToken(id: string): string {
  const input = query<HTMLInputElement>(`#${id}`)
  if (!input) throw new Error('CSRF token not found for')

  return input.value
}

export async function cartAdd(variantId: string | number): CartResult {
  const formData = new FormData()
  formData.append('variant_id', String(variantId))
  formData.append('_csrf_token', getCsrfToken('csrf-cart-store'))

  return await submitFormData<CartResponse>('/cart/store', formData)
}

export async function cartRemove(itemId: string | number): CartResult {
  const formData = new FormData()
  formData.append('item_id', String(itemId))
  formData.append('_csrf_token', getCsrfToken('csrf-cart-destroy'))

  return await submitFormData<CartResponse>('/cart/destroy', formData)
}
