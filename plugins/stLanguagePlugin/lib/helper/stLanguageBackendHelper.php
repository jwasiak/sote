<?php

function st_language_truncate_phrase($phrase, $length) {
    if (mb_strlen($phrase, 'UTF-8') > (int)$length)
        return mb_substr($phrase, 0, (int)$length, 'UTF-8').'...';
    return $phrase;
}

function st_language_colorize_phrase($phrase, $search, $truncate = null) {
    if ($truncate !== null)
        $phrase = st_language_truncate_phrase($phrase, $truncate);
    if ($search === null || empty($search))
        return $phrase;
    return preg_replace('/'.$search.'/i', '<span style="background-color: #FFFF66; font-weight: bold;">$0</span>', $phrase);
}