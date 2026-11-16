<?php

declare(strict_types=1);

namespace Ksfraser\FrontAccounting\CRM\Activity\App;

use ksfraser\FrontAccounting\Common\App\AbstractFrontController;

class ActivityFrontController extends AbstractFrontController
{
    public function __construct(
        ActivityAppShell $appShell,
        string $fallbackSecurityArea,
        string $path_to_root
    ) {
        parent::__construct($appShell, $fallbackSecurityArea, $path_to_root);
    }
}
