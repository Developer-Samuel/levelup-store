import { createFormHandler } from '@/ts/shared/elements/form/_factory/formHandlerFactory'

import profileSubmit from '@/ts/features/users/profile/_services/profileService'

export const handleProfileFormSubmit = createFormHandler(profileSubmit, {
  onSuccess(data, { alert }) {
    alert.display(true, data.message ?? '')
  },
})
