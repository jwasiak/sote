<?php


class stSantanderFrontendActions extends stActions
{
    public function executeAccepted()
    {
        $this->smarty = new stSmarty('stSantanderFrontend');
        $this->smarty->assign('id_wniosku', $this->getRequestParameter('id_wniosku'));
    }

    public function executeCanceled()
    {
        $this->smarty = new stSmarty('stSantanderFrontend');
    }
}