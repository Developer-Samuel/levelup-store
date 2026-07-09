import { toggleClass } from '@/ts/shared/utils/dom/classes'

const SCROLL_THRESHOLD = 135

export function attachScrollListener(headerMain: HTMLElement | null): void {
  if (!headerMain) return

  window.addEventListener('scroll', (): void => {
    toggleClass(headerMain, 'header__main--scrolled', window.scrollY > SCROLL_THRESHOLD)
  })
}
