<?php

/**
 * Subclass for representing a row from the 'st_category_i18n' table.
 *
 *
 *
 * @package lib.model
 */
class CategoryI18n extends BaseCategoryI18n
{
	public function getUrlPathHelper()
	{
		return $this->getCategory()->getUrlPathHelper();
	}
}