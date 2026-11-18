<?php
declare(strict_types=1);
require_once __DIR__ . '/ComposerDependencies.php';
\Ksfraser\FrontAccounting\CRM\Activity\Utils\ComposerDependencies::ensure(__DIR__);
$autoload_path = dirname(__FILE__) . '/vendor/autoload.php';
if (file_exists($autoload_path)) { require_once $autoload_path; }
require_once __DIR__ . '/includes/common.inc';
require_once __DIR__ . '/includes/events.inc';
use ksfraser\RelatedTo\DTO\RelatedRecordDto;
define('SS_ksf_FA_CRM_Activity', 200 << 8);
if (!defined('SA_CRM_ACTIVITY_VIEW')) {
    define('SA_CRM_ACTIVITY_VIEW', SS_ksf_FA_CRM_Activity | 1);
    define('SA_CRM_ACTIVITY_MANAGE', SS_ksf_FA_CRM_Activity | 2);
    define('SA_CRM_ACTIVITY_ADMIN', SS_ksf_FA_CRM_Activity | 3);
}
class hooks_ksf_FA_CRM_Activity extends hooks {
    const RESPONDERS = array('RELATED_TO_FIELDS', 'ACTIVITY_RESOLVE', 'ACTIVITY_FIELDS', 'ACTIVITY_LIST');
    var $module_name = 'ksf_FA_CRM_Activity';
    var $version = '1.0.0';
    function install_tabs($app) { }
    function install_options($app) { }
    function install_access() {
        $security_sections[SS_ksf_FA_CRM_Activity] = _("Activity Automation");
        $security_areas['SA_CRM_ACTIVITY_VIEW'] = array(SA_CRM_ACTIVITY_VIEW, _("View activity rules"));
        $security_areas['SA_CRM_ACTIVITY_MANAGE'] = array(SA_CRM_ACTIVITY_MANAGE, _("Manage activity rules"));
        $security_areas['SA_CRM_ACTIVITY_ADMIN'] = array(SA_CRM_ACTIVITY_ADMIN, _("Administer activity automation"));
        return array($security_areas, $security_sections);
    }
    function activate_extension($company, $check_only = true) {
        if ($check_only) { return true; }
        \Ksfraser\FrontAccounting\CRM\Activity\Utils\ComposerDependencies::ensure(__DIR__);
        $this->update_databases($company, array(
            '0_ksf_crm_activity_rules.sql' => array('ksf_crm_activity_rules'),
        ), false);
        return true;
    }
    private function ensure_composer_dependencies() {
        \Ksfraser\FrontAccounting\CRM\Activity\Utils\ComposerDependencies::ensure(__DIR__);
    }
    public function getModuleConstants(&$data, $opts = null) {
        $data['constants'] = array(
            'SS_ksf_FA_CRM_Activity' => SS_ksf_FA_CRM_Activity,
            'SA_CRM_ACTIVITY_VIEW' => SA_CRM_ACTIVITY_VIEW,
            'SA_CRM_ACTIVITY_MANAGE' => SA_CRM_ACTIVITY_MANAGE,
            'SA_CRM_ACTIVITY_ADMIN' => SA_CRM_ACTIVITY_ADMIN,
        );
        return true;
    }
    public function getModuleCapabilities(&$data, $opts = null) {
        $data['capabilities'] = self::RESPONDERS;
        return true;
    }
    public function hasCapability(&$data, $opts) {
        $capability = is_array($opts) && isset($opts['capability']) ? $opts['capability'] : null;
        if ($capability === null && isset($data['capability'])) { $capability = $data['capability']; }
        $data['has_capability'] = in_array($capability, self::RESPONDERS, true);
        return $data['has_capability'];
    }
    public function respondToCapabilityRequest(&$data, $opts = null) {
        $request = is_array($opts) && isset($opts['request']) ? $opts['request'] : (isset($data['request']) ? $data['request'] : 'capabilities');
        $data['request'] = $request;
        $data['module'] = $this->module_name;
        if (strpos($request, 'has:') === 0) { return $this->hasCapability($data, array('capability' => substr($request, 4))); }
        switch ($request) {
            case 'capabilities': return $this->getModuleCapabilities($data, $opts);
            case 'constants': return $this->getModuleConstants($data, $opts);
            default: $data['error'] = 'Unknown request type: ' . $request; return null;
        }
    }
    public function RELATED_TO_FIELDS(&$data, $opts = null) {
        if (!isset($data['module']) || !is_string($data['module'])) { $data['error'] = 'RELATED_TO_FIELDS requires data[module]'; return null; }
        if (!isset($data['type']) || !is_string($data['type'])) { $data['error'] = 'RELATED_TO_FIELDS requires data[type]'; return null; }
        if ($data['type'] !== 'ksf_crm_activity_rule') { return null; }
        if (!isset($data['fields']) || !is_array($data['fields'])) { $data['fields'] = array(); }
        $data['fields'] = array_merge($data['fields'], array(
            'rule_id' => _('Rule ID'),
            'name' => _('Rule Name'),
            'trigger_type' => _('Trigger Type'),
            'action_type' => _('Action Type'),
            'is_active' => _('Active'),
        ));
        return null;
    }
    public function ACTIVITY_RESOLVE(&$data, $opts = null) {
        if (!isset($data['rule_id']) || !is_numeric($data['rule_id'])) { $data['error'] = 'ACTIVITY_RESOLVE requires data[rule_id]'; return null; }
        if (!isset($data['dto']) || !$data['dto'] instanceof RelatedRecordDto) { $data['error'] = 'ACTIVITY_RESOLVE requires data[dto] as RelatedRecordDto'; return null; }
        $service = new \Ksfraser\FrontAccounting\CRM\Activity\Service\ActivityService();
        $data['result'] = $service->resolveById((int) $data['rule_id'], $data['dto']);
        return null;
    }
    public function ACTIVITY_FIELDS(&$data, $opts = null) {
        $data['fields'] = array(
            'rule_id' => _('Rule ID'),
            'name' => _('Rule Name'),
            'trigger_type' => _('Trigger Type'),
            'action_type' => _('Action Type'),
            'is_active' => _('Active'),
        );
        return null;
    }
    public function ACTIVITY_LIST(&$data, $opts = null) {
        $service = new \Ksfraser\FrontAccounting\CRM\Activity\Service\ActivityService();
        $data['result'] = $service->listAll();
        return null;
    }
}
