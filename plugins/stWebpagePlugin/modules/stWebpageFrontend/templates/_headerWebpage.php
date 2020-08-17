<?php
if($webpages_group)
{
echo st_get_component('stWebpageFrontend', 'groupWebpage', array('id'=>$webpages_group->getId(),'in_line'=>1));
}
?>