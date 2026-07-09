export function attachViewportListener(onViewportChange: () => void): void {
  window.addEventListener('load', onViewportChange, { once: true })
  window.addEventListener('resize', onViewportChange)
}
