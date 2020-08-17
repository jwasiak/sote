<?php

class stDashboardActions extends stActions
{

    public function executeIndex()
    {
		$this->dashboards = $this->getDashboards();

        $this->default_index = 0;

        $this->default_dashboard = $this->dasboards[0];

		foreach ($this->dashboards as $index => $dashboard)
		{
			if ($dashboard->getIsDefault())
			{
				$this->default_index = $index;
				$this->default_dashboard = $dashboard;
				break;
			}
		}
    }
   
	public function executeAjaxDelete()
	{
		$id = $this->getRequestParameter('id');

		$dashboard = DashboardPeer::retrieveByPK($id);

		$dashboard->delete();

		return sfView::HEADER_ONLY;
	}

    public function executeAjaxEditOrCreate()
    {
        $id = $this->getRequestParameter('id');

        if ($id) 
        {
            $dashboard = DashboardPeer::retrieveByPK($id);
        }
        else
        {
            $dashboard = new Dashboard();
        }

        if ($this->getRequest()->getMethod() == sfRequest::POST) 
        {
            $request = $this->getRequestParameter('dashboard_configuration');

            if (isset($request['default']))
            {
                $dashboard->setIsDefault(true);
            }

            $dashboard->setLabel($request['label']);
            $dashboard->setLayout($request['layout']);

            if ($dashboard->isNew())
            {
                $dashboard->setSfGuardUserId($this->getUser()->getGuardUserId());
            }

            $dashboard->save();

            if (!$id && stLicense::isOpen())
            {
                $gadget = DashboardGadgetPeer::doCreate('sote_news', $dashboard->getId(), array('column' => $dashboard->getLayoutColumns()));
                $gadget->save();
            }

            return $this->renderJson(array(
                'id' => $dashboard->getId(),
                'label' => $dashboard->getLabel(),
                'updated_at' => $dashboard->getUpdatedAt(),
                'layout' => $dashboard->getLayout()
            ));
        }

        $this->dashboard_count = DashboardPeer::doCount(new Criteria());

        if (!$this->dashboard_count)
        {
            $dashboard->setIsDefault(true);
        }

        $this->dashboard = $dashboard;
    }

    public function executeAjaxSetDefault()
    {
        $id = $this->getRequestParameter('id');

        $dashboard = DashboardPeer::retrieveByPK($id);

        $dashboard->setIsDefault(true);

        $dashboard->save();

        return sfView::HEADER_ONLY;
    }

    public function executeAjaxChoose()
    {
        $id = $this->getRequestParameter('id');

        $dashboard = DashboardPeer::retrieveByPK($id);

        sfLoader::loadHelpers(array('Helper', 'stBackend'));

        $max_age = 3600 * 24;

        $response = $this->getResponse();

        $response->addCacheControlHttpHeader('private');

        $response->addCacheControlHttpHeader('must-revalidate');      

        $response->addCacheControlHttpHeader('max-age', $max_age);

        $response->addCacheControlHttpHeader('s-maxage', $max_age);      

        $response->setHttpHeader('Expires', false);

        $response->setHttpHeader('Pragma', false);

        return $this->renderText(get_gadget_layout($dashboard));
    }

    public function executeAjaxUpdateLayout()
    {
        $column = $this->getRequestParameter('column');

        $id = $this->getRequestParameter('gadget_id');

        $position = $this->getRequestParameter('position');

        $dashboard_id = $this->getRequestParameter('dashboard_id');
            
        $gadget = DashboardGadgetPeer::retrieveByPK($id, $dashboard_id);

        DashboardGadgetPeer::moveUpFrom($gadget->getPosition()+1, $gadget->getDashboardColumnNo(), $dashboard_id);

        DashboardGadgetPeer::moveDownFrom($position, $column, $dashboard_id);

        $gadget->setPosition($position);

        $gadget->setDashboardColumnNo($column);

        $gadget->save();

        return sfView::HEADER_ONLY;
    }

