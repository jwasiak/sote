<?php

class AllegroCategory extends BaseAllegroCategory {

    public function __toString() {
        return $this->getName();
    }

    public function getPath($separator = ' / ') {
        $path = array($this->getName());
        $parent = $this->parent;

        while($parent != 0) {
            $category = AllegroCategoryPeer::doSelectByCatId($parent, $this->site);
            if (is_object($category)) {
                $path[] = $category->getName();
                $parent = $category->getParent();
            } else 
                $parent = 0;
        }

        krsort($path);
        return implode($separator, $path);
    }

    public function getIsParent()
    {
        $c = new Criteria();
        $c->add(AllegroCategoryPeer::PARENT, $this->getCatId());
        $c->add(AllegroCategoryPeer::SITE, $this->getSite());
        $c->add(AllegroCategoryPeer::IS_OLD, 0);
        return AllegroCategoryPeer::doCount($c) > 0;
    }
}
