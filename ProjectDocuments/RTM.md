# ksf_FA_CRM_Activity — Requirements Traceability Matrix

| Req ID | Requirement | Source | Implemented In | Verified By |
|--------|-------------|--------|----------------|-------------|
| CRM-008 | Activity automation chaining | HR-CRM_gaps.md CRM-008 | ActivityService | unit tests |
| FR-AC-01 | Create rule | CRM-008 | ActivityRepository::insertRule | ActivityDtoTest |
| FR-AC-02 | List rules | CRM-008 | ActivityService::listAll | (tab controller) |
| FR-AC-03 | Resolve rule by id | CRM-008 | ActivityService::resolveById | (capability hook) |
| FR-AC-04 | Update rule | CRM-008 | ActivityService::updateState | (service) |
| FR-AC-05 | RELATED_TO_FIELDS | CRM-008 | hooks.php RELATED_TO_FIELDS | (capability) |
| NF-AC-01 | Native db_* calls | AGENTS_ARCH | repository | code review |
| NF-AC-02 | PHP 7.3 compatible | AGENTS_ARCH | all src | code review |
| NF-AC-03 | Unit tests | AGENTS_ARCH | tests/Unit | phpunit |
