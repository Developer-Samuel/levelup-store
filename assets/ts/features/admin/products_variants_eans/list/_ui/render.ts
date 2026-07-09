import { capitalize } from '@/ts/shared/utils/capitalize'
import { createActionButton } from '@/ts/shared/elements/table/_ui/actionButton'

import { renderDatatableRows } from '@/ts/plugins/datatables/_ui/render'

import type { RendererActionButton } from '@/ts/features/admin/products_variants/types'

type Ean = {
  id: number
  variantId: number
  code: string
  status: string
  createdAt: string
  [key: string]: unknown
}

const COLUMNS = ['code', 'createdAt'] as const

export function renderEans(tbody: HTMLTableSectionElement, items: unknown[]): void {
  const eans = items as Ean[]
  renderDatatableRows(tbody, eans, COLUMNS, {
    actionButton: (row: Ean): HTMLTableCellElement => {
      const td = document.createElement('td')

      const buttons: RendererActionButton[] = [
        {
          className: 'btn btn--sm btn--blue variant-eans-update-btn',
          text: 'Edit',
          href: `/admin/variants/eans/edit/${row.variantId}/${row.id}`,
          attrs: {},
        },
        {
          className: 'btn btn--sm btn--red variant-eans-destroy-btn',
          text: 'Destroy',
          href: '#',
          attrs: {
            'data-id': String(row.id),
            role: 'button',
          },
        },
      ]

      buttons.forEach((btn) => {
        const el = createActionButton({ className: btn.className, text: btn.text, id: row.id })
        const a = el.querySelector('a')
        if (a) {
          a.href = btn.href
          Object.entries(btn.attrs).forEach(([k, v]) => a.setAttribute(k, v))
          td.appendChild(a)
        }
      })

      return td
    },

    cellRenderers: {
      status: (val: unknown) => capitalize(String(val ?? '')),
    },

    emptyText: 'No eans found',
  })
}
