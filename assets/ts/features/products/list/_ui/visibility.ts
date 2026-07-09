export function show(filter: HTMLElement | null): void {
  if (!filter) return

  filter.style.display = 'block'
}

export function hide(filter: HTMLElement | null): void {
  if (!filter) return

  filter.style.display = 'none'
}

export function toggle(filter: HTMLElement | null, condition: boolean): void {
  if (!filter) return

  filter.style.display = condition ? 'block' : 'none'
}

export function isVisible(element: HTMLElement | null): boolean {
  if (!element) return false

  return window.getComputedStyle(element).display !== 'none'
}
