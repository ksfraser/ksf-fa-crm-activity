-- ksf_FA_CRM_Activity: activity automation rule tables

CREATE TABLE IF NOT EXISTS `0_ksf_crm_activity_rules` (
  `rule_id`         INT(11) NOT NULL AUTO_INCREMENT,
  `name`            VARCHAR(255) NOT NULL,
  `trigger_type`    VARCHAR(64) NOT NULL COMMENT 'e.g. record_created, field_changed, stage_changed',
  `trigger_condition` TEXT DEFAULT NULL COMMENT 'JSON condition expression',
  `action_type`     VARCHAR(64) NOT NULL COMMENT 'e.g. send_email, create_task, update_field',
  `action_config`   TEXT DEFAULT NULL COMMENT 'JSON action configuration',
  `is_active`       TINYINT(1) NOT NULL DEFAULT 1,
  `created_at`      DATETIME NOT NULL,
  `updated_at`      DATETIME NOT NULL,
  PRIMARY KEY (`rule_id`),
  KEY `idx_trigger` (`trigger_type`),
  KEY `idx_action` (`action_type`),
  KEY `idx_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
