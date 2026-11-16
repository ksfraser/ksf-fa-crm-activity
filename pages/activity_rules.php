<?php
declare(strict_types=1);

use Ksfraser\FrontAccounting\CRM\Activity\Controller\ActivityTabController;

$path_to_root = '../..';

require_once($path_to_root . '/includes/session.inc');

if (!function_exists('page_security')) {
    define('page_security', 'SA_ACTIVITY_VIEW');
}

$controller = new ActivityTabController(null, array());
$controller->render();
