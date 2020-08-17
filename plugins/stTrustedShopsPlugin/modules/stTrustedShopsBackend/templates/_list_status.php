<?php
switch ($trusted_shops->getStatus()) {
	case 'PRODUCTION':
		$status = __('ważny');
		break;
	case 'INTEGRATION':
		$status = __('(jeszcze) nie wydany');
		break;
    case 'TEST':
        $status = __('testowy');
        break;
    case 'NO_AUDIT':
        $status = __('bez audytu');
        break;
    case 'INVALID_TS_ID':
        $status = '-';
        if ($trusted_shops->isRating()) $status = __('aktywny');
        break;
	default:
		$status = '-';
		break;
}
echo $status;