    public function executeAjaxEditGadget()
    {
        $this->setLayout(false);

        $request = $this->getRequest();

        $id = $request->getParameter('id');

        $dashboard_id = $request->getParameter('dashboard_id');

        $gadget = DashboardGadgetPeer::retrieveByPK($id, $dashboard_id);

        if ($request->getMethod() == sfRequest::POST)
        {
            $parameters = $request->getParameter('gadget_configuration');

            $gadget->setTitle($parameters['title']);

            $gadget->setColor($parameters['color']);

            if (isset($parameters['refresh_by']))
            {
                $gadget->setRefreshBy($parameters['refresh_by']);
            }

            $gadget->save();

            $json = array(
                'title' => $gadget->getTitle(),
                'color' => $gadget->getColor(),
                'refresh_by' => $gadget->getRefreshBy()
            );

            return $this->renderJson($json);
        }

        $this->gadget = $gadget;
    }

    public function executeAjaxRemoveGadget()
    {
        $id = $this->getRequestParameter('id');

        $dashboard_id = $this->getRequestParameter('dashboard_id');

        $gadget = DashboardGadgetPeer::retrieveByPk($id, $dashboard_id);

        $gadget->delete();

        return sfView::HEADER_ONLY;
    }
   
    public function executeAjaxMinimizeGadget()
    {
        $id = $this->getRequestParameter('id');

        $dashboard_id = $this->getRequestParameter('dashboard_id');

        $gadget = DashboardGadgetPeer::retrieveByPk($id, $dashboard_id);

        $gadget->setIsMinimized(true);

        $gadget->save();

        return sfView::HEADER_ONLY;
    } 
   
    public function executeAjaxMaximizeGadget()
    {
        sfLoader::loadHelpers(array('Helper', 'stBackend'));

        $id = $this->getRequestParameter('id');

        $dashboard_id = $this->getRequestParameter('dashboard_id');

        $gadget = DashboardGadgetPeer::retrieveByPk($id, $dashboard_id);

        $gadget->setIsMinimized(false);

        $gadget->save();
            
        return $this->renderText(get_gadget_source($gadget));
    }    

    public function executeAjaxAddGadget()
    {
        sfLoader::loadHelpers(array('Helper', 'Partial', 'stPartial'));

        $name = $this->getRequestParameter('name');

        $column = $this->getRequestParameter('column', 1);

        $dashboard_id = $this->getRequestParameter('dashboard_id');

        $gadget = DashboardGadgetPeer::doCreate($name, $dashboard_id, array('column' => $column));

        $gadget->save();

        $content = st_get_partial('stDashboard/gadgets', array('gadgets' => array($gadget)));

        return $this->renderText($content);
    }

    public function executeAjaxGadgetDirectory()
    {
        $this->count = 0;

        $this->setLayout(false);

        $gadgets = sfConfig::get('app_dashboard_gadget_directory');

        $this->categories = array('Wszystkie' => array());

        foreach ($gadgets as $name => $gadget)
        {
            $this->categories['Wszystkie'][$name] = $gadget;

            $category = isset($gadget['category']) ? $gadget['category'] : null;

            if ($category)
            {
                if (!isset($this->categories[$category]))
                {
                    $this->categories[$category] = array();
                }

                $this->categories[$category][$name] = $gadget;
            }
        }
    }

	protected function getDashboards()
	{
		$dashboards = DashboardPeer::doSelectByUserId($this->getUser()->getGuardUserId());

		if (!$dashboards)
		{
            $config = sfConfig::get('app_dashboard_default');

            $i18n = $this->getContext()->getI18N();

            $dashboard = new Dashboard();

            $dashboard->setIsDefault(true);

            $dashboard->setLabel($i18n->__($config['title'], null, 'stBackend'));

            $dashboard->setSfGuardUserId($this->getUser()->getGuardUserId());

            $dashboard->save();         

            foreach ($config['gadgets'] as $gadget) 
            {
                $dashboard_gadget = DashboardGadgetPeer::doCreate($gadget['name'], $dashboard->getId(), isset($gadget['options']) ? $gadget['options'] : array());

                $dashboard_gadget->save();
            }


            $dashboards[] = $dashboard;
		}

		return $dashboards;
	}
}