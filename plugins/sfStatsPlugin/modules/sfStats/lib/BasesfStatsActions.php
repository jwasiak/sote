<?php

class BasesfStatsActions extends sfActions
{
  public function executeIndex()
  {
    $this->item_config = sfConfig::get('app_sfStats_categories', array());
    $this->prepareFilters();
    $this->prepareItemList();
    $what = isset($this->filters['what']) ? $this->filters['what'] : '';
    $this->prepareSpecificFilters($what);
    list($details, $value) = $this->getItemDetails($what);
    $from = $this->filters['period']['from'];
    $from = is_int($from) ? $from : strtotime($from);
    $to = $this->filters['period']['to'];
    $to = is_int($to) ? $to : strtotime($to);
    $increment = $this->filters['increment'];
    if(isset($value['class']))
    {
      if(isset($value['criteriaGetter']))
      {
          $criteria = call_user_func($value['criteriaGetter']);

          if (!$criteria instanceof Criteria)
          {
              throw new Exception(sprintf('Item %s needs a proper callable in the `criteriaGetter` parameter', $key));
          }
      }
      else
      {
        $criteria = new Criteria();
      }

      if(isset($details['filters']) && isset($this->filters['special']) && $this->filters['special'])
      {
        sfStatsToolkit::filterCriteria($criteria, $details['filters'], $this->filters['special'], $value['class']);
      }
      $this->stats = sfStatsToolkit::getAllValuesSmart($from, $to, $increment, $value['class'], $value['column'], $criteria);
    }
    elseif(isset($value['callable']))
    {
      $this->stats = sfStatsToolkit::getAllValuesCallable($from, $to, $increment, $value['callable']);
    }
  }

  protected function prepareFilters()
  {
    $attHolder = $this->getUser()->getAttributeHolder();
    if($this->getRequest()->hasParameter('filter'))
    {
      $attHolder->removeNamespace('sf_admin/dashboard/filters');
      $filters = $this->getRequestParameter('filters');
      $attHolder->add($filters, 'sf_admin/dashboard/filters');
    }
    if(!$attHolder->hasNamespace('sf_admin/dashboard/filters'))
    {
      $filters = array('increment', 'period', 'what');
      $attHolder->add($filters, 'sf_admin/dashboard/filters');
    }
    $this->filters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/dashboard/filters');

    // from defaults
    if (!isset($this->filters['period']['from']) ||
        $this->filters['period']['from'] === ''  ||
        @strtotime($this->filters['period']['from']) === false)
    {
      $this->filters['period']['from'] = time() - sfConfig::get('app_sfStats_default_days', 365) * 24 * 60 * 60;
    }
    // to defaults
    if (!isset($this->filters['period']['to']) ||
        $this->filters['period']['to'] === ''  ||
        @strtotime($this->filters['period']['to']) === false)
    {
      $this->filters['period']['to'] = time();
    }
    // increment defaults
    if (!isset($this->filters['increment']) ||
        $this->filters['increment'] === '')
    {
      $this->filters['increment'] = 60 * 60 * 24;
    }
    // special defaults
    if (!isset($this->filters['special']) ||
        $this->filters['special'] === '')
    {
      $this->filters['special'] = '';
    }
    // what defaults
    if (sfConfig::get('app_sfStats_default_item') &&
        (!isset($this->filters['what']) ||
        $this->filters['what'] === ''))
    {
      $this->filters['what'] = sfConfig::get('app_sfStats_default_item');
    }
  }

  protected function prepareItemList()
  {
    $i18n = sfContext::getInstance()->getI18N();

    $items = array($i18n->__('Wybierz typ statystyk z listy'));

    foreach($this->item_config as $details)
    {
      foreach ($details['items'] as $key => $value)
      {
        $items[$key] = $i18n->__($value['name'], '', 'sfStats');
      }
    }
    $this->items = $items;
  }

  protected function prepareSpecificFilters($key)
  {
    list($details, $value) = $this->getItemDetails($key);
    if(isset($details['filters']))
    {
      $specialFilters = array();
      foreach($details['filters'] as $filterKey => $filterParams)
      {
        $specialFilters[$filterKey]['name'] = $filterParams['name'];
        if(isset($filterParams['list']))
        {
          $specialFilters[$filterKey]['values'] = $filterParams['list'];
        }
        elseif(isset($filterParams['listGetter']))
        {
          if (is_callable($filterParams['listGetter']))
          {
            $specialFilters[$filterKey]['values'] = call_user_func($filterParams['listGetter']);
          }
          else
          {
            throw new Exception(sprintf('Filter %s needs a proper callable in the `listGetter` parameter', $filterKey));
          }
        }
        else
        {
          throw new Exception(sprintf('Filter %s needs an option list. Please provide either a `list` or a `listGetter` parameter', $filterKey));
        }
      }
      $this->specialFilters = $specialFilters;
    }
  }

  protected function getItemDetails($keyToFind)
  {
    foreach($this->item_config as $details)
    {
      foreach ($details['items'] as $key => $value)
      {
        if($key == $keyToFind)
        {
          return array($details, $value);
        }
      }
    }
    return false;
  }
}