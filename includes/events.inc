<?php
declare(strict_types=1);

if (!function_exists('hook_invoke_all')) {
    return;
}

function activity_rule_state_changed($ruleId, $fromState, $toState, $meta = array()) {
    hook_invoke_all('ACTIVITY_STATE_CHANGED', array(
        'rule_id' => $ruleId,
        'from_state' => $fromState,
        'to_state' => $toState,
        'meta' => $meta,
    ));
}
