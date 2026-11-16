<?php
declare(strict_types=1);
namespace Ksfraser\FrontAccounting\CRM\Activity\Service;
use Ksfraser\FrontAccounting\CRM\Activity\DTO\ActivityDTO;
use Ksfraser\FrontAccounting\CRM\Activity\Repository\ActivityRepository;
use ksfraser\RelatedTo\DTO\RelatedRecordDto;
final class ActivityService {
    private $repo;
    public function __construct(?ActivityRepository $repo = null) { $this->repo = $repo ?? new ActivityRepository(); }
    public function resolveById(int $id, ?RelatedRecordDto $dto = null): array {
        $row = $this->repo->findById($id);
        if ($row === null) {
            return array('dto' => new RelatedRecordDto('ksf_crm_activity_rule', '0', 'ksf_crm_activity_rule', '0', null), 'fields' => $this->fieldMap(), 'labels' => $this->labelMap(), 'url' => '#', 'label' => _('Activity Rule #') . (string) $id);
        }
        $r = ActivityDTO::fromArray($row);
        $dto = $dto ?? new RelatedRecordDto('ksf_crm_activity_rule', (string) $r->rule_id, 'ksf_crm_activity_rule', (string) $r->rule_id, null);
        return array(
            'dto' => $dto,
            'fields' => array(
                'rule_id' => (string) $r->rule_id,
                'name' => $r->name,
                'trigger_type' => $r->trigger_type,
                'action_type' => $r->action_type,
                'is_active' => $r->is_active,
            ),
            'labels' => $this->labelMap(),
            'url' => '/modules/ksf_FA_CRM_Activity/pages/activity_rule_form.php?action=edit&rule_id=' . $r->rule_id,
            'label' => $r->getDisplayLabel(),
        );
    }
    public function listAll(): array {
        $rows = $this->repo->findAll();
        $results = array();
        foreach ($rows as $row) {
            $r = ActivityDTO::fromArray($row);
            $results[] = array(
                'id' => $r->rule_id,
                'dto' => new RelatedRecordDto('ksf_crm_activity_rule', (string) $r->rule_id, 'ksf_crm_activity_rule', (string) $r->rule_id, null),
                'fields' => array(
                    'rule_id' => (string) $r->rule_id,
                    'name' => $r->name,
                    'trigger_type' => $r->trigger_type,
                    'action_type' => $r->action_type,
                    'is_active' => $r->is_active,
                ),
                'labels' => $this->labelMap(),
                'url' => '/modules/ksf_FA_CRM_Activity/pages/activity_rule_form.php?action=edit&rule_id=' . $r->rule_id,
                'label' => $r->getDisplayLabel(),
            );
        }
        return $results;
    }
    public function insertRule(array $data): int {
        return $this->repo->insertRule($data);
    }
    public function updateState(int $ruleId, string $isActive, string $name = null): void {
        $this->repo->updateState($ruleId, $isActive, $name);
        activity_rule_state_changed((string) $ruleId, '', 'updated', array('is_active' => $isActive));
    }
    public function fieldMap(): array { return $this->labelMap(); }
    public function labelMap(): array {
        return array(
            'rule_id' => _('Rule ID'),
            'name' => _('Rule Name'),
            'trigger_type' => _('Trigger Type'),
            'action_type' => _('Action Type'),
            'is_active' => _('Active'),
        );
    }
    public function getStateTransitions(string $currentState): array {
        return array();
    }
    public function isAllowedTransition(string $fromState, string $toState): bool {
        return false;
    }
}
