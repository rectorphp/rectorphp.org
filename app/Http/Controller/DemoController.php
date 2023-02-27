<?php

declare(strict_types=1);

namespace App\Http\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Rector\Website\EntityFactory\RectorRunFactory;
use Rector\Website\Utils\RectorVersionMetadata;

/**
 * @see \Rector\Website\Tests\Controller\DemoControllerTest
 */
final class DemoController extends Controller
{
    public function __construct(
        private readonly RectorRunFactory $rectorRunFactory,
    ) {
    }

    public function __invoke(): View|RedirectResponse
    {
        return \view('demo/demo', [
            'page_title' => 'Try Rector Online',
            'rector_run' => $this->rectorRunFactory->createEmpty(),
            'rector_version_metadata' => new RectorVersionMetadata(),
        ]);
    }
}
