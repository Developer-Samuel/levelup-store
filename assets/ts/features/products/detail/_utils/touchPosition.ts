export function getPositionX(event: MouseEvent | TouchEvent): number {
  if (event instanceof TouchEvent) {
    return event.touches[0]?.clientX ?? 0
  }

  return event.clientX
}
