<?php
if($sf_params->get('showAdvance',0)!=1)
{
    stSearch::useFriendlyLink(false);

    $producerList = array();

    $params = array('module' => 'stSearchFrontend', 'action' => 'search', 'st_search[producer]' => 0);
    $linkToParams = array_merge($searchEngine->getPagerParams(true), $params);
    $smarty->assign('all_producer', st_link_to(__('Wszyscy producenci'), $linkToParams));

    /** default2 **/

    $results['all']['option_value'] = url_for($linkToParams);

    $results['all']['label'] =   __('Wszyscy producenci', null, 'stProducer');
    

    $smarty->assign('producer_text', __('Filtruj po producentach'));


    foreach ($producers as $producer)
    {
        $params = array('module' => 'stSearchFrontend', 'action' => 'search', 'st_search[producer]' => $producer->getId());
        $linkToParams = array_merge($searchEngine->getPagerParams(true), $params);
        $producerList[] = st_link_to($producer->getName(), $linkToParams);

        /** default 2 **/

        $id = $producer->getId();

        $results[$id]['label'] = $producer->getName();

        $results[$id]['option_value'] =  url_for($linkToParams);

    }

    $smarty->assign('producers', $producerList);

    /** default2 **/

    $smarty->assign('producers2', $results);
    

    $smarty->assign('selected', $chosen_producer);

    $smarty->display('search_producers.html');

    stSearch::useFriendlyLink(true);
}