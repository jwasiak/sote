<?php 
$phrase = stLanguageEditor::getInstance($translation_cache->getLanguage()->getLanguage())->getPhraseByIndex($translation_cache->getCatalogue(), $translation_cache->getCatalogueIndex());
echo $phrase['phrase'];
