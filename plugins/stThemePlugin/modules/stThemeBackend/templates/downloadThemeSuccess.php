<?php
if ($handle) {
	while (!feof($handle)) echo fread($handle, 8192);
	fclose($handle);
}