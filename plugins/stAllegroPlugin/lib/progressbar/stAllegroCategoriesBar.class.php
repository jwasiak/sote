<?php

class stAllegroCategoriesBar {

    protected $allegro = null;

    protected $i18n;

    public function __construct() {
        $this->i18n = sfContext::getInstance()->getI18n();
        $this->initAllegro();
    }

    public function initAllegro() {
        if ($this->allegro == null) {
            $request = sfContext::getInstance()->getRequest();

            if ($request->hasParameter('environment'))
                $environment = $request->getParameter('environment');
            else
                list(, $environment) = explode('-', $request->getParameter('name'), 2);
            
            $this->allegro = new stAllegro($environment);
        }
    }

    public function getCategories($offset = 0) {
        if ($offset == 0)
        {
            $con = Propel::getConnection();
            $c = new Criteria();
            $c->add(AllegroCategoryPeer::SITE, $this->allegro->getEnvironment());
            
            $cu = new Criteria();
            $cu->add(AllegroCategoryPeer::IS_OLD, 1);
            BasePeer::doUpdate($c, $cu, $con);
        }
        $this->msg = $this->i18n->__('Pobrano %count% z %countAll% kategorii.', array('%count%' => ($offset * 500), '%countAll%' => $this->allegro->getCategoryCount()), 'stAllegroBackend');
        $categories = $this->allegro->getCategories($offset, 500);
        $this->saveCategories($categories);
        return $offset+1;
    }

    public function saveCategories($categories) {
        $ids = array();

        foreach ($categories as $category) {
            if (is_array($category)) {
                $ids[] = $category['catId'];
            }
        }

        $c = new Criteria();
        $c->add(AllegroCategoryPeer::CAT_ID, $ids, Criteria::IN);
        $c->add(AllegroCategoryPeer::SITE, $this->allegro->getEnvironment());
        
        $selected = array();

        foreach (AllegroCategoryPeer::doSelect($c) as $category)
        {
            $selected[$category->getCatId()] = $category;
        }
      
        foreach ($categories as $category) {
            if (is_array($category)) {
                $allegroCategory = isset($selected[$category['catId']]) ? $selected[$category['catId']] : null;

                if (!$allegroCategory) {
                    $allegroCategory = new AllegroCategory();
                    $allegroCategory->setCatId($category['catId']);
                    $allegroCategory->setSite($this->allegro->getEnvironment());
                }

                $allegroCategory->setName($category['catName']);
                $allegroCategory->setParent($category['catParent']);
                $allegroCategory->setPosition($category['catPosition']);

                $allegroCategory->setIsOld(0);
                $allegroCategory->save();
            }
        }
    }

    public function getTitle() {
        return ' ';
    }

    public function getMessage() {
        return $this->msg;
    }

    public function close() {
        $this->msg = sprintf($this->i18n->__('Kategorie zostały pobrane. Ilość pobranych kategorii wynosi %d.', null, 'stAllegroBackend'), $this->allegro->getCategoryCount());
        $ac = new stAllegroCategory($this->allegro);
        $ac->saveCategoryVersion();
    }
}
