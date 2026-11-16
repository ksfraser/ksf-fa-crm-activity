# ksf_FA_CRM_Activity — Requirements

## Purpose
Manage activity automation chaining: activity triggers, actions and SuiteCRM-style activity chaining rules.

## Business Rules (CRM-008)
- An activity rule maps a trigger type + condition to an action type + config.
- Rules are active or inactive; only active rules fire.
- Trigger types: record_created, field_changed, stage_changed.
- Action types: send_email, create_task, update_field.

## Functional Requirements
- FR-AC-01: Create an activity rule.
- FR-AC-02: List all activity rules (summary table).
- FR-AC-03: Resolve a single rule by id (related-record linking).
- FR-AC-04: Update rule active flag and name.
- FR-AC-05: Expose activity rule fields via RELATED_TO_FIELDS.

## Non-Functional Requirements
- NF-AC-01: All database access uses native FA db_* calls.
- NF-AC-02: PHP 7.3 compatible runtime.
- NF-AC-03: Unit tests cover DTO round-trip and label resolution.
