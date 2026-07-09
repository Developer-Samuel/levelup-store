import { BREAKPOINT_XL } from '@/ts/shared/constants/breakpoints'

import { toggle } from '@/ts/features/products/list/_ui/visibility'

export function attachResizeListener(productFilter: HTMLElement | null): void {
  if (!productFilter) return

  window.addEventListener('resize', () => {
    toggle(productFilter, window.innerWidth >= BREAKPOINT_XL)
  })
}
