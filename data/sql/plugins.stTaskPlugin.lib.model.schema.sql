
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_task
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_task`;


CREATE TABLE `st_task`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`is_active` INTEGER default 1,
	`task_id` VARCHAR(64),
	`task_priority` INTEGER default 0,
	`status` INTEGER default 0,
	`time_interval` INTEGER,
	`execute_at` TIME,
	`last_executed_at` DATETIME,
	`last_finished_at` DATETIME,
	`last_active_at` DATETIME,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_task_log
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_task_log`;


CREATE TABLE `st_task_log`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`task_id` INTEGER  NOT NULL,
	`type` INTEGER,
	`message` TEXT,
	PRIMARY KEY (`id`),
	INDEX `st_task_log_FI_1` (`task_id`),
	CONSTRAINT `st_task_log_FK_1`
		FOREIGN KEY (`task_id`)
		REFERENCES `st_task` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
