<?php

declare(strict_types=1);

namespace App\Presentation\Abstract\Request;

use Symfony\{
    Component\HttpFoundation\Request,
    Component\Security\Csrf\CsrfTokenManagerInterface,
    Component\Validator\Validator\ValidatorInterface
};

use Kit\Utils\Shared\Sanitizer\DataSanitizer;

use App\Presentation\Shared\Traits\CsrfProtection;

abstract class AbstractRequest
{
    use CsrfProtection;

    private const INT_FIELDS = ['billing_country', 'shipping_country'];

    /**
     * @param CsrfTokenManagerInterface $csrfTokenManager
    */
    public function __construct(
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ) {}

    /**
     * @param Request $request
     *
     * @return void
    */
    abstract protected function populateData(Request $request): void;

    /**
     * @return CsrfTokenManagerInterface
    */
    protected final function resolveCsrfTokenManager(): CsrfTokenManagerInterface
    {
        return $this->csrfTokenManager;
    }

    /**
     * @param Request $request
     * @param string $field
     *
     * @return void
    */
    protected final function extractTypedField(Request $request, string $field): void
    {
        if (!property_exists($this, $field)) {
            return;
        }

        $rawValue = $request->request->get($field);

        if (in_array($field, self::INT_FIELDS, true)) {
            $this->{$field} = DataSanitizer::sanitizeInt($rawValue) ?? 0;

            return;
        }

        $this->{$field} = DataSanitizer::sanitizeString($rawValue);
    }

    /**
     * @param ValidatorInterface|null $validator
     *
     * @return array<string, string>
    */
    final public function errors(?ValidatorInterface $validator): array
    {
        if ($validator === null) {
            return [];
        }

        $errors = $validator->validate($this);
        $result = [];

        foreach ($errors as $error) {
            $result[$error->getPropertyPath()] = (string) $error->getMessage();
        }

        return $result;
    }

    /**
     * @param Request $request
     * @param CsrfTokenManagerInterface $csrfTokenManager
     * @param object|null $tracker
     *
     * @return static
    */
    public static function fromHttpRequest(
        Request $request,
        CsrfTokenManagerInterface $csrfTokenManager,
        ?object $tracker = null,
    ): static {
        /** @phpstan-ignore-next-line */
        $instance = new static($csrfTokenManager);

        $factory = static fn(): static => $instance;

        return self::baseFromHttpRequest(
            $request,
            $factory,
            self::resolveTrackerCallback($tracker),
        );
    }

    /**
     * @template T of self
     *
     * @param Request $request
     * @param \Closure(): T $factory
     * @param (\Closure(T): void)|null $trackerCallback
     *
     * @return T
    */
    private static function baseFromHttpRequest(
        Request $request,
        \Closure $factory,
        ?callable $trackerCallback = null,
    ): self {
        $instance = $factory();
        $instance->csrfToken = $request->request->getString('_csrf_token', '');

        $instance->populateData($request);

        if ($trackerCallback !== null) {
            $trackerCallback($instance);
        }

        return $instance;
    }

    /**
     * @param object|null $tracker
     *
     * @return (\Closure(self): void)|null
    */
    private static function resolveTrackerCallback(?object $tracker): ?callable
    {
        if ($tracker !== null && method_exists($tracker, 'trackAttempts')) {
            /** @param self $request */
            return static function (self $request) use ($tracker): void {
                $tracker->trackAttempts();
            };
        }

        return null;
    }
}
