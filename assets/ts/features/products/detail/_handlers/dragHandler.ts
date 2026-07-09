import type { ImageCarouselInstance } from '@/ts/features/products/detail/types'
import { getPositionX } from '@/ts/features/products/detail/_utils/touchPosition'
import { applyDraggingStyles, removeDraggingStyles } from '@/ts/features/products/detail/_ui/dragging'
import { slideTo, setSliderPosition } from '@/ts/features/products/detail/_ui/slider'

const SWIPE_THRESHOLD = 50

export function handleDragStart(event: MouseEvent | TouchEvent, carousel: ImageCarouselInstance): void {
  carousel.isDragging = true
  carousel.startX = getPositionX(event)

  cancelAnimationFrame(carousel.animationID)

  applyDraggingStyles(carousel.track)
}

export function handleDragAction(event: MouseEvent | TouchEvent, carousel: ImageCarouselInstance): void {
  if (!carousel.isDragging) return

  const currentPosition = getPositionX(event)
  const diff = currentPosition - carousel.startX

  carousel.currentTranslate = carousel.prevTranslate + diff
  setSliderPosition(carousel)
}

export function handleDragEnd(carousel: ImageCarouselInstance): void {
  if (!carousel.isDragging) return

  carousel.isDragging = false
  removeDraggingStyles(carousel.track)

  const movedBy = carousel.currentTranslate - carousel.prevTranslate

  if (movedBy < -SWIPE_THRESHOLD) {
    carousel.currentIndex = (carousel.currentIndex + 1) % carousel.total
  } else if (movedBy > SWIPE_THRESHOLD) {
    carousel.currentIndex = (carousel.currentIndex - 1 + carousel.total) % carousel.total
  }

  slideTo(carousel, carousel.currentIndex)
}
