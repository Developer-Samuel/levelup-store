import { BREAKPOINT_LG } from '@/ts/shared/constants/breakpoints'
import { toggleClass } from '@/ts/shared/utils/dom/classes'

import { SCROLL_THRESHOLD } from '@/ts/presentation/layout/common/constants'
import { dispatchHeaderToggle } from '@/ts/presentation/layout/header/_events/toggle'

let lastScrollY = 0

export function handleScroll(headerMain: HTMLElement): void {
  const currentScrollY = window.scrollY

  toggleClass(headerMain, 'header__main--scrolled', currentScrollY > SCROLL_THRESHOLD)

  if (window.innerWidth < BREAKPOINT_LG) {
    const header = headerMain.parentElement
    if (header) {
      const scrollingDown = currentScrollY > lastScrollY
      const hidden = scrollingDown && currentScrollY > SCROLL_THRESHOLD

      toggleClass(header, 'header--hidden', hidden)
      dispatchHeaderToggle(header, hidden)
    }
  }

  lastScrollY = currentScrollY
}
