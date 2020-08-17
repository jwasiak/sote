
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_questions
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_questions`;


CREATE TABLE `st_questions`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`item_id` INTEGER,
	`question_status_id` INTEGER  NOT NULL,
	`email` VARCHAR(255),
	`type` VARCHAR(20),
	`item_name` VARCHAR(255),
	`text` TEXT,
	`answer_text` TEXT,
	PRIMARY KEY (`id`),
	INDEX `st_questions_FI_1` (`item_id`),
	CONSTRAINT `st_questions_FK_1`
		FOREIGN KEY (`item_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE SET NULL,
	INDEX `st_questions_FI_2` (`question_status_id`),
	CONSTRAINT `st_questions_FK_2`
		FOREIGN KEY (`question_status_id`)
		REFERENCES `st_question_status` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_question_status
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_question_status`;


CREATE TABLE `st_question_status`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`opt_name` VARCHAR(255),
	`status_type` VARCHAR(255),
	`is_default` INTEGER,
	`is_system_default` INTEGER,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_question_status_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_question_status_i18n`;


CREATE TABLE `st_question_status_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_question_status_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_question_status` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
