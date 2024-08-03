<?php

declare(strict_types=1);

namespace App\Validation\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

final class ShortPhpContentsRule implements ValidationRule
{
    use ShortPhpLinesTrait;

    /**
     * @var int
     */
    private const INPUT_LINES_LIMIT = 100;

    private function getInputLineLimit(): int
    {
        return self::INPUT_LINES_LIMIT;
    }
}
