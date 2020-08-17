<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1');?>
<?php if($iframe == true):?>
    <html>
        <body style="background-color: #fff;">
            <?php phpinfo();?>
        </body>
    </html>
<?php else:?>
    <?php echo get_partial('stInstallerWeb/menu_top');?>
    <div id="frame_update"> 
        <?php echo get_partial('stInstallerWeb/menu_tools', array('selected' => 'devel'));?>
        <div class="box_content">
            <h2 class="title"><?php echo __('Tryb developerski', null, 'stInstallerWeb');?></h2>
            <h2 class="subhead_txt_module"><?php echo __('PHPINFO');?></h2>
            <div class="content_update_box">
                <iframe src="<?php echo $iframe_uri;?>" width="888" height="600" style="border: 1px solid #ddd; margin-bottom: 10px;">
                    <p>Your browser does not support iframes.</p>
                </iframe>
            </div>
        </div>
        <div class="clear"></div>
    </div>
<?php endif;?>
