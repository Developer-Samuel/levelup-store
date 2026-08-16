import type { HtmlElList } from '@/ts/shared/types'

import type { ImageCarouselInstance } from '@/ts/features/products/detail/types'
import { getImageCarouselElements } from '@/ts/features/products/detail/_ui/elements'
import { slideTo, updateWidth } from '@/ts/features/products/detail/_ui/slider'
import { attachArrowClickListener } from '@/ts/features/products/detail/_listeners/arrowClickListener'
import { attachMouseListeners } from '@/ts/features/products/detail/_listeners/mouseListener'
import { attachTouchListeners } from '@/ts/features/products/detail/_listeners/touchListener'

export default class ImageCarousel implements ImageCarouselInstance {
  track: HTMLElement
  thumbs: HtmlElList
  currentIndex: number
  total: number
  isDragging: boolean
  isHorizontalSwipe: boolean | null
  startX: number
  startY: number
  currentTranslate: number
  prevTranslate: number
  animationID: number
  containerWidth: number

  constructor() {
    const { track, thumbs } = getImageCarouselElements()

    if (!track) throw new Error('ImageCarousel: track element not found')

    this.track = track
    this.thumbs = thumbs
    this.currentIndex = 0
    this.total = this.thumbs.length
    this.isDragging = false
    this.isHorizontalSwipe = null
    this.startX = 0
    this.startY = 0
    this.currentTranslate = 0
    this.prevTranslate = 0
    this.animationID = 0
    this.containerWidth = 0

    this.initListeners()
    this.initArrows()

    updateWidth(this)
    slideTo(this, this.currentIndex, false)
  }

  private initListeners(): void {
    if (this.total <= 1) return

    this.thumbs.forEach((thumb, index) => {
      thumb.addEventListener('click', () => slideTo(this, index))
    })

    attachMouseListeners(this.track, this)
    attachTouchListeners(this.track, this)
    window.addEventListener('resize', () => updateWidth(this))
  }

  private initArrows(): void {
    const arrowLeft = document.getElementById('arrow-left')
    const arrowRight = document.getElementById('arrow-right')

    attachArrowClickListener(arrowLeft, this, -1)
    attachArrowClickListener(arrowRight, this, +1)
  }
}
