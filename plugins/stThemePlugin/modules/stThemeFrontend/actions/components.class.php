<?php
/**
 * SOTESHOP/stThemePlugin
 *
 * Ten plik należy do aplikacji stThemePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stThemePlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 256 2009-03-30 11:49:45Z marek $
 */

/**
 * Klasa stThemeBackendComponents
 *
 * @package     stThemePlugin
 * @subpackage  actions
 */
class stThemeFrontendComponents extends sfComponents
{
	/**
	 * Wyświetlenie bannera SWF w nagłówku sklepu 
	 */
	public function executeShowSwf()
	{
		$css = ThemeCssPeer::doSelectByThemeId(stTheme::getInstance(sfContext::getInstance())->getTheme()->getId());

		$hasBanner = false;
		foreach ($css as $record)
		{
			if ($record->getCssHeadId() == 'baner_swf')
			{
				$hasBanner = true;
				$banner = explode(',', $record->getCssContent());

				$this->path = $banner[0];
				$this->width = $banner[1];
				$this->height = $banner[2];
				break;
			}
		}

		if($hasBanner == false) return sfView::NONE;
	}

	/**
	 * Wyświetlenie nagłówka edycji tematu graficznego 
	 */
	public function executeEditThemeHead()
	{
		if(SF_ENVIRONMENT == 'edit')
		{
			$context = $this->getContext();
			$user = $context->getUser();
			$this->isAuthenticated = $user->isAuthenticated();

			if($user->isAuthenticated())
			{
				$c = new Criteria();
				$c->add(sfGuardGroupPeer::NAME, 'admin');
				$adminGroup = sfGuardGroupPeer::doSelectOne($c);

				$c = new Criteria();
				$c->add(sfGuardUserGroupPeer::USER_ID, $user->getGuardUser()->getId());
				$c->add(sfGuardUserGroupPeer::GROUP_ID, $adminGroup->getId());
				$isAdmin = sfGuardUserGroupPeer::doCount($c);

				if(!$isAdmin)
				{
					$user->logoutUser();
					$context->getController()->redirect('stUser/loginUser');
				}
			}

			$theme = stTheme::getInstance($context)->getTheme();
			$this->themeName = $theme->getTheme();

			$themeColors = ThemeColorSchemePeer::doSelectByThemeId($theme->getId());

			$this->selectColors = array(0 => '---');
			$this->selectActiveColor = 0;

			foreach($themeColors as $color)
			{
				$this->selectColors[$color->getId()] = $color->getName();
				if($color->getIsDefault() == 1) $this->selectActiveColor = $color->getId();
			}
		}
	}

	/**
	 * Wyświetlenie stopki edycji tematu graficznego 
	 */
	public function executeEditThemeFoot()
	{
		$this->isAuthenticated = $this->getUser()->isAuthenticated();
	}
}