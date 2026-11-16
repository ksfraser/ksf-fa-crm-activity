<?php
declare(strict_types=1);
namespace Ksfraser\FrontAccounting\CRM\Activity\DTO;
final class ActivityDTO {
    public $rule_id;
    public $name;
    public $trigger_type;
    public $trigger_condition;
    public $action_type;
    public $action_config;
    public $is_active;
    public $created_at;
    public $updated_at;
    public function __construct(
        int $rule_id,
        string $name = '',
        string $trigger_type = '',
        string $trigger_condition = '',
        string $action_type = '',
        string $action_config = '',
        string $is_active = '1',
        string $created_at = '',
        string $updated_at = ''
    ) {
        $this->rule_id = $rule_id;
        $this->name = $name;
        $this->trigger_type = $trigger_type;
        $this->trigger_condition = $trigger_condition;
        $this->action_type = $action_type;
        $this->action_config = $action_config;
        $this->is_active = $is_active;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public function getDisplayLabel(): string {
        if ($this->name !== '') {
            return sprintf(_('%s [%s → %s]'), $this->name, $this->trigger_type, $this->action_type);
        }
        return _('Activity Rule #') . (string) $this->rule_id;
    }
    public function toArray(): array {
        return array(
            'rule_id' => $this->rule_id,
            'name' => $this->name,
            'trigger_type' => $this->trigger_type,
            'trigger_condition' => $this->trigger_condition,
            'action_type' => $this->action_type,
            'action_config' => $this->action_config,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        );
    }
    public static function fromArray(array $data): self {
        return new self(
            (int) ($data['rule_id'] ?? 0),
            (string) ($data['name'] ?? ''),
            (string) ($data['trigger_type'] ?? ''),
            (string) ($data['trigger_condition'] ?? ''),
            (string) ($data['action_type'] ?? ''),
            (string) ($data['action_config'] ?? ''),
            (string) ($data['is_active'] ?? '1'),
            (string) ($data['created_at'] ?? ''),
            (string) ($data['updated_at'] ?? '')
        );
    }
}
