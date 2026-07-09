import type { NotyfConfig } from '@/ts/plugins/notyf/types'

/** Default Notyf configuration */
const NOTYF_CONFIG: NotyfConfig = {
  duration: 7500,
  position: { x: 'center', y: 'top' },
  dismissible: true,
  ripple: false,
  types: [
    {
      type: 'success',
      background: '#22C55E',
      icon: { className: 'fas fa-check-circle', tagName: 'i' },
    },
    {
      type: 'error',
      background: '#FF4F4F',
      icon: { className: 'fas fa-times-circle', tagName: 'i' },
    },
    {
      type: 'info',
      background: '#3DBBFF',
      icon: { className: 'fas fa-info-circle', tagName: 'i' },
    },
  ],
}

export default NOTYF_CONFIG
