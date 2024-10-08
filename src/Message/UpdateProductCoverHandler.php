<?php declare(strict_types=1);

namespace Avent\CoverBulkEdit\Message;

use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\Connection;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\Api\Sync\SyncBehavior;
use Shopware\Core\Framework\Api\Sync\SyncOperation;
use Shopware\Core\Framework\Api\Sync\SyncServiceInterface;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateProductCoverHandler
{
    public function __construct(private readonly SyncServiceInterface $syncService, private readonly Connection $connection)
    {
    }

    public function __invoke(UpdateProductCoverMessage $message): void
    {
        if (empty($message->getProductIds())) {
            return;
        }

        $mediaProducts = $this->getProductMedia($message->getProductIds());
        if (empty($mediaProducts)) {
            return;
        }

        $mediaByProductId = [];
        foreach ($mediaProducts as $mediaProduct) {
            $mediaByProductId[$mediaProduct['productId']][] = [
                'id' => $mediaProduct['id'],
                'mediaId' => $mediaProduct['mediaId'],
                'position' => (int) $mediaProduct['position'],
            ];
        }

        $sortedMediaProducts = [];
        foreach ($mediaByProductId as $productId => $media) {
            usort($media, fn($a, $b) => $a['position'] <=> $b['position']);
            $sortedMediaProducts[$productId] = $media;
        }

        $upsertPayload = [];
        foreach ($message->getProductIds() as $productId) {
            $mediaList = $sortedMediaProducts[$productId] ?? [];
            if (empty($mediaList)) {
                continue;
            }

            $firstMedia = reset($mediaList);
            $upsertPayload[] = [
                'id' => $productId,
                'coverId' => $firstMedia['id'],
            ];
        }

        if (!empty($upsertPayload)) {
            $operations[] = new SyncOperation(
                'upsert',
                ProductDefinition::ENTITY_NAME,
                SyncOperation::ACTION_UPSERT,
                $upsertPayload
            );
        }

        if (empty($operations)) {
            return;
        }

        $this->syncService->sync($operations, Context::createCLIContext(), new SyncBehavior());
    }

    private function getProductMedia(array $productIds): array
    {
        $query = $this->connection->createQueryBuilder();
        $query->select('LOWER(HEX(id)) as id, LOWER(HEX(product_id)) as productId, LOWER(HEX(media_id)) as mediaId, position');
        $query->from('product_media');
        $query->where('product_id IN (:productIds)');
        $query->setParameter('productIds', Uuid::fromHexToBytesList($productIds), ArrayParameterType::BINARY);

        return $query->executeQuery()->fetchAllAssociative();
    }
}
