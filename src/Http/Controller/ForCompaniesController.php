<?php

declare(strict_types=1);

namespace Rector\Website\Http\Controller;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

final class ForCompaniesController extends Controller
{
    public function __invoke(): View
    {
        return \view('homepage/hire_team', [
            'page_title' => 'We help you Reduce Costs and Erase Technical Debt',
        ]);
    }
}
