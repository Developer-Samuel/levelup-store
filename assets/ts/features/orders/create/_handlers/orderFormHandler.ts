import orderSubmit from '@/ts/features/orders/create/_services/orderService'
import { createFormHandler } from '@/ts/shared/elements/form/_factory/formHandlerFactory'

/**
 * Submits the order form and sets a success flag.
 * Redirects or reloads the page based on 'data.redirect'.
 */
export const handleOrderFormSubmit = createFormHandler(orderSubmit, {
  onSuccess: () => {},
})
