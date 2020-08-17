<?php 
if (!$online_files->isNew() && $online_files->getFilename()) echo $online_files->getFilename();
else {
    echo input_file_tag('online_files[filename]');
    echo '<div style="display: inline-block; padding: 6px;">(';
    echo __('maks.').' ';
    $max = return_mb(max((int)ini_get('post_max_size'), (int)ini_get('upload_max_filesize')));
    echo ($max >= 100) ? 100 : $max;
    echo 'MB)</div>';
}

function return_mb($size) {
    if (strtolower($size[strlen($size)-1]) == 'g')
        $size *= 1024;
    return (int)$size;
}
