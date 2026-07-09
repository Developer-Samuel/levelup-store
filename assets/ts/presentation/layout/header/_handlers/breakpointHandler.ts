import type { HeaderInstance } from '@/ts/presentation/layout/header/types'
import { updateLogo } from '@/ts/presentation/layout/header/_ui/logo'

export function handleBreakpointChange(instance: HeaderInstance, isDesktop: boolean): void {
  if (!isDesktop) {
    instance.mobileNavigation?.classList.remove('visible')
  }

  updateLogo(instance, isDesktop)
}
