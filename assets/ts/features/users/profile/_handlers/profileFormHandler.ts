import { createFormHandler } from '@/ts/shared/elements/form/_factory/formHandlerFactory'

import NotyfAlert from '@/ts/plugins/notyf/_components/NotyfAlert'

import profileSubmit from '@/ts/features/users/profile/_services/profileService'

export const handleProfileFormSubmit = createFormHandler(profileSubmit, {
  onSuccess(data) {
    NotyfAlert.success(data.message ?? '')
  },
})
