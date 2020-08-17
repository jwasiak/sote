<?php
use_helper('stAsset', 'Tag', 'stUrl');

function st_producer_image_tag($producer, $thumbnail_type = 'large', $options = array())
{
    $options = _parse_attributes($options);

    if (!isset($options['show_blank']))
    {
        $show_blank = true;
    }
    else
    {
        $show_blank = $options['show_blank'];

        unset($options['show_blank']);
    }

    if ($producer instanceof Producer)
    {
        $options['alt'] = $producer->getName();
    }

    if (defined('ST_FAST_CACHE_SAVE_MODE') && (ST_FAST_CACHE_SAVE_MODE==1)) return stFastCacheCode::prepareCode('st_asset_image_tag',array('src'=> $producer, 'for' => 'producer', 'type' => $thumbnail_type, 'options' => $options));

    return image_tag(st_producer_image_path($producer, $thumbnail_type, $show_blank), $options);
}

function st_producer_image_link_to($producer, $thumbnail_type = 'large', $options = array())
{
    return st_link_to(st_producer_image_tag($producer, $thumbnail_type, $options), 'stProducer/show?url='. $producer->getFriendlyUrl());
}

function st_producer_image_path($producer, $thumbnail_type = 'large', $show_blank = true, $system_path = false, $absolute = false)
{
    $ret = st_asset_image_path($producer, $thumbnail_type, 'producer', $system_path, $absolute);

    if (!$ret && $show_blank)
    {
        $ret = st_asset_image_path('media/shares/no_image.png', $thumbnail_type, 'producer', $system_path, $absolute);
    }

    return $ret;
}
