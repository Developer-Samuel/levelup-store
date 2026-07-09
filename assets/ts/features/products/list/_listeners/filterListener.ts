import type { ProductListInstance } from '@/ts/features/products/list/types'
import { setupBrandFilter } from '@/ts/features/products/list/_filters/brandFilter'
import { setupPriceFilter } from '@/ts/features/products/list/_filters/priceFilter'
import { setupSubtypeFilter } from '@/ts/features/products/list/_filters/subtypeFilter'
import { attachLoadMoreListener } from '@/ts/features/products/list/_listeners/loadMoreListener'
import { attachSortListener } from '@/ts/features/products/list/_listeners/sortListener'

export function attachFilterListener(ctx: ProductListInstance): void {
  setupSubtypeFilter(ctx)
  setupBrandFilter(ctx)
  setupPriceFilter(ctx)

  const sortSelect = document.getElementById('sort-by')
  attachSortListener(ctx, sortSelect)

  attachLoadMoreListener(ctx)
}
