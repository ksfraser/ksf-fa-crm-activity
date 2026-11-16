<?php

declare(strict_types=1);

namespace Ksfraser\FrontAccounting\CRM\Activity\App;

use ksfraser\FrontAccounting\Common\App\AbstractAppShell;
use ksfraser\FrontAccounting\Common\App\TabRegistration;

class ActivityAppShell extends AbstractAppShell
{
    public function __construct()
    {
        parent::__construct('activity', 'index.php', 'view', 'activity_rules');

        $this->registerTab(new TabRegistration(
            'activity_rules',
            'Activity Rules',
            'SA_ACTIVITY_VIEW',
            null,
            10,
            0,
            null,
            null,
            array()
        ));
    }
}
