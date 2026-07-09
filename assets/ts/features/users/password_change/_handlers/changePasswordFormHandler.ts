import { createFormHandler } from '@/ts/shared/elements/form/_factory/formHandlerFactory'

import changePasswordSubmit from '@/ts/features/users/password_change/_services/changePasswordService'

export const handleChangePasswordFormSubmit = createFormHandler(changePasswordSubmit, {
  onSuccess: (data, { alert }) => {
    alert.display(true, data.message ?? '')
  },
})
