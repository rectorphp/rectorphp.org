<?php

declare(strict_types=1);

namespace Rector\Website\Demo\Repository;

use Rector\Website\Demo\Entity\RectorRun;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Uid\Uuid;

final class RectorRunRepository
{
<<<<<<< HEAD
=======
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

>>>>>>> enable parallel on PHP 8.1
    public function save(RectorRun $rectorRun): void
    {
        // @todo save
    }

    public function get(Uuid $uuid): never
    {
        // @todo fetch
        throw new NotFoundHttpException();
    }
}
