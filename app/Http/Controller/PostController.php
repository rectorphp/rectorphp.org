<?php

declare(strict_types=1);

namespace App\Http\Controller;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Rector\Website\Entity\Post;
use Rector\Website\Repository\PostRepository;
<<<<<<< HEAD
=======
use Symfony\Component\HttpFoundation\Response;
>>>>>>> 044a866 (shorter name)
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PostController extends Controller
{
    public function __construct(
        private readonly PostRepository $postRepository,
    ) {
    }

    public function __invoke(string $postSlug): View
    {
        $post = $this->postRepository->findBySlug($postSlug);
        if (! $post instanceof Post) {
            $message = sprintf("Post with slug '%s' not found", $postSlug);
            throw new NotFoundHttpException($message);
        }

        return \view('blog/post', [
            'post' => $post,
        ]);
    }
}
