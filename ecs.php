<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([__DIR__ . '/src', __DIR__ . '/tests'])
    ->withRootFiles()
    ->withPreparedSets(psr12: true, common: true, symplify: true)
    ->withSkip([__DIR__ . '/config/bundles.php', '*/Fixture/*', '*/Expected/*']);
