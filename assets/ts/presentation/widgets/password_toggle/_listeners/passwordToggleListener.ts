import type { HtmlElList } from '@/ts/shared/types'

export function attachPasswordToggleListeners(
  icons: HtmlElList,
  onShow: (icon: HTMLElement) => void,
  onHide: (icon: HTMLElement) => void,
): void {
  for (const icon of icons) {
    icon.addEventListener('mousedown', () => onShow(icon))
    icon.addEventListener('mouseup', () => onHide(icon))
    icon.addEventListener('mouseleave', () => onHide(icon))
  }
}
