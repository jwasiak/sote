<?php
use_helper('stText');

echo '<meta property="og:type" content="website" />';
echo '<meta property="og:title" content="'.htmlspecialchars($title).'" />';
echo '<meta property="og:description" content="'.htmlspecialchars(st_truncate_text($description, 200)).'" />';
echo '<meta property="og:url" content="'.$url.'" />';
echo '<meta property="og:image" content="'.$image.'" />';
echo '<meta property="og:updated_time" content="'.time().'" />';