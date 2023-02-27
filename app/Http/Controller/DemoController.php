<?php

declare(strict_types=1);

namespace App\Http\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use PackageVersions\Versions;
use Rector\Core\Application\VersionResolver;
use Rector\Website\Entity\RectorRun;
use Rector\Website\EntityFactory\RectorRunFactory;
use Rector\Website\Enum\FlashType;
use Rector\Website\Enum\RouteName;
use Rector\Website\Repository\RectorRunRepository;
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
            // rector metadata
            'rector_version' => $this->resolveRectorReleaseVersion(),
            'rector_commit_hash' => $this->resolveRectorCommitHash(),
            'rector_released_time' => $this->resolveRectorReleaseDate(),
        ]);
    }

    private function resolveRectorReleaseVersion(): string
    {
        $rectorVersion = Versions::getVersion('rector/rector');
        $extractAt = explode('@', $rectorVersion);

        return $extractAt[0] . '@' . substr($extractAt[1], 0, 6);
    }

    private function resolveRectorReleaseDate(): string
    {
        return substr(VersionResolver::RELEASE_DATE, 0, strlen(VersionResolver::RELEASE_DATE) - 3);
    }

    private function resolveRectorCommitHash(): string
    {
        return str($this->resolveRectorReleaseVersion())
            ->after('@')
            ->value();
    }
}
