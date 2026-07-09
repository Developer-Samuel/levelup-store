import { BREAKPOINT_LG } from '@/ts/shared/constants/breakpoints'
import { toggleClass } from '@/ts/shared/utils/dom/classes'

import { NAV_LIST_SCROLLED, SCROLL_THRESHOLD } from '@/ts/presentation/layout/navigation/constants'

export function toggleScrolledClass(element: HTMLElement | null): void {
  if (!element) return

  toggleClass(element, NAV_LIST_SCROLLED, window.scrollY > SCROLL_THRESHOLD)
}

export function removeScrolledClass(element: HTMLElement | null): void {
  if (!element) return

  element.classList.remove(NAV_LIST_SCROLLED)
}

export function syncScrolledClass(element: HTMLElement | null): void {
  if (window.innerWidth < BREAKPOINT_LG) {
    removeScrolledClass(element)
  } else {
    toggleScrolledClass(element)
  }
}
