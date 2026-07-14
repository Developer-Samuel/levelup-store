import type { AxiosError } from 'axios'

import type {
  FormResponse,
  FormSubmitResult,
  FormAlert,
  FormErrorsHandler,
  FormSubmitHandler,
} from '@/ts/shared/elements/form/types'
import { handleHttpError } from '@/ts/shared/elements/form/_handlers/httpErrorHandler'
import { scrollToTop } from '@/ts/shared/utils/scroll'
import { sleep } from '@/ts/shared/utils/sleep'

import NotyfAlert from '@/ts/plugins/notyf/_components/NotyfAlert'

type ServiceSubmitFn = (formData: FormData) => FormSubmitResult

type FormHandlerContext = {
  alert: FormAlert
  errors: FormErrorsHandler
}

type CreateFormHandlerOptions = {
  onSuccess?: (data: FormResponse, ctx: FormHandlerContext) => void
  onError?: (data: FormResponse, ctx: FormHandlerContext) => void
  defaultRedirect?: string
  shouldScroll?: boolean
  redirectDelay?: number
  reloadDelay?: number
}

type FormSubmitFn = (form: HTMLFormElement, alert: FormAlert, errors: FormErrorsHandler) => Promise<void>

/**
 * Creates a form submission handler that displays the success message via alert.
 * Use this for forms where the only success action is showing a message.
 */
export const createFormAlertHandler = (serviceSubmit: ServiceSubmitFn): FormSubmitFn =>
  createFormHandler(serviceSubmit, {
    onSuccess: (data) => {
      NotyfAlert.success(data.message ?? '')
    },
  })

/**
 * Creates an async form submission handler.
 *
 * Converts form data, submits via the provided service function,
 * handles success/error, optional callbacks, redirection, and scrolling.
 */
export function createFormHandler(
  serviceSubmit: ServiceSubmitFn,
  options: CreateFormHandlerOptions = {},
): FormSubmitFn {
  const { shouldScroll = true } = options

  return async function (form, alert, errors) {
    const formData = new FormData(form)

    try {
      const data = await serviceSubmit(formData)

      if (!data) return

      if (data.success) {
        if (options.onSuccess) {
          options.onSuccess(data, { alert, errors })
        } else if (data.message) {
          NotyfAlert.success(data.message)
        }

        const redirect = data.redirect && data.redirect !== 'null' ? data.redirect : options.defaultRedirect
        if (redirect) {
          if (options.redirectDelay) await sleep(options.redirectDelay)

          window.location.href = redirect
        } else if (options.reloadDelay) {
          await sleep(options.reloadDelay)

          window.location.reload()
        }

        if (shouldScroll && alert) {
          scrollToTop()
        }
      } else {
        alert.display(false, data.message ?? 'An error occurred.')
        if (data.errors) {
          errors.show(data.errors)
        }
        if (options.onError) {
          options.onError(data, { alert, errors })
        }
      }
    } catch (error) {
      handleHttpError(error as AxiosError<FormResponse>, { alert, errors }, shouldScroll)
    }
  }
}

/** Wraps a form submit handler with pre-submission logic (clears alerts) */
export function createSubmitHandler(
  submitHandler: FormSubmitHandler,
  alert: FormAlert & { clear?: () => void; element?: HTMLElement },
  errors: FormErrorsHandler,
): FormSubmitHandler {
  return async function (form, wrappedAlert, wrappedErrors) {
    if (typeof alert.clear === 'function') alert.clear()
    else if (alert.element) alert.element.style.display = 'none'

    errors.clear?.()

    await submitHandler(form, wrappedAlert, wrappedErrors)
  }
}
