<?php
class stLanguageBackendFilter extends sfFilter
{
	public function execute($filterChain)
	{
		$context = $this->getContext();
		if ($context->getUser()->getAttribute('changedLanguage', false, stLanguage::SESSION_NAMESPACE) == false)
		{
			$c = new Criteria();
			$c->add(LanguagePeer::IS_DEFAULT_PANEL, 1);
			$language = LanguagePeer::doSelectOne($c);

			if (is_object($language)) $context->getUser()->setCulture($language->getOriginalLanguage());
		}
		
		$filterChain->execute();
	}
}