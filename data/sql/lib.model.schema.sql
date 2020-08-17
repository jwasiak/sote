
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- st_dashboard
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_dashboard`;


CREATE TABLE `st_dashboard`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`updated_at` INTEGER default 0 NOT NULL,
	`label` VARCHAR(32)  NOT NULL,
	`layout` VARCHAR(48)  NOT NULL,
	`is_default` INTEGER default 0 NOT NULL,
	`sf_guard_user_id` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `st_dashboard_FI_1` (`sf_guard_user_id`),
	CONSTRAINT `st_dashboard_FK_1`
		FOREIGN KEY (`sf_guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_dashboard_gadget
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_dashboard_gadget`;


CREATE TABLE `st_dashboard_gadget`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`dashboard_id` INTEGER  NOT NULL,
	`refreshed_at` INTEGER default 0 NOT NULL,
	`refresh_by` INTEGER default 0 NOT NULL,
	`dashboard_column_no` INTEGER  NOT NULL,
	`position` INTEGER default 1 NOT NULL,
	`color` VARCHAR(7),
	`is_minimized` INTEGER default 0 NOT NULL,
	`title` VARCHAR(64)  NOT NULL,
	`name` VARCHAR(48)  NOT NULL,
	PRIMARY KEY (`id`,`dashboard_id`),
	KEY `dashboard_column_position_idx`(`dashboard_id`, `dashboard_column_no`, `position`),
	CONSTRAINT `st_dashboard_gadget_FK_1`
		FOREIGN KEY (`dashboard_id`)
		REFERENCES `st_dashboard` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_dashboard_gadget_configuration
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_dashboard_gadget_configuration`;


