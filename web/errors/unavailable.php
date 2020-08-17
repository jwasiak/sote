<?php  
if (preg_match('/^(Googlebot\/)|(MSNBot)|(Yahoo Slurp)|(bot)|(bot-)|(robot)/', $_SERVER['HTTP_USER_AGENT'])) header("HTTP/1.1 304 Not Modified");

$config_dir = dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR;
if (file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'core')) $config_dir = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR;
$image_dir = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'error'.DIRECTORY_SEPARATOR; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="title" content="Sklep chwilowo niedostępny" />
        <title><?php if(file_exists($config_dir.'error_title.txt')): echo file_get_contents($config_dir.'error_title.txt'); else :  ?>Przerwa techniczna.<?php endif; ?></title>
        <link rel="stylesheet" type="text/css" media="screen" href="/css/frontend/theme/default2/error.css" />
        <!--[if IE]>
            <style type="text/css">
                #box_error500 {margin-left: -150px; transform: none;}
            </style>
        <![endif]-->
    </head>
    <body>
        <div style="display:none">blokowanie sklepu</div>
        <div id="box_error500">
            <div id="box_error500_left">
                <?php if (file_exists($image_dir.'custom_page_error.jpg')): ?>
                    <img src="/images/frontend/theme/default/error/custom_page_error.jpg" alt=""/>
                <?php else: ?>
                    <img src="/images/frontend/theme/default2/error/page_error.png" alt=""/>
                <?php endif; ?>
            </div>   
            <div id="box_error500_right">
                <?php if (SF_APP == 'backend' && (floatval(phpversion()) < 5.4 || floatval(phpversion()) >= 7.2)): ?>
                    <div class="txt_red">
                        Serwer nie spełnia wymagań technicznych.<br>
                        Wymaga wersja PHP to <b>5.4.x - 7.1.x</b> (aktualnie ustawiona wersja PHP na serwerze <b><?php echo phpversion() ?>)</b> 
                    </div>
                <?php else: ?>
                    <div class="txt_red">
                        <?php if (file_exists($config_dir.'error_title.txt')): echo file_get_contents($config_dir.'error_title.txt'); else :?>Przepraszamy<?php endif;?>
                    </div>
                    <div class="txt">
                        <?php if (file_exists($config_dir.'error_content.txt')): echo file_get_contents($config_dir.'error_content.txt'); else:?>Strona chwilowo niedostępna<?php endif;?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </body>
</html>