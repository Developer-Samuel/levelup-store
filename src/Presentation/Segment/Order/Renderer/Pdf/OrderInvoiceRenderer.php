<?php

declare(strict_types=1);

namespace App\Presentation\Segment\Order\Renderer\Pdf;

use Twig\Environment;

use App\Core\Ports\Segment\Order\Renderer\Pdf\OrderInvoiceRendererContract;

final readonly class OrderInvoiceRenderer implements OrderInvoiceRendererContract
{
    /**
     * @param Environment $twig
    */
    public function __construct(
        private Environment $twig,
    ) {}

    /**
     * @param array<string, mixed> $data
     *
     * @return string
    */
    public function render(array $data): string
    {
        return $this->twig->render('documents/orders-invoice.html.twig', $data);
    }
}
