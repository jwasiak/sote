<?php if (($webpage->getCulture()=="pl_PL") || ($webpage->getCulture()=='en_US')):?>
    <?php $lang_tab = explode("_",$webpage->getCulture());?>
    <?php $lang=$lang_tab[0];?> 
<?php else:?>
    <?php $lang = $webpage->getCulture();?> 
<?php endif;?>

<?php  echo link_to(__("Przejdź do strony"), "http://".$sf_request->getHost()."/webpage/".$lang."/".$webpage->getUrl().".html", array("target"=>"_blank")) ?>