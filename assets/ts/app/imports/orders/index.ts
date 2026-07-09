import type { AppModule } from '@/ts/app/types'

export const ordersModules: AppModule[] = [
  { selector: '.order', module: () => import('@/ts/features/orders/create/index') },
]
