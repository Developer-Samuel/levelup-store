import { toggleClass } from '@/ts/shared/utils/dom/classes'

import { HEADER_TOGGLE } from '@/ts/presentation/layout/header/_events/toggle'

export function attachHeaderToggleListener(mobileContainer: HTMLElement | null): void {
  if (!mobileContainer) return

  document.addEventListener(HEADER_TOGGLE, (e) => {
    const { hidden } = (e as CustomEvent<{ hidden: boolean }>).detail

    toggleClass(mobileContainer, 'navigation__mobile--header-hidden', hidden)
  })
}
