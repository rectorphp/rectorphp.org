<?php

declare(strict_types=1);

namespace Rector\Website\Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class SupportPageCest
{
    public function showSupportPage(AcceptanceTester $I)
    {
        /** @see \Rector\Website\Controller\ForCompaniesController::__invoke */
        $I->amOnPage('/for-companies');

        // see text in for-companies page
        $I->see('Is your Project Successful, but Slowing Down?');
    }
}
