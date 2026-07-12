import { BREAKPOINT_XL } from '@/ts/shared/constants/breakpoints'

import { toggle } from '@/ts/features/products/list/_ui/visibility'

export function handleResize(productFilter: HTMLElement, lastWidth: { value: number }): void {
  const currentWidth = window.innerWidth
  if (currentWidth === lastWidth.value) return

  lastWidth.value = currentWidth
  toggle(productFilter, currentWidth >= BREAKPOINT_XL)
}
