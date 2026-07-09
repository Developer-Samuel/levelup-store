import { queryAll } from '@/ts/shared/utils/dom/query'

import { TOGGLE_ICON_SELECTOR } from '@/ts/presentation/widgets/password_toggle/constants'
import { setCursorPointer } from '@/ts/presentation/widgets/password_toggle/_ui/cursor'
import {
  handlePasswordShow,
  handlePasswordHide,
} from '@/ts/presentation/widgets/password_toggle/_handlers/passwordToggleHandler'
import { attachPasswordToggleListeners } from '@/ts/presentation/widgets/password_toggle/_listeners/passwordToggleListener'

export function bindPasswordToggle(): void {
  const icons = queryAll<HTMLElement>(TOGGLE_ICON_SELECTOR)
  if (!icons.length) return

  setCursorPointer(icons)
  attachPasswordToggleListeners(icons, handlePasswordShow, handlePasswordHide)
}
