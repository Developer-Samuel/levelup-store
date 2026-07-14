import { createFormHandler } from '@/ts/shared/elements/form/_factory/formHandlerFactory'

import NotyfAlert from '@/ts/plugins/notyf/_components/NotyfAlert'

import changePasswordSubmit from '@/ts/features/users/password_change/_services/changePasswordService'

export const handleChangePasswordFormSubmit = createFormHandler(changePasswordSubmit, {
  onSuccess: (data) => {
    NotyfAlert.success(data.message ?? '')
  },
})
