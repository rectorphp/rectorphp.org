<?php

declare(strict_types=1);

namespace Rector\Website\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class BankDetailsController extends AbstractController
{
    #[Route(path: 'bank-details', name: \Rector\Website\ValueObject\Routing\RouteName::BANK_DETAILS)]
    public function __invoke(): Response
    {
        return $this->render('homepage/bank_details.twig');
    }
}
