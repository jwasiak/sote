<?php
if (is_object($online_files) && $online_files->getProductId() && $online_files->getFilename()) {
	$file = sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'online-files'.DIRECTORY_SEPARATOR.$online_files->getProductId().DIRECTORY_SEPARATOR.$online_files->getFilename();

	if (file_exists($file)) {
		$filesize = filesize($file)/1024;

		if ($filesize < 1024) echo number_format($filesize, 1).' KB';
		else echo number_format($filesize / 1024, 1).' MB';
	} else {
		echo '-';
	}
} else {
	echo '-';
}