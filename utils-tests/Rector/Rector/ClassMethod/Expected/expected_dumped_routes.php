<?php

declare(strict_types=1);

\Illuminate\Support\Facades\Route::get(
    '/some',
    \TomasVotruba\Utils\Tests\Rector\Rector\ClassMethod\Fixture\SomeController::class
)->name('some');
