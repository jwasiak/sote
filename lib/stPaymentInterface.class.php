<?php

interface stPaymentInterface
{
	public function getLogoPath();

	public function isAutoRedirectEnabled();

	public function checkPaymentConfiguration();
}