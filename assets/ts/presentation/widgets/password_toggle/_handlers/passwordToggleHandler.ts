import { query, queryAll } from '@/ts/shared/utils/dom/query'

import { TOGGLE_ICON_SELECTOR, PASSWORD_FIELDS_SELECTORS } from '@/ts/presentation/widgets/password_toggle/constants'
import { showPasswords, hidePasswords } from '@/ts/presentation/widgets/password_toggle/_ui/passwordToggle'

function resolveFields(): HTMLInputElement[] {
  return PASSWORD_FIELDS_SELECTORS.map((selector) => query<HTMLInputElement>(selector)).filter(
    (el): el is HTMLInputElement => el !== null,
  )
}

function resolveIcons(): HTMLImageElement[] {
  return Array.from(queryAll<HTMLImageElement>(TOGGLE_ICON_SELECTOR))
}

function resolveIconForField(icon: HTMLElement): HTMLImageElement | null {
  return icon instanceof HTMLImageElement ? icon : null
}

function resolveFieldForIcon(icon: HTMLElement): HTMLInputElement | null {
  return icon.parentElement?.querySelector<HTMLInputElement>('input') ?? null
}

export function handlePasswordShow(icon: HTMLElement): void {
  const field = resolveFieldForIcon(icon)
  const iconEl = resolveIconForField(icon)

  if (field) {
    showPasswords([field], iconEl ? [iconEl] : [])
    return
  }

  const fields = resolveFields()
  if (fields.length === 0) return
  showPasswords(fields, resolveIcons())
}

export function handlePasswordHide(icon: HTMLElement): void {
  const field = resolveFieldForIcon(icon)
  const iconEl = resolveIconForField(icon)

  if (field) {
    hidePasswords([field], iconEl ? [iconEl] : [])
    return
  }

  const fields = resolveFields()
  if (fields.length === 0) return
  hidePasswords(fields, resolveIcons())
}
