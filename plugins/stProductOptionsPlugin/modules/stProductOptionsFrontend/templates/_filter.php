<?php
use_helper('stProductImage', 'stProductOptions', 'stCurrency');
st_theme_use_stylesheet('stProductOptionsPlugin.css'); 

$smarty_filters = array();

$i = 0;
foreach ($filters as $filter) {

    $smarty_filters[$i]['name'] = $filter->getName();

    foreach (stNewProductOptions::getOptionsForFilter($filter) as $option) {
        if ($filter->getFilterType()==2) 
        {

            $val = $option->getColor();
            $selected = isset($params[$filter->getId()]) && array_search($val ,$params[$filter->getId()]) !== false;
            $smarty_filters[$i]['options'][] = content_tag('div',
                        content_tag('div',
                            checkbox_tag('options_filters['.$filter->getId().']['.$option->getId().']',$val , $selected, array('class' => 'pof_group-'.$i)),
                            array(
                                'class'=>'product_options-color-filter-box',
                                'style'=> $option->getUseImageAsColor() ? "background: url(".$option->getColorImagePath().") no-repeat; background-size: cover" : "background-color: #".$option->getColor(), 
                                'id'=>'product_option_filter_div_'.$option->getId())),
                                array('class'=>'product_options-color-filter'.($selected ? '-selected' : ''))
                            );
        }
        else 
        {
            $smarty_filters[$i]['options'][] = content_tag('div',checkbox_tag('options_filters['.$filter->getId().']['.$option->getId().']' ,$option->getOptValue(),isset($params[$filter->getId()]) && array_search($option->getOptValue(), $params[$filter->getId()]) !== false, array('onclick'=>"jQuery('#of_form').submit()", "class" => "pof_group-".$i)).$option->getValue());
        }
    }    
    $reset_url = st_url_for(stProductFilter::getFilterResetUrl($sf_context, $filter->getId(), 'options'));
    $smarty_filters[$i]['clear'] = isset($params[$filter->getId()]) && $params[$filter->getId()] ? '<a href="'.$reset_url.'" rel="nofollow">'.st_theme_image_tag('stProductOptionsPlugin/icon_delete.png',array('class'=>'product_options_filter_clear_button', 'id' => "pof_group-".$i)).'</a>':'';
    $i++;
}


$smarty->assign('form_start', form_tag(stProductFilter::getFilterUrl($sf_context), array('method'=>'post', 'id'=>'of_form')));
$smarty->assign('clear_filters',st_link_to(__('wyczyść',null,'stProductOptionsFrontend'), stProductFilter::getFilterResetUrl($sf_context, 'all', 'options')));
$smarty->assign('has_filters', stNewProductOptions::hasFilters($sf_context));
$smarty->assign('filters', $smarty_filters);
$smarty->display('options_filter.html');
?>
<script type="text/javascript">    
//<![CDATA[
jQuery(function($) {
    var form = $('#of_form');
    form.find('.product_options-color-filter-box').click(function() {
        var div = $(this).parent();

        if (div.hasClass('product_options-color-filter-selected')) {
            div.removeClass('product_options-color-filter-selected');
            div.addClass('product_options-color-filter');
            var checked = false;
        } else {
            div.addClass('product_options-color-filter-selected');
            div.removeClass('product_options-color-filter');   
            var checked = true;         
        }

        div.find('input[type="checkbox"]').prop('checked', checked);

        form.submit();

        return false;
    });
});
//]]>
</script> 
