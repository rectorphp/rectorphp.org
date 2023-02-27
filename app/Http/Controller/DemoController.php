<?php

declare(strict_types=1);

namespace App\Http\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Rector\Website\Entity\RectorRun;
use Rector\Website\EntityFactory\RectorRunFactory;
use Rector\Website\Enum\FlashType;
use Rector\Website\Enum\RouteName;
use Rector\Website\Repository\RectorRunRepository;
use Rector\Website\Utils\RectorVersionMetadata;
use Symfony\Component\Uid\Uuid;

/**
 * @see \Rector\Website\Tests\Controller\DemoControllerTest
 */
final class DemoController extends Controller
{
    public function __construct(
        private readonly RectorRunRepository $rectorRunRepository,
        private readonly RectorRunFactory $rectorRunFactory,
    ) {
    }

    // @todo possibly split :)
    public function __invoke(?string $uuid = null): View|RedirectResponse
    {
        if ($uuid === null || ! Uuid::isValid($uuid)) {
            $rectorRun = $this->rectorRunFactory->createEmpty();
        } else {
            $rectorRun = $this->rectorRunRepository->get(Uuid::fromString($uuid));
            if (! $rectorRun instanceof RectorRun) {
                // item not found
                $errorMessage = sprintf('Rector run "%s" was not found. Try to run code again for new result', $uuid);
                session()
                    ->flash(FlashType::ERROR, $errorMessage);

                return to_route(RouteName::DEMO);
            }
        }

        return \view('demo/demo', [
            'page_title' => 'Try Rector Online',
            'rector_run' => $rectorRun,
            'rector_version_metadata' => new RectorVersionMetadata(),
        ]);
    }
}
