<?php declare(strict_types=1);

namespace Avent\CoverBulkEdit\Message;

class UpdateProductCoverMessage
{
    private array $productIds;

    public function __construct(array $productIds)
    {
        $this->productIds = $productIds;
    }

    public function getProductIds(): array
    {
        return $this->productIds;
    }
}
