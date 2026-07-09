<?php

declare(strict_types=1);

namespace Tests\Unit\Adapters\Internal\Segment\Order;

use PHPUnit\{
    Framework\MockObject\MockObject,
    Framework\TestCase
};

use App\Core\Ports\{
    Gateways\External\Pdf\SnappyPdfGeneratorGatewayContract,
    Gateways\Internal\Segment\Order\OrderInvoiceGatewayContract,
    Segment\Order\Renderer\Pdf\OrderInvoiceRendererContract
};

use App\Adapters\Internal\Segment\Order\OrderInvoiceAdapter;

/**
 * @coversDefaultClass \App\Adapters\Internal\Segment\Order\OrderInvoiceAdapter
*/
class OrderInvoiceAdapterTest extends TestCase
{
    private SnappyPdfGeneratorGatewayContract&MockObject $pdfGenerator;
    private OrderInvoiceRendererContract&MockObject $renderer;
    private OrderInvoiceAdapter $adapter;

    protected function setUp(): void
    {
        $this->initMocks();
        $this->initAdapter();
    }

    public function testImplementsContract(): void
    {
        $this->assertInstanceOf(OrderInvoiceGatewayContract::class, $this->adapter);
    }

    public function testGenerateReturnsPdfBinaryContent(): void
    {
        $data = ['order_id' => 1];
        $html = '<h1>Invoice</h1>';
        $binary = '%PDF-1.4 binary content';

        $this->renderer
            ->expects($this->once())
            ->method('render')
            ->with($data)
            ->willReturn($html);

        $this->pdfGenerator
            ->expects($this->once())
            ->method('generateFromHtml')
            ->with($html)
            ->willReturn($binary);

        $result = $this->adapter->generate($data);

        $this->assertSame($binary, $result);
    }

    public function testGenerateWrapsRendererExceptionIntoRuntimeException(): void
    {
        $this->assertRendererThrowableWrapped(new \RuntimeException('Template not found'));
    }

    public function testGenerateWrapsPdfGeneratorExceptionIntoRuntimeException(): void
    {
        $this->renderer->method('render')->willReturn('<h1>Invoice</h1>');

        $this->pdfGenerator
            ->method('generateFromHtml')
            ->willThrowException(new \RuntimeException('wkhtmltopdf binary not found'));

        $this->expectInvoiceGenerationFailure('wkhtmltopdf binary not found');

        $this->adapter->generate([]);
    }

    public function testGenerateWrapsAnyThrowableIntoRuntimeException(): void
    {
        $this->assertRendererThrowableWrapped(new \Error('Fatal error'));
    }

    public function testGeneratePreservesOriginalExceptionAsPrevious(): void
    {
        $original = new \RuntimeException('Original cause');

        $this->renderer->method('render')->willThrowException($original);

        try {
            $this->adapter->generate([]);

            $this->fail('RuntimeException expected');
        } catch (\Exception $exception) {
            $this->assertSame($original, $exception->getPrevious());
        }
    }

    private function initMocks(): void
    {
        $this->pdfGenerator = $this->createMock(SnappyPdfGeneratorGatewayContract::class);
        $this->renderer     = $this->createMock(OrderInvoiceRendererContract::class);
    }

    private function initAdapter(): void
    {
        $this->adapter = new OrderInvoiceAdapter($this->pdfGenerator, $this->renderer);
    }

    private function assertRendererThrowableWrapped(\Throwable $throwable): void
    {
        $this->renderer->method('render')->willThrowException($throwable);

        $this->expectInvoiceGenerationFailure($throwable->getMessage());

        $this->adapter->generate([]);
    }

    private function expectInvoiceGenerationFailure(string $cause): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invoice generation failed: ' . $cause);
        $this->expectExceptionCode(500);
    }
}
