<?php

class TranslationCachePeer extends BaseTranslationCachePeer {

    public static function doSelectByCatalogueAndIndex($catalogue, $index, $languageId) {
        $c = new Criteria();
        $c->add(self::CATALOGUE, $catalogue);
        $c->add(self::CATALOGUE_INDEX, $index);
        $c->add(self::LANGUAGE_ID, $languageId);
        return self::doSelectOne($c);
    }

    public static function doCountByLanguage($languageId) {
        $c = new Criteria();
        $c->add(self::LANGUAGE_ID, $languageId);
        return self::doCount($c);
    }
}
