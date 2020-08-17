<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
    <?php echo get_partial('menu_top');?>
    <div id="frame_update">  
    	<?php echo get_partial('menu');?>
	    <div class="content">
	    	<h2 class="title"><?php echo __('Pobierz', null, 'stInstallerWeb');?></h2>                              
		    <div class="st_head_txt_installer">   
		        <?php echo __('RSS Wiadomości z najnowszymi aktualizacjami.') ?>
		    </div>      
		    
		    <p />
		    <?php echo __('Dodaj kanał RSS do swojego programu pocztowego, będziesz otrzymywać wiadomości o aktualizacjach w programie.') ?> 
		    <br />
		    <?php echo __('Kanał RSS z najnowszymi aktualizacjami');?>: <b><a href="feed://pear.sote.pl/index.php?rss&latest" target='rss.pear.sote.pl'>feed://pear.sote.pl/index.php?rss&latest</a></b>
		      
		</div>
		<div class="clear"></div>
	</div>