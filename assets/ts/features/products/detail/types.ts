import type { HtmlElList } from '@/ts/shared/types'

export type ImageCarouselInstance = {
  track: HTMLElement
  thumbs: HtmlElList
  currentIndex: number
  total: number
  isDragging: boolean
  startX: number
  currentTranslate: number
  prevTranslate: number
  animationID: number
  containerWidth: number
}

export type ScrollComponent = {
  button: HTMLElement | null
  target: HTMLElement | null
}