CREATE TABLE `st_dashboard_gadget_configuration`
(
	`id` INTEGER  NOT NULL,
	`configuration` TEXT,
	PRIMARY KEY (`id`),
	CONSTRAINT `st_dashboard_gadget_configuration_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_dashboard_gadget` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_smarty_slot
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_smarty_slot`;


CREATE TABLE `st_smarty_slot`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(48)  NOT NULL,
	`theme_id` INTEGER,
	PRIMARY KEY (`id`),
	UNIQUE KEY `name_idx` (`name`, `theme_id`),
	INDEX `st_smarty_slot_FI_1` (`theme_id`),
	CONSTRAINT `st_smarty_slot_FK_1`
		FOREIGN KEY (`theme_id`)
		REFERENCES `st_theme` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_smarty_slot_content
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_smarty_slot_content`;


CREATE TABLE `st_smarty_slot_content`
(
	`id` INTEGER  NOT NULL,
	`slot_id` INTEGER  NOT NULL,
	`is_active` INTEGER default 1 NOT NULL,
	`hash` VARCHAR(128)  NOT NULL,
	`content` TEXT  NOT NULL,
	PRIMARY KEY (`id`,`slot_id`),
	KEY `hash_idx`(`hash`),
	INDEX `st_smarty_slot_content_FI_1` (`slot_id`),
	CONSTRAINT `st_smarty_slot_content_FK_1`
		FOREIGN KEY (`slot_id`)
		REFERENCES `st_smarty_slot` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_smarty_content_block
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_smarty_content_block`;


CREATE TABLE `st_smarty_content_block`
(
	`name` VARCHAR(48)  NOT NULL,
	`opt_culture` VARCHAR(5)  NOT NULL,
	`type` VARCHAR(6)  NOT NULL,
	`content` TEXT,
	PRIMARY KEY (`name`,`opt_culture`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_user_points
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_user_points`;


CREATE TABLE `st_user_points`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`sf_guard_user_id` INTEGER  NOT NULL,
	`points` INTEGER default 0,
	`change_points` INTEGER default 0,
	`change_points_varchar` VARCHAR(10),
	`description` VARCHAR(255),
	`order_id` INTEGER,
	`order_number` VARCHAR(255),
	`order_hash` VARCHAR(255),
	`admin_id` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `st_user_points_FI_1` (`sf_guard_user_id`),
	CONSTRAINT `st_user_points_FK_1`
		FOREIGN KEY (`sf_guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_user_points_FI_2` (`order_id`),
	CONSTRAINT `st_user_points_FK_2`
		FOREIGN KEY (`order_id`)
		REFERENCES `st_order` (`id`)
		ON DELETE CASCADE,
	INDEX `st_user_points_FI_3` (`admin_id`),
	CONSTRAINT `st_user_points_FK_3`
		FOREIGN KEY (`admin_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_payment
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_payment`;


CREATE TABLE `st_payment`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`sf_guard_user_id` INTEGER,
	`payment_type_id` INTEGER,
	`amount` DECIMAL(10,2),
	`status` INTEGER default 0 NOT NULL,
	`in_progress` INTEGER default 0 NOT NULL,
	`cancel` INTEGER default 0 NOT NULL,
	`transaction_id` VARCHAR(36),
	`hash` CHAR(32),
	`payment_security_hash` CHAR(40),
	`payed_at` DATETIME,
	`version` INTEGER,
	`configuration` VARCHAR(1024),
	`allegro_payment_type` VARCHAR(24),
	`gift_card_id` INTEGER,
	PRIMARY KEY (`id`),
	KEY `transaction_id_idx`(`transaction_id`),
	INDEX `st_payment_FI_1` (`sf_guard_user_id`),
	CONSTRAINT `st_payment_FK_1`
		FOREIGN KEY (`sf_guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_payment_FI_2` (`payment_type_id`),
	CONSTRAINT `st_payment_FK_2`
		FOREIGN KEY (`payment_type_id`)
		REFERENCES `st_payment_type` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_payment_FI_3` (`gift_card_id`),
	CONSTRAINT `st_payment_FK_3`
		FOREIGN KEY (`gift_card_id`)
		REFERENCES `st_gift_card` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_payment_type
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_payment_type`;


CREATE TABLE `st_payment_type`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`module_name` VARCHAR(32),
	`hide_module` INTEGER default 0 NOT NULL,
	`hide_for_configuration` INTEGER default 0 NOT NULL,
	`hide_for_wholesale` INTEGER default 0 NOT NULL,
	`active` INTEGER default 1 NOT NULL,
	`image` VARCHAR(255),
	`configuration` VARCHAR(1024),
	`opt_name` VARCHAR(128)  NOT NULL,
	`opt_description` TEXT,
	`opt_summary_description` TEXT,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_order_has_payment
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_order_has_payment`;


CREATE TABLE `st_order_has_payment`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`order_id` INTEGER  NOT NULL,
	`payment_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `st_order_has_payment_FI_1` (`order_id`),
	CONSTRAINT `st_order_has_payment_FK_1`
		FOREIGN KEY (`order_id`)
		REFERENCES `st_order` (`id`)
		ON DELETE CASCADE,
	INDEX `st_order_has_payment_FI_2` (`payment_id`),
	CONSTRAINT `st_order_has_payment_FK_2`
		FOREIGN KEY (`payment_id`)
		REFERENCES `st_payment` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_payment_type_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_payment_type_i18n`;


CREATE TABLE `st_payment_type_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255)  NOT NULL,
	`description` TEXT,
	`summary_description` TEXT,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_payment_type_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_payment_type` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_category`;


CREATE TABLE `st_category`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`opt_image` VARCHAR(255),
	`lft` INTEGER,
	`rgt` INTEGER,
	`scope` INTEGER,
	`main_page` INTEGER,
	`parent_id` INTEGER,
	`sf_asset_id` INTEGER,
	`opt_name` VARCHAR(255),
	`opt_description` TEXT,
	`opt_image_crop` VARCHAR(450),
	`depth` INTEGER default 0 NOT NULL,
	`root_position` INTEGER,
	`is_active` INTEGER default 1 NOT NULL,
	`is_hidden` INTEGER default 0 NOT NULL,
	`show_children_products` INTEGER default 0 NOT NULL,
	`opt_url` VARCHAR(255),
	`is_app_image_tag_active` INTEGER default 1,
	PRIMARY KEY (`id`),
	KEY `category_Index1`(`depth`),
	KEY `category_Index2`(`lft`, `scope`),
	KEY `scope_idx`(`scope`),
	INDEX `st_category_FI_1` (`parent_id`),
	CONSTRAINT `st_category_FK_1`
		FOREIGN KEY (`parent_id`)
		REFERENCES `st_category` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_category_FI_2` (`sf_asset_id`),
	CONSTRAINT `st_category_FK_2`
		FOREIGN KEY (`sf_asset_id`)
		REFERENCES `sf_asset` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_category_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_category_i18n`;


CREATE TABLE `st_category_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	`url` VARCHAR(255),
	`description` TEXT,
	PRIMARY KEY (`id`,`culture`),
	KEY `category_Index1`(`url`, `culture`),
	CONSTRAINT `st_category_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_category` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product`;


CREATE TABLE `st_product`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`parent_id` INTEGER,
	`currency_id` INTEGER,
	`producer_id` INTEGER,
	`code` VARCHAR(255)  NOT NULL,
	`price` DECIMAL(10,2)  NOT NULL,
	`opt_price_brutto` DECIMAL(10,2)  NOT NULL,
	`delivery_price` DECIMAL(10,2),
	`bpum_default_id` INTEGER,
	`bpum_default_value` DECIMAL(10,2),
	`bpum_id` INTEGER,
	`bpum_value` DECIMAL(10,2),
	`currency_price` DECIMAL(10,2),
	`old_price` DECIMAL(10,2),
	`opt_old_price_brutto` DECIMAL(10,2),
	`points_value` INTEGER default 0,
	`points_earn` INTEGER default 0,
	`points_only` INTEGER default 0,
	`currency_old_price` DECIMAL(10,2),
	`opt_vat` DECIMAL(5,2),
	`currency_exchange` DECIMAL(6,4) default 1,
	`active` INTEGER default 1,
	`hide_price` TINYINT default null,
	`has_fixed_currency` INTEGER default 0,
	`opt_image` VARCHAR(255),
	`opt_name` VARCHAR(255),
	`opt_short_description` TEXT,
	`opt_description` MEDIUMTEXT,
	`opt_url` VARCHAR(255),
	`opt_asset_folder` VARCHAR(32),
	`opt_uom` VARCHAR(10),
	`deliveries` VARCHAR(1024),
	`min_qty` DECIMAL(8,2) default 1,
	`max_qty` DECIMAL(8,2) default 0,
	`step_qty` DECIMAL(8,2) default 0,
	`is_stock_validated` INTEGER,
	`is_gift` INTEGER default 0 NOT NULL,
	`is_service` INTEGER default 0 NOT NULL,
	`stock_in_decimals` TINYINT default 0,
	`man_code` VARCHAR(20),
	`main_page_order` INTEGER default 0,
	`priority` INTEGER default 0,
	`stock_managment` TINYINT default 0,
	`dimension_id` INTEGER,
	`width` FLOAT default 0 NOT NULL,
	`height` FLOAT default 0 NOT NULL,
	`depth` FLOAT default 0 NOT NULL,
	`opt_product_group` TEXT,
	`opt_execution_time` VARCHAR(64),
	`availability_id` INTEGER,
	`weight` FLOAT,
	`stock` DECIMAL(8,2) default 1,
	`max_discount` DOUBLE default 100,
	`mpn_code` VARCHAR(255),
	`group_price_id` INTEGER,
	`opt_has_options` INTEGER,
	`options_color` TEXT,
	`tax_id` INTEGER,
	`wholesale_a_netto` DECIMAL(10,2) default 0 NOT NULL,
	`wholesale_b_netto` DECIMAL(10,2) default 0 NOT NULL,
	`wholesale_c_netto` DECIMAL(10,2) default 0 NOT NULL,
	`wholesale_a_brutto` DECIMAL(10,2) default 0 NOT NULL,
	`wholesale_b_brutto` DECIMAL(10,2) default 0 NOT NULL,
	`wholesale_c_brutto` DECIMAL(10,2) default 0 NOT NULL,
	`currency_wholesale_a` DECIMAL(10,2),
	`currency_wholesale_b` DECIMAL(10,2),
	`currency_wholesale_c` DECIMAL(10,2),
	PRIMARY KEY (`id`),
	UNIQUE KEY `product_code` (`code`),
	KEY `bpum_default_idx`(`bpum_default_id`),
	KEY `bpum_idx`(`bpum_id`),
	KEY `dimension_idx`(`dimension_id`),
	KEY `product_fk_currency_id`(`currency_id`),
	KEY `parent_id_Index`(`parent_id`),
	KEY `group_price_idx`(`group_price_id`),
	CONSTRAINT `st_product_FK_1`
		FOREIGN KEY (`parent_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE SET NULL,
	CONSTRAINT `st_product_FK_2`
		FOREIGN KEY (`currency_id`)
		REFERENCES `st_currency` (`id`)
		ON DELETE SET NULL,
	INDEX `st_product_FI_3` (`producer_id`),
	CONSTRAINT `st_product_FK_3`
		FOREIGN KEY (`producer_id`)
		REFERENCES `st_producer` (`id`)
		ON DELETE SET NULL,
	CONSTRAINT `st_product_FK_4`
		FOREIGN KEY (`bpum_default_id`)
		REFERENCES `st_basic_price_unit_measure` (`id`)
		ON DELETE SET NULL,
	CONSTRAINT `st_product_FK_5`
		FOREIGN KEY (`bpum_id`)
		REFERENCES `st_basic_price_unit_measure` (`id`)
		ON DELETE SET NULL,
	CONSTRAINT `st_product_FK_6`
		FOREIGN KEY (`dimension_id`)
		REFERENCES `st_product_dimension` (`id`)
		ON DELETE SET NULL,
	INDEX `st_product_FI_7` (`availability_id`),
	CONSTRAINT `st_product_FK_7`
		FOREIGN KEY (`availability_id`)
		REFERENCES `st_availability` (`id`)
		ON DELETE SET NULL,
	CONSTRAINT `st_product_FK_8`
		FOREIGN KEY (`group_price_id`)
		REFERENCES `st_group_price` (`id`)
		ON DELETE SET NULL,
	INDEX `st_product_FI_9` (`tax_id`),
	CONSTRAINT `st_product_FK_9`
		FOREIGN KEY (`tax_id`)
		REFERENCES `st_tax` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_has_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_has_category`;


CREATE TABLE `st_product_has_category`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`category_id` INTEGER  NOT NULL,
	`product_id` INTEGER  NOT NULL,
	`is_default` INTEGER default 0,
	PRIMARY KEY (`id`),
	INDEX `st_product_has_category_FI_1` (`category_id`),
	CONSTRAINT `st_product_has_category_FK_1`
		FOREIGN KEY (`category_id`)
		REFERENCES `st_category` (`id`)
		ON DELETE CASCADE,
	INDEX `st_product_has_category_FI_2` (`product_id`),
	CONSTRAINT `st_product_has_category_FK_2`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_has_sf_asset
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_has_sf_asset`;


CREATE TABLE `st_product_has_sf_asset`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`sf_asset_id` INTEGER  NOT NULL,
	`product_id` INTEGER  NOT NULL,
	`is_default` INTEGER default 0,
	PRIMARY KEY (`id`),
	INDEX `st_product_has_sf_asset_FI_1` (`sf_asset_id`),
	CONSTRAINT `st_product_has_sf_asset_FK_1`
		FOREIGN KEY (`sf_asset_id`)
		REFERENCES `sf_asset` (`id`)
		ON DELETE CASCADE,
	INDEX `st_product_has_sf_asset_FI_2` (`product_id`),
	CONSTRAINT `st_product_has_sf_asset_FK_2`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_has_attachment
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_has_attachment`;


CREATE TABLE `st_product_has_attachment`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`language_id` INTEGER  NOT NULL,
	`sf_asset_id` INTEGER  NOT NULL,
	`product_id` INTEGER  NOT NULL,
	`is_active` INTEGER default 1,
	`opt_culture` VARCHAR(7),
	PRIMARY KEY (`id`),
	INDEX `st_product_has_attachment_FI_1` (`language_id`),
	CONSTRAINT `st_product_has_attachment_FK_1`
		FOREIGN KEY (`language_id`)
		REFERENCES `st_language` (`id`)
		ON DELETE SET NULL,
	INDEX `st_product_has_attachment_FI_2` (`sf_asset_id`),
	CONSTRAINT `st_product_has_attachment_FK_2`
		FOREIGN KEY (`sf_asset_id`)
		REFERENCES `sf_asset` (`id`)
		ON DELETE CASCADE,
	INDEX `st_product_has_attachment_FI_3` (`product_id`),
	CONSTRAINT `st_product_has_attachment_FK_3`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_has_recommend
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_has_recommend`;


CREATE TABLE `st_product_has_recommend`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`recommend_id` INTEGER  NOT NULL,
	`product_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`,`recommend_id`,`product_id`),
	INDEX `st_product_has_recommend_FI_1` (`recommend_id`),
	CONSTRAINT `st_product_has_recommend_FK_1`
		FOREIGN KEY (`recommend_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_product_has_recommend_FI_2` (`product_id`),
	CONSTRAINT `st_product_has_recommend_FK_2`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_dimension
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_dimension`;


CREATE TABLE `st_product_dimension`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(64),
	`width` FLOAT default 0 NOT NULL,
	`height` FLOAT default 0 NOT NULL,
	`depth` FLOAT default 0 NOT NULL,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_i18n`;


CREATE TABLE `st_product_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	`short_description` TEXT,
	`description` MEDIUMTEXT,
	`search_keywords` TEXT,
	`url` VARCHAR(255),
	`uom` VARCHAR(10),
	`execution_time` VARCHAR(64),
	`description2` MEDIUMTEXT,
	`attributes_label` VARCHAR(48),
	PRIMARY KEY (`id`,`culture`),
	KEY `product_Index1`(`url`, `culture`),
	CONSTRAINT `st_product_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_order
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_order`;


CREATE TABLE `st_order`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`order_delivery_id` INTEGER,
	`sf_guard_user_id` INTEGER,
	`order_user_data_delivery_id` INTEGER,
	`order_user_data_billing_id` INTEGER,
	`order_currency_id` INTEGER  NOT NULL,
	`order_status_id` INTEGER  NOT NULL,
	`discount_coupon_code_id` INTEGER,
	`discount_id` INTEGER,
	`order_discount` VARCHAR(255),
	`hash_code` CHAR(32),
	`payment_security_hash` CHAR(40),
	`session_hash` CHAR(32),
	`is_confirmed` INTEGER default 0,
	`is_marked_as_read` INTEGER default 1,
	`number` VARCHAR(64),
	`description` TEXT,
	`order_type` VARCHAR(20),
	`merchant_notes` TEXT,
	`client_culture` VARCHAR(7),
	`host` VARCHAR(255),
	`opt_total_amount` DECIMAL(10,2) default 0 NOT NULL,
	`opt_is_payed` INTEGER,
	`opt_client_name` VARCHAR(255),
	`opt_client_email` VARCHAR(128),
	`opt_client_company` VARCHAR(128),
	`remote_address` VARCHAR(45),
	`is_codes_sent` INTEGER,
	`opt_allegro_nick` VARCHAR(255),
	`opt_allegro_checkout_form_id` CHAR(36),
	`show_opinion` INTEGER,
	`change_stock_on` VARCHAR(45),
	`partner_id` INTEGER,
	`provision_value` FLOAT,
	`provision_payed` INTEGER default 0,
	PRIMARY KEY (`id`),
	UNIQUE KEY `st_order_opt_allegro_checkout_form_id_unique` (`opt_allegro_checkout_form_id`),
	KEY `order_number`(`number`),
	KEY `discount_coupon_code_FI`(`discount_coupon_code_id`),
	KEY `discount_FI`(`discount_id`),
	INDEX `st_order_FI_1` (`order_delivery_id`),
	CONSTRAINT `st_order_FK_1`
		FOREIGN KEY (`order_delivery_id`)
		REFERENCES `st_order_delivery` (`id`)
		ON DELETE SET NULL,
	INDEX `st_order_FI_2` (`sf_guard_user_id`),
	CONSTRAINT `st_order_FK_2`
		FOREIGN KEY (`sf_guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE SET NULL,
	INDEX `st_order_FI_3` (`order_user_data_delivery_id`),
	CONSTRAINT `st_order_FK_3`
		FOREIGN KEY (`order_user_data_delivery_id`)
		REFERENCES `st_order_user_data_delivery` (`id`)
		ON DELETE SET NULL,
	INDEX `st_order_FI_4` (`order_user_data_billing_id`),
	CONSTRAINT `st_order_FK_4`
		FOREIGN KEY (`order_user_data_billing_id`)
		REFERENCES `st_order_user_data_billing` (`id`)
		ON DELETE SET NULL,
	INDEX `st_order_FI_5` (`order_currency_id`),
	CONSTRAINT `st_order_FK_5`
		FOREIGN KEY (`order_currency_id`)
		REFERENCES `st_order_currency` (`id`)
		ON DELETE RESTRICT,
	INDEX `st_order_FI_6` (`order_status_id`),
	CONSTRAINT `st_order_FK_6`
		FOREIGN KEY (`order_status_id`)
		REFERENCES `st_order_status` (`id`)
		ON DELETE RESTRICT,
	CONSTRAINT `st_order_FK_7`
		FOREIGN KEY (`discount_coupon_code_id`)
		REFERENCES `st_discount_coupon_code` (`id`)
		ON DELETE SET NULL,
	CONSTRAINT `st_order_FK_8`
		FOREIGN KEY (`discount_id`)
		REFERENCES `st_discount` (`id`)
		ON DELETE SET NULL,
	INDEX `st_order_FI_9` (`partner_id`),
	CONSTRAINT `st_order_FK_9`
		FOREIGN KEY (`partner_id`)
		REFERENCES `st_partner` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_order_status
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_order_status`;


CREATE TABLE `st_order_status`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`coupon_code_id` INTEGER,
	`opt_name` VARCHAR(128),
	`opt_description` TEXT,
	`type` VARCHAR(16),
	`is_default` INTEGER default 0,
	`is_system_default` INTEGER default 0,
	`has_mail_notification` INTEGER default 1,
	`has_coupon_code` INTEGER default 0 NOT NULL,
	`has_invoice_proforma` INTEGER default 0,
	`has_invoice` INTEGER default 0,
	`depository_action` CHAR(1),
	PRIMARY KEY (`id`),
	INDEX `st_order_status_FI_1` (`coupon_code_id`),
	CONSTRAINT `st_order_status_FK_1`
		FOREIGN KEY (`coupon_code_id`)
		REFERENCES `st_order_status_coupon_code` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_order_currency
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_order_currency`;


CREATE TABLE `st_order_currency`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	`exchange` DECIMAL(6,4),
	`shortcut` VARCHAR(20),
	`front_symbol` VARCHAR(20),
	`back_symbol` VARCHAR(20),
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_order_product
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_order_product`;


CREATE TABLE `st_order_product`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`order_id` INTEGER  NOT NULL,
	`product_id` INTEGER,
	`tax_id` INTEGER,
	`quantity` DECIMAL(8,2)  NOT NULL,
	`code` VARCHAR(255),
	`name` VARCHAR(1024),
	`image` VARCHAR(255),
	`price` DECIMAL(10,2),
	`price_brutto` DECIMAL(10,2),
	`custom_price` DECIMAL(10,2),
	`custom_price_brutto` DECIMAL(10,2),
	`vat` DECIMAL(5,2),
	`points_value` INTEGER default 0,
	`points_earn` INTEGER default 0,
	`product_for_points` INTEGER default 0 NOT NULL,
	`version` INTEGER,
	`is_set` INTEGER default 0 NOT NULL,
	`is_gift` INTEGER default 0 NOT NULL,
	`send_review` DATETIME,
	`price_modifiers` TEXT,
	`discount` VARCHAR(1024),
	`currency` VARCHAR(1024),
	`wholesale` VARCHAR(1024),
	`online_code` VARCHAR(255),
	`allegro_auction_id` BIGINT,
	`options` VARCHAR(255),
	PRIMARY KEY (`id`),
	INDEX `st_order_product_FI_1` (`order_id`),
	CONSTRAINT `st_order_product_FK_1`
		FOREIGN KEY (`order_id`)
		REFERENCES `st_order` (`id`)
		ON DELETE CASCADE,
	INDEX `st_order_product_FI_2` (`product_id`),
	CONSTRAINT `st_order_product_FK_2`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE SET NULL,
	INDEX `st_order_product_FI_3` (`tax_id`),
	CONSTRAINT `st_order_product_FK_3`
		FOREIGN KEY (`tax_id`)
		REFERENCES `st_tax` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_order_product_has_set
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_order_product_has_set`;


CREATE TABLE `st_order_product_has_set`
(
	`order_product_id` INTEGER  NOT NULL,
	`product_id` INTEGER  NOT NULL,
	`code` VARCHAR(255),
	`name` VARCHAR(255),
	`price_netto` DECIMAL(10,2),
	`price_brutto` DECIMAL(10,2),
	PRIMARY KEY (`order_product_id`,`product_id`),
	CONSTRAINT `st_order_product_has_set_FK_1`
		FOREIGN KEY (`order_product_id`)
		REFERENCES `st_order_product` (`id`)
		ON DELETE CASCADE,
	INDEX `st_order_product_has_set_FI_2` (`product_id`),
	CONSTRAINT `st_order_product_has_set_FK_2`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_order_user_data_billing
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_order_user_data_billing`;


CREATE TABLE `st_order_user_data_billing`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`countries_id` INTEGER,
	`has_valid_vat_eu` INTEGER default 0 NOT NULL,
	`country` VARCHAR(255),
	`full_name` VARCHAR(255),
	`address` VARCHAR(255),
	`address_more` VARCHAR(255),
	`region` VARCHAR(255),
	`name` VARCHAR(255),
	`surname` VARCHAR(255),
	`street` VARCHAR(255),
	`house` VARCHAR(255),
	`flat` VARCHAR(255),
	`code` VARCHAR(255),
	`town` VARCHAR(255),
	`phone` VARCHAR(255),
	`company` VARCHAR(255),
	`vat_number` VARCHAR(255),
	`pesel` VARCHAR(255),
	`crypt` INTEGER default 0,
	PRIMARY KEY (`id`),
	INDEX `st_order_user_data_billing_FI_1` (`countries_id`),
	CONSTRAINT `st_order_user_data_billing_FK_1`
		FOREIGN KEY (`countries_id`)
		REFERENCES `st_countries` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_order_user_data_delivery
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_order_user_data_delivery`;


CREATE TABLE `st_order_user_data_delivery`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`countries_id` INTEGER,
	`country` VARCHAR(255),
	`full_name` VARCHAR(255),
	`address` VARCHAR(255),
	`address_more` VARCHAR(255),
	`region` VARCHAR(255),
	`name` VARCHAR(255),
	`surname` VARCHAR(255),
	`street` VARCHAR(255),
	`house` VARCHAR(255),
	`flat` VARCHAR(255),
	`code` VARCHAR(255),
	`town` VARCHAR(255),
	`phone` VARCHAR(255),
	`company` VARCHAR(255),
	`vat_number` VARCHAR(255),
	`pesel` VARCHAR(255),
	`crypt` INTEGER default 0,
	PRIMARY KEY (`id`),
	INDEX `st_order_user_data_delivery_FI_1` (`countries_id`),
	CONSTRAINT `st_order_user_data_delivery_FK_1`
		FOREIGN KEY (`countries_id`)
		REFERENCES `st_countries` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_order_delivery
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_order_delivery`;


CREATE TABLE `st_order_delivery`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`tax_id` INTEGER,
	`delivery_id` INTEGER,
	`name` VARCHAR(255),
	`cost` DECIMAL(10,2),
	`payment_cost` DECIMAL(10,2),
	`opt_tax` DECIMAL(5,2),
	`number` VARCHAR(128),
	`cost_brutto` DECIMAL(10,2),
	`payment_cost_brutto` DECIMAL(10,2),
	`custom_cost_brutto` DECIMAL(10,2),
	`delivery_date` DATETIME,
	`pickup_point` VARCHAR(64),
	`opt_allegro_delivery_method_id` CHAR(36),
	`opt_allegro_delivery_smart` INTEGER,
	`paczkomaty_number` VARCHAR(20),
	PRIMARY KEY (`id`),
	INDEX `st_order_delivery_FI_1` (`tax_id`),
	CONSTRAINT `st_order_delivery_FK_1`
		FOREIGN KEY (`tax_id`)
		REFERENCES `st_tax` (`id`)
		ON DELETE SET NULL,
	INDEX `st_order_delivery_FI_2` (`delivery_id`),
	CONSTRAINT `st_order_delivery_FK_2`
		FOREIGN KEY (`delivery_id`)
		REFERENCES `st_delivery` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_order_status_coupon_code
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_order_status_coupon_code`;


CREATE TABLE `st_order_status_coupon_code`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`discount` DECIMAL(3,1) default 0 NOT NULL,
	`valid_for` INTEGER default 0 NOT NULL,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_order_status_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_order_status_i18n`;


CREATE TABLE `st_order_status_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	`description` TEXT,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `st_order_status_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_order_status` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_review
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_review`;


CREATE TABLE `st_review`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`order_id` INTEGER,
	`sf_guard_user_id` INTEGER,
	`product_id` INTEGER  NOT NULL,
	`active` INTEGER default 1 NOT NULL,
	`score` INTEGER,
	`merchant` INTEGER,
	`admin_name` TEXT,
	`admin_active` INTEGER,
	`anonymous` TEXT,
	`agreement` INTEGER default 0 NOT NULL,
	`skipped` INTEGER default 0 NOT NULL,
	`order_number` VARCHAR(64),
	`description` TEXT,
	`user_ip` VARCHAR(20),
	`username` VARCHAR(255),
	`language` VARCHAR(255),
	`is_pin_review` INTEGER default 0,
	`pin_review` INTEGER default 0,
	`user_picture` VARCHAR(255),
	`user_facebook` VARCHAR(255),
	`user_instagram` VARCHAR(255),
	`user_youtube` VARCHAR(255),
	`user_twitter` VARCHAR(255),
	`user_review_verified` INTEGER default 0,
	PRIMARY KEY (`id`),
	INDEX `st_review_FI_1` (`order_id`),
	CONSTRAINT `st_review_FK_1`
		FOREIGN KEY (`order_id`)
		REFERENCES `st_order` (`id`)
		ON DELETE CASCADE,
	INDEX `st_review_FI_2` (`sf_guard_user_id`),
	CONSTRAINT `st_review_FK_2`
		FOREIGN KEY (`sf_guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE,
	INDEX `st_review_FI_3` (`product_id`),
	CONSTRAINT `st_review_FK_3`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_review_order
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_review_order`;


CREATE TABLE `st_review_order`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`order_id` INTEGER  NOT NULL,
	`order_number` VARCHAR(64),
	`sf_guard_user_id` INTEGER  NOT NULL,
	`agreement` INTEGER,
	`mark` INTEGER,
	`active` INTEGER default 0,
	`description` TEXT,
	PRIMARY KEY (`id`),
	INDEX `st_review_order_FI_1` (`order_id`),
	CONSTRAINT `st_review_order_FK_1`
		FOREIGN KEY (`order_id`)
		REFERENCES `st_order` (`id`)
		ON DELETE CASCADE,
	INDEX `st_review_order_FI_2` (`sf_guard_user_id`),
	CONSTRAINT `st_review_order_FK_2`
		FOREIGN KEY (`sf_guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_review_remind
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_review_remind`;


CREATE TABLE `st_review_remind`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255),
	`text` TEXT,
	`active` INTEGER,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_user_data
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_user_data`;


CREATE TABLE `st_user_data`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`sf_guard_user_id` INTEGER  NOT NULL,
	`countries_id` INTEGER  NOT NULL,
	`is_billing` INTEGER,
	`is_default` INTEGER default 0,
	`name` VARCHAR(255),
	`surname` VARCHAR(255),
	`full_name` VARCHAR(128),
	`address` VARCHAR(255),
	`address_more` VARCHAR(255),
	`region` VARCHAR(128),
	`street` VARCHAR(255),
	`house` VARCHAR(255),
	`flat` VARCHAR(255),
	`code` VARCHAR(255),
	`town` VARCHAR(255),
	`phone` VARCHAR(255),
	`company` VARCHAR(255),
	`vat_number` VARCHAR(255),
	`pesel` VARCHAR(255),
	`crypt` INTEGER default 0,
	PRIMARY KEY (`id`),
	INDEX `st_user_data_FI_1` (`sf_guard_user_id`),
	CONSTRAINT `st_user_data_FK_1`
		FOREIGN KEY (`sf_guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE,
	INDEX `st_user_data_FI_2` (`countries_id`),
	CONSTRAINT `st_user_data_FK_2`
		FOREIGN KEY (`countries_id`)
		REFERENCES `st_countries` (`id`)
		ON DELETE RESTRICT
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_basket
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_basket`;


CREATE TABLE `st_basket`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`sf_guard_user_id` INTEGER,
	`discount_coupon_code_id` INTEGER,
	`is_default` INTEGER,
	`hash_code` VARCHAR(32),
	PRIMARY KEY (`id`),
	INDEX `st_basket_FI_1` (`sf_guard_user_id`),
	CONSTRAINT `st_basket_FK_1`
		FOREIGN KEY (`sf_guard_user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE,
	INDEX `st_basket_FI_2` (`discount_coupon_code_id`),
	CONSTRAINT `st_basket_FK_2`
		FOREIGN KEY (`discount_coupon_code_id`)
		REFERENCES `st_discount_coupon_code` (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_basket_product
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_basket_product`;


CREATE TABLE `st_basket_product`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`product_id` INTEGER default 0 NOT NULL,
	`product_set_discount_id` INTEGER,
	`basket_id` INTEGER  NOT NULL,
	`is_gift` INTEGER default 0 NOT NULL,
	`quantity` DECIMAL(8,2),
	`max_quantity` DECIMAL(8,2),
	`code` VARCHAR(255),
	`name` VARCHAR(255),
	`image` VARCHAR(255),
	`item_id` VARCHAR(32),
	`price` DECIMAL(10,2),
	`price_brutto` DECIMAL(10,2),
	`vat` FLOAT,
	`weight` FLOAT,
	`product_for_points` INTEGER default 0 NOT NULL,
	`price_modifiers` TEXT,
	`discount` VARCHAR(1024),
	`currency` VARCHAR(1024),
	`wholesale` VARCHAR(1024),
	`options` VARCHAR(255),
	`new_options` TEXT,
	PRIMARY KEY (`id`),
	KEY `product_set_discount_idx`(`product_set_discount_id`),
	INDEX `st_basket_product_FI_1` (`product_id`),
	CONSTRAINT `st_basket_product_FK_1`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE,
	INDEX `st_basket_product_FI_2` (`basket_id`),
	CONSTRAINT `st_basket_product_FK_2`
		FOREIGN KEY (`basket_id`)
		REFERENCES `st_basket` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_producer
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_producer`;


CREATE TABLE `st_producer`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`sf_asset_id` INTEGER,
	`image` VARCHAR(255),
	`link` VARCHAR(255),
	`opt_name` VARCHAR(255),
	`opt_url` VARCHAR(255),
	`opt_description` TEXT,
	`opt_image_crop` VARCHAR(450),
	PRIMARY KEY (`id`),
	INDEX `st_producer_FI_1` (`sf_asset_id`),
	CONSTRAINT `st_producer_FK_1`
		FOREIGN KEY (`sf_asset_id`)
		REFERENCES `sf_asset` (`id`)
		ON DELETE SET NULL
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_producer_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_producer_i18n`;


CREATE TABLE `st_producer_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	`url` VARCHAR(255),
	`description` TEXT,
	PRIMARY KEY (`id`,`culture`),
	KEY `producer_Index1`(`url`, `culture`),
	CONSTRAINT `st_producer_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_producer` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_group
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_group`;


CREATE TABLE `st_product_group`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`product_group` VARCHAR(255),
	`opt_name` VARCHAR(255),
	`product_limit` INTEGER,
	`opt_url` VARCHAR(255),
	`opt_label` VARCHAR(255),
	`opt_image` VARCHAR(255),
	`from_basket_value` INTEGER,
	PRIMARY KEY (`id`)
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_group_has_product
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_group_has_product`;


CREATE TABLE `st_product_group_has_product`
(
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`product_id` INTEGER  NOT NULL,
	`product_group_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `st_product_group_has_product_FI_1` (`product_id`),
	CONSTRAINT `st_product_group_has_product_FK_1`
		FOREIGN KEY (`product_id`)
		REFERENCES `st_product` (`id`)
		ON DELETE CASCADE,
	INDEX `st_product_group_has_product_FI_2` (`product_group_id`),
	CONSTRAINT `st_product_group_has_product_FK_2`
		FOREIGN KEY (`product_group_id`)
		REFERENCES `st_product_group` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

#-----------------------------------------------------------------------------
#-- st_product_group_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `st_product_group_i18n`;


CREATE TABLE `st_product_group_i18n`
(
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	`name` VARCHAR(255),
	`url` VARCHAR(255),
	`label` VARCHAR(255),
	`image` VARCHAR(255),
	PRIMARY KEY (`id`,`culture`),
	KEY `product_group_Index1`(`url`, `culture`),
	CONSTRAINT `st_product_group_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `st_product_group` (`id`)
		ON DELETE CASCADE
)Engine=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
