<?php
class stCheckBrowser {
    public static function check() {
        $stWebRequest = new stWebRequest();
        $httpUserAgent = $stWebRequest->getHttpUserAgent();

        if (!preg_match('/MSIE 6\.0/', $httpUserAgent) && !preg_match('/MSIE 7\.0/', $httpUserAgent))
            return true;
        return false;
    }
}