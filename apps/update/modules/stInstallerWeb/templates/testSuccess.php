<?php
// 
// $diff=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'package-schema-diff.yml';
// // $diff=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'package-schema-diff-empty.yml';
//    if (file_exists($diff))
//    {
//        $dbmodified=0;
//        $data=sfYaml::load($diff);
//        echo "<pre>";print_r($data);echo "</pre>";
//        foreach ($data['propel'] as $mode=>$apps_data)
//        {
//            foreach ($apps_data as $app=>$dbdata)
//            {
//                if (! empty($dbdata)) $dbmodified=1;
//            }           
//        }
//        
//        if ($dbmodified==1) echo "baza zmodyfikowana";
//        else echo "baza bez zmian";
//    } else throw new Exception ("The file $diff not exists");
?>