<?php

namespace App\Controller;

use App\CashMachine\CashMachineRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 *
 */
class ApiController extends AbstractController
{
    /**
     * @param CashMachineRegistry $registry
     * @param Request $request
     * @return Response
     * @throws ExceptionInterface
     */
    #[Route('/api/{code}/change/{amount}', name: 'api')]
    public function index(CashMachineRegistry $registry, Request $request): Response
    {
        $data = [];
        $param = $request->attributes->get('_route_params');
        $amount = floatval($param['amount']);
        $change = $registry->get(strval($param['code']))->getChangeEnveloppe($amount);

        $normalizer = new PropertyNormalizer();
        $serializer = new Serializer([$normalizer]);

        $data[$amount] = $serializer->normalize($change->getContent());

        return new JsonResponse(
            ['cash' => $data]
        );
    }
}
