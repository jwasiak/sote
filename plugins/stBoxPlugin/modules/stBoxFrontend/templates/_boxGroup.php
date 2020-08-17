<?php
foreach ($boxes as $box)
{
    echo st_get_partial('stBoxFrontend/boxSingle',array('box'=>$box, 'smarty'=>$smarty));
}
?>