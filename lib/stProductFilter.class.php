<?php

class stProductFilter
{
    public static function getFilters(sfContext $context)
    {
        return $context->getUser()->getAttribute('filters', array(), self::getNamespace($context, 'soteshop/stProduct'));
    }

    public static function hasFilters(sfContext $context)
    {
        return (bool)self::getFilters($context);
    }

    public static function setFilters(sfContext $context, $filters)
    {
        $context->getUser()->setAttribute('filters', $filters, self::getNamespace($context, 'soteshop/stProduct'));
    }

    public static function clearFilters(sfContext $context, $filter = null)
    {
        $filters = self::getFilters($context);

        if ($filter && isset($filters[$filter]))
        {
            unset($filters[$filter]);
        }
        elseif (null === $filter)
        {
            $filters = array();
        }

        self::setFilters($context, $filters);
    }

    public static function getNamespace(sfContext $context, $namespace)
    {
        $category = $context->getUser()->getParameter('selected', null, 'soteshop/stCategory');
        
        if ($category)
        {
            return $namespace.'/category/'.$category->getId();
        }
        elseif ($context->getUser()->getParameter('selected', null, 'soteshop/stProductGroup'))
        {
            $group = $context->getUser()->getParameter('selected', null, 'soteshop/stProductGroup');
            return $namespace.'/group/'.$group->getId();
        }

        return $namespace;      
    }

    public static function getFilterUrl(sfContext $context)
    {
        if ($context->getUser()->getParameter('selected', null, 'soteshop/stCategory'))
        {
            $category = $context->getUser()->getParameter('selected', null, 'soteshop/stCategory');
            return '@stProduct?action=filter&category_id='.$category->getId();

        }
        elseif ($context->getUser()->getParameter('selected', null, 'soteshop/stProductGroup'))
        {
            $group = $context->getUser()->getParameter('selected', null, 'soteshop/stProductGroup');
            return '@stProduct?action=filter&group_id='.$group->getId();
        }
      
        return '@stProduct?action=filter';
    }

    public static function getFilterResetUrl(sfContext $context, $filter, $scope = 'filter')
    {
        $params = array();

        if ($filter)
        {
            $params['filter'] = $filter;
        }

        if ($scope)
        {
            $params['scope'] = $scope;
        }

        if ($context->getUser()->getParameter('selected', null, 'soteshop/stCategory'))
        {
            $category = $context->getUser()->getParameter('selected', null, 'soteshop/stCategory');
            $params['category_id'] = $category->getId();

        }
        elseif ($context->getUser()->getParameter('selected', null, 'soteshop/stProductGroup'))
        {
            $group = $context->getUser()->getParameter('selected', null, 'soteshop/stProductGroup');
            $params['group_id'] = $group->getId();
        }

        if ($params)
        {
            $query = $params ? '&'.http_build_query($params, null, '&') : '';
        }
      
        return '@stProduct?action=clearFilter' . $query;
    }

}