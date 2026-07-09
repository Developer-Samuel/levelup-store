import { mockProductsListUiVisibility } from '@/tests/_support/mocks/features/products/list.mocks'

mockProductsListUiVisibility()

import { toggle } from '@/ts/features/products/list/_ui/visibility'
import { attachResizeListener } from '@/ts/features/products/list/_listeners/resizeListener'

const mockedToggle = vi.mocked(toggle)

describe('attachResizeListener()', () => {
  beforeEach(() => {
    vi.clearAllMocks()
    vi.restoreAllMocks()
  })

  it('should do nothing when productFilter is null', () => {
    expect(() => attachResizeListener(null)).not.toThrow()
  })

  it('should call toggle with true when innerWidth >= 1280', () => {
    vi.spyOn(window, 'innerWidth', 'get').mockReturnValue(1280)
    const filter = document.createElement('div')

    attachResizeListener(filter)
    window.dispatchEvent(new Event('resize'))

    expect(mockedToggle).toHaveBeenCalledWith(filter, true)
  })

  it('should call toggle with false when innerWidth < 1280', () => {
    vi.spyOn(window, 'innerWidth', 'get').mockReturnValue(768)
    const filter = document.createElement('div')

    attachResizeListener(filter)
    window.dispatchEvent(new Event('resize'))

    expect(mockedToggle).toHaveBeenCalledWith(filter, false)
  })

  it('should call toggle with false when innerWidth is exactly 1279', () => {
    vi.spyOn(window, 'innerWidth', 'get').mockReturnValue(1279)
    const filter = document.createElement('div')

    attachResizeListener(filter)
    window.dispatchEvent(new Event('resize'))

    expect(mockedToggle).toHaveBeenCalledWith(filter, false)
  })
})
