<?php

declare(strict_types=1);

// @see https://github.com/thephpleague/commonmark

use App\Enum\FlashType;
use Illuminate\Http\RedirectResponse;
use League\CommonMark\GithubFlavoredMarkdownConverter;

<<<<<<< HEAD
function latestPhp(): string
{
    return '8.3';
}

=======
>>>>>>> d45f16c1 (allow to use multiple nodes in node filter to ease)
function slugify(string $value): string
{
    return str($value)->slug()
        ->value();
}

function markdown(string $contents): Stringable
{
    $markdownConverter = new GithubFlavoredMarkdownConverter([
        'allow_unsafe_links' => false,
    ]);

    return $markdownConverter->convert($contents);
}

function redirect_with_error(string $controller, string $errorMessage): RedirectResponse
{
    session()->flash(FlashType::ERROR, $errorMessage);

    return redirect()->action($controller);
}
