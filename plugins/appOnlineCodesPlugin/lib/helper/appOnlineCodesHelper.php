<?php
use_helper('stUrl');
function online_codes_generate_download_link($order, $file) {
	return st_url_for('@appOnlineCodesDownload?file='.$file.'&hash='.$order->getHashCode().'&id='.$order->getId(), true, 'frontend');
}