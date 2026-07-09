type ActionButtonOptions = {
  className: string
  text: string
  id?: string | number
}

/** Creates a table cell containing a single action link */
export function createActionButton({ className, text, id }: ActionButtonOptions): HTMLTableCellElement {
  const a = document.createElement('a')
  a.className = className
  a.textContent = text
  a.dataset.id = id !== undefined ? String(id) : ''
  a.href = ''

  const td = document.createElement('td')
  td.appendChild(a)

  return td
}
