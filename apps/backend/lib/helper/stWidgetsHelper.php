<?php
/**
 * Desktop widget components helper
 */
 

function st_open_widget($name,$title)
{
    $name=preg_replace("/[\s]*/",'_',$name);
    
    return 
    '
    <div class="qpanel_list_main st_round_box" id="widget-'.$name.'">
    <div class="st_round_box_header">'.$title.'</div>
    <div class="st_round_box_content">
    ';
}

function st_close_widget()
{
    return 
    '
    </div>
    </div>
    ';
}