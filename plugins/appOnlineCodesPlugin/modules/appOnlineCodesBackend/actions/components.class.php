<?php class appOnlineCodesBackendComponents extends autoAppOnlineCodesBackendComponents {

    public function executeShowFileList() {
        $c = new Criteria();
        $c->add(OnlineFilesPeer::PRODUCT_ID, $this->related_object->getId());
        $c->addDescendingOrderByColumn(OnlineFilesPeer::CREATED_AT);
        if (isset($this->media_type)) $c->add(OnlineFilesPeer::MEDIA_TYPE, $this->media_type);
        $this->files = OnlineFilesPeer::doSelect($c);
    }

    public function executeShowCodeList() {
        $c = new Criteria();
        $c->add(OnlineCodesPeer::PRODUCT_ID, $this->related_object->getId());
        $c->addDescendingOrderByColumn(OnlineCodesPeer::CREATED_AT);
        
        $this->files = OnlineCodesPeer::doSelect($c);
    }

}
