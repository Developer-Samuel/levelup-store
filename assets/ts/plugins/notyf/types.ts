type NotyfShape = {
  type: 'success' | 'error' | 'info'
  background: string
  icon: {
    className: string
    tagName: keyof HTMLElementTagNameMap
  }
}

export type NotyfConfig = {
  duration: number
  position: {
    x: 'left' | 'center' | 'right'
    y: 'top' | 'bottom'
  }
  dismissible: boolean
  ripple: boolean
  types: NotyfShape[]
}
