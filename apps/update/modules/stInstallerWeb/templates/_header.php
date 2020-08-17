<header>
	<div class="header left">
	    <h1>
	    	<a href="http://<?php echo $sf_request->getHost();?>" target="_blank"><?php echo $sf_request->getHost();?></a>
	    </h1>
	    <span><?php echo __('Panel aktualizacji', null, 'stInstallerWeb');?></span>
	</div>
	    <div class="auth_links">
	        <span class="backend"><?php echo link_to(__('Panel sklepu', null, 'stInstallerWeb'),"../backend.php", array('popup'=>'backend'));?></span>
	        <span class="frontend"><?php echo link_to(__('Strona sklepu', null, 'stInstallerWeb'),"../index.php", array('popup'=>'frontend'));?></span>
	        <?php echo link_to(__('Wyloguj', null, 'stInstallerWeb'),"stAuth/logout", 'class="logout"');?>
	    </div>
	    <div class="clear"></div>
</header>