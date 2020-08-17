<?php
if ($producers && $show_filter_in_category)
{
    st_theme_use_stylesheet('stProducer.css');
    use_helper('Object','stText');
    if (isset($chosen_producer))
    {
        $smarty->assign('chosen_producer',$chosen_producer);
        $smarty->assign('clear_link', st_link_to('Wszyscy','stProduct/?id_category='.$category_id.'&clean=1'));
    }
    else
    {
        $smarty->assign('clear_link', '<span style="font-weight:bold">Wszyscy</span>');
    }
    $smarty->assign('category_id',$category_id);
    $results=array();
    foreach ($producers as $producer)
    {
        $row['id'] = $producer->getId();
        $row['name'] = $producer->getName();
        $results[]=$row;
    }
    $smarty->assign('results',$results);
    $smarty->display('producer_category_filter.html');
}