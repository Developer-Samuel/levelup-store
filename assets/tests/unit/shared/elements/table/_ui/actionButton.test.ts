import { createActionButton } from '@/ts/shared/elements/table/_ui/actionButton'

describe('createActionButton()', () => {
  it('should return a td element', () => {
    expect(createActionButton({ className: 'btn', text: 'Edit' }).tagName).toBe('TD')
  })

  it('should contain an anchor element', () => {
    const td = createActionButton({ className: 'btn', text: 'Edit' })
    expect(td.querySelector('a')).not.toBeNull()
  })

  it('should set className on the anchor', () => {
    const td = createActionButton({ className: 'btn-danger', text: 'Delete' })
    expect(td.querySelector('a')?.className).toBe('btn-danger')
  })

  it('should set text on the anchor', () => {
    const td = createActionButton({ className: 'btn', text: 'View' })
    expect(td.querySelector('a')?.textContent).toBe('View')
  })

  it('should set data-id from numeric id', () => {
    const td = createActionButton({ className: 'btn', text: 'Edit', id: 42 })
    expect(td.querySelector('a')?.dataset.id).toBe('42')
  })

  it('should set data-id from string id', () => {
    const td = createActionButton({ className: 'btn', text: 'Edit', id: 'abc-123' })
    expect(td.querySelector('a')?.dataset.id).toBe('abc-123')
  })

  it('should set data-id to empty string when id is not provided', () => {
    const td = createActionButton({ className: 'btn', text: 'Edit' })
    expect(td.querySelector('a')?.dataset.id).toBe('')
  })

  it('should set href to empty string', () => {
    const td = createActionButton({ className: 'btn', text: 'Edit' })
    expect(td.querySelector('a')?.getAttribute('href')).toBe('')
  })
})
