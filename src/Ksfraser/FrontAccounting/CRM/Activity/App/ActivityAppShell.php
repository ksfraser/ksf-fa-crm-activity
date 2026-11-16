<?php

declare(strict_types=1);

namespace Ksfraser\FrontAccounting\CRM\Activity\App;

use ksfraser\FrontAccounting\Common\App\AbstractAppShell;
use ksfraser\FrontAccounting\Common\Menu\FAModuleMenu;
use Ksfraser\FrontAccounting\CRM\Activity\Controller\ActivityTabController;

class ActivityAppShell extends AbstractAppShell
{
    public function __construct()
    {
        parent::__construct('activity', 'index.php', 'view', 'activity_rules');

        $this->add_module(_("Activity Automation"));

        $menu = new FAModuleMenu(
            'modules/ksf_FA_CRM_Activity/index.php',
            'view',
            ''
        );

        $menu->addItem('activity_rules', _("Activity Rules"), MENU_INQUIRY)
             ->registerWithApp($this, 'SA_ACTIVITY_VIEW');

        $this->add_extensions();
    }
}
