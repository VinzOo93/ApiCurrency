<?php

namespace App\Controller;

use App\CashMachine\CashMachineRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{

    #[Route('/api', name: 'app_api')]
    public function index(CashMachineRegistry $registry): Response
    {
        $registry->get('EUR');

        return new JsonResponse(
            ['cash' => '500 euros']
        );
    }
}
