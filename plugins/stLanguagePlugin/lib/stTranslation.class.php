<?php
class stTranslation {

	protected
	$culture = null,
	$translationFileName = null;

	public function __construct($culture) {
		$this->culture = strtolower($culture);
	}

	public function getTranslationFileName() {
		if ($this->translationFileName == null) $this->translationFileName = sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'fixtures'.DIRECTORY_SEPARATOR.'stTranslation'.ucfirst($this->culture).'Plugin.data.yml';
		return $this->translationFileName;
	}

	public function getTranslations() {
		if (file_exists($this->getTranslationFileName())) return sfYaml::load(file_get_contents($this->getTranslationFileName()));
		return array();
	}

	public function translate() {
		$translations = $this->getTranslations();

		foreach (ProductGroupPeer::doSelect(new Criteria()) as $r) {
			$r->setCulture($this->culture);
				
			$name = $r->getName();
			if ($name == 'Promocje') $id = 1;
			elseif ($name == 'Wyprzedaż') $id = 2;
			elseif ($name == 'Polecamy') $id = 3;
			elseif ($name == 'Strona główna') $id = 4;
			elseif ($name == 'Polecamy w koszyku') $id = 5;
			elseif ($name == 'Nowości') $id = 6;
			else $id = '';

			if (!empty($id)) {
				$translationArray = $translations['ProductGroupI18n']['ProductGroupI18n_'.$this->culture.'_'.$id];

				$r->setName($translationArray['name']);
				$r->setUrl($translationArray['url']);
				$r->save();
			}
		}

		foreach (WebpagePeer::doSelect(new Criteria()) as $r) {
			$r->setCulture($this->culture);
				
			$name = $r->getName();
			if ($name == 'O firmie') $id = 1;
			elseif ($name == 'Regulamin') $id = 2;
			elseif ($name == 'Kontakt') $id = 3;
			elseif ($name == 'Polityka prywatności') $id = 4;
			else $id = '';

			if (!empty($id)) {
				$translationArray = $translations['WebpageI18n']['WebpageI18n_'.$this->culture.'_'.$id];

				$r->setName($translationArray['name']);
				$r->setUrl($translationArray['url']);
				$r->save();
			}
		}

		foreach (TextPeer::doSelect(new Criteria()) as $r) {
			$r->setCulture($this->culture);
			
			$name = $r->getName();
			$content = $r->getContent();
			if ($name == 'Strona główna' && $content == 'Zapraszamy na zakupy.') $id = 1;
			else $id = '';

			if (!empty($id)) {
				$translationArray = $translations['TextI18n']['TextI18n_'.$this->culture.'_'.$id];

				$r->setName($translationArray['name']);
				$r->setContent($translationArray['content']);
				$r->save();
			}
		}

		unset($translations);
	}
}