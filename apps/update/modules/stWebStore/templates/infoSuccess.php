<?php use_helper('stUpdate');?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1');?>
<?php use_stylesheet('/css/update/stWebStorePlugin.css?version=1');?>
<?php echo get_partial('stInstallerWeb/menu_top');?>
<div id="frame_update">   
    <?php echo get_partial('stInstallerWeb/menu_home', array('selected' => 'webstore'));?>
    <div class="content">
    	<div class="content_update_box" style="width:100%;">
            <h2 class="title">Webstore</h2>
    		<h2 class="subhead_txt_module">
                <?php echo __('Informacje o pakiecie');?>
            </h2>
            <div class="package-info">
            	<ul>
            		<li>
            		    <span><?php echo __('Nazwa')?>:</span>
            		    <?php echo $info['name'];?>
    				</li>
            	</ul>
    			<div class="package-info-description">
                    <?php echo $info['description'];?>
    			</div>
            </div>
    		<div class="package-info-column-right">
    			<img class="package-info-image" src="http://www.sote.pl<?php echo $info['image'];?>" alt="<?php echo $info['name'];?>"/>
    			<?php
    			    if (!$installed) {
                        echo st_get_update_actions_head();
                        echo st_get_update_action('download', __('Pobierz'), 'stInstallerWeb/installPackage?package='.$name, 'post=false');
                        echo st_get_update_actions_foot();
    			    }
                ?>
                <?php if ($blocked && $installed):
                    echo st_get_update_actions_head();
                    echo st_get_update_action('add', __('Aktywuj'), 'stWebStore/activate?package='.$name, 'post=false');?>
                    <li class="st_admin-action-add" style="margin-left: 5px;"><div><div><a id="button_buy" target="_blank" style="background-image: url(/images/update/icons/icon_basket.gif)" href="<?php echo $info['url'];?>"><?php echo __('Kup');?></a></div></div></li>
                <?php echo st_get_update_actions_foot(); endif; ?>
    		</div>
            <div class="clear"></div>   
    	</div>
    </div> 
</div>
