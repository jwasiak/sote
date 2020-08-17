<?php

/**
 * Subclass for representing a row from the 'st_questions' table.
 *
 * 
 *
 * @package plugins.stQuestionPlugin.lib.model
 */ 
class Questions extends BaseQuestions
{
	public function getText()
	{
		return stXssSafe::clean($this->text);
	}

	public function getEmail()
	{
		return stXssSafe::clean($this->email);
	}
	
}
