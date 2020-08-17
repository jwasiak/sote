<?php
function getExtension($fileName)
{
    $tokens = explode(".", $fileName);
    
    
    //print_r($tokens); die();
    if ( count($tokens) < 2)
    {
        
        return "";
    }
    
    return $tokens[count($tokens) - 1];
}

function getFileName($fileName)
{
    $tokens = explode(".", $fileName);
    //echo "[".$tokens."]"; die();
    if ( count($tokens) < 2)
    {
        
        return "";
    }
    
    return $tokens[0];
}
?>