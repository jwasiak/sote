<?php
use_helper('stAsset', 'Tag', 'stUrl');

function st_availability_image_tag($availability, $thumbnail_type = 'large', $options = array())
{
    if (!is_object($availability->getsfAsset()))  return '';

    $options = _parse_attributes($options);

    if (!isset($options['show_blank']))
    {
        $show_blank = false;
    }
    else
    {
        $show_blank = $options['show_blank'];

        unset($options['show_blank']);
    }

    if ($availability instanceof availability)
    {
        $options['alt'] = $availability->getAvailabilityName();
    }

    if (defined('ST_FAST_CACHE_SAVE_MODE') && (ST_FAST_CACHE_SAVE_MODE==1)) return stFastCacheCode::prepareCode('st_asset_image_tag',array('src'=> $availability, 'type'=> $thumbnail_type, 'for' => 'availability', 'options' => $options));

    return image_tag(st_availability_image_path($availability, $thumbnail_type, $show_blank), $options);
}

function st_availability_image_link_to($availability, $thumbnail_type = 'large', $options = array())
{
    return st_link_to(st_availability_image_tag($availability, $thumbnail_type, $options), 'stavailability/show?url='. $availability->getFriendlyUrl());
}

function st_availability_image_path($availability, $thumbnail_type = 'large', $show_blank = false, $system_path = false, $absolute = false)
{
    if ($availability instanceof sfAsset)
    {
        $asset = $availability;
    }
    elseif ($availability->getOptImage())
    {
        $asset = $availability->getOptImage();
    }
    elseif ($show_blank)
    {
       $asset = 'media/shares/no_image.png';
    }
    else
    {
        return null;
    }

    $ret = st_asset_image_path($asset, $thumbnail_type, 'product', $system_path, $absolute);
    if (!$ret)
    {
        $ret = '';//st_asset_image_path('media/shares/no_image.png', $thumbnail_type, 'availability', $system_path, $absolute);
    }

    return $ret;
}
