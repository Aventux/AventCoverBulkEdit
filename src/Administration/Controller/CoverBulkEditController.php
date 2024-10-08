<?php declare(strict_types=1);

namespace Avent\CoverBulkEdit\Administration\Controller;

use Avent\CoverBulkEdit\Message\UpdateProductCoverMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: ['_routeScope' => ['api']])]
class CoverBulkEditController extends AbstractController
{

    public function __construct( private readonly MessageBusInterface $messageBus)
    {
    }

    #[Route(path: '/api/_action/avent-set-cover', name: 'api.admin.avent.set.cover',methods: ['POST'])]
    public function setCovers(Request $request): Response
    {
        $productIds = $request->request->all()['productIds'] ?? [];
        if (!is_array($productIds) || empty($productIds)) {
            return new JsonResponse(['message' => 'No product ids provided'], Response::HTTP_BAD_REQUEST);
        }

        $trunkedProductIds = array_chunk($productIds, 50);
        foreach ($trunkedProductIds as $productIds) {
            $msg = new UpdateProductCoverMessage($productIds);
            $this->messageBus->dispatch($msg);
        }

        $response = ['message' => 'Covers update sent to the queue'];

        return new JsonResponse($response);
    }
}
