<?php
if ($handle != null)
{ 
    while (!feof($handle))
    {
        echo fread($handle, 8192);
    }
    fclose($handle);
}
