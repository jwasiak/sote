<?php
try {
    if (version_compare($version_old, '1.2.0.0', '<')) {
        $filename = 'plugins'.DIRECTORY_SEPARATOR.'sfTCPDFPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'tcpdf'.DIRECTORY_SEPARATOR.'tcpdf.php';
        $checkSums = array(
            '1.0.0' => 'ef84ddc1d19c406f1f3ca301166c68e4',
        	'1.0.0.3' => '99b08392160c52e9a5c7f9fbecf7fa7e',
        	'1.0.0.4' => '740214836db6872e9236d7927fd3c2e1',
        );

        foreach ($checkSums as $version => $checkSum) {
            if (md5_file(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$filename) == $checkSum) {
                copy(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'stTCPDFPlugin'.DIRECTORY_SEPARATOR.$filename, sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$filename);
            }
        }
    }
} catch (Exception $e) {
}

try {
	if (version_compare($version_old, '7.2.0.0', '<=')) {
		$files = array(	'images/_blank.png',
						'images/logo_example.png',
						'images',
						'',
		);
		foreach ($files as $file) {
			$file = sfConfig::get('sf_web_dir').'/sfTCPDFPlugin/'.$file;
			if (file_exists($file))
				if (is_dir($file))
					rmdir($file);
				else
					unlink($file);
		}
	}
} catch (Exception $e) {
	// @todo: log $e->getMessage();
}
