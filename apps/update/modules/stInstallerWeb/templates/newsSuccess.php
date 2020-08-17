<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1');?>
<?php if ($sf_user->isAuthenticated()):?>
    <?php echo get_partial('menu_top');?>
<?php endif;?>
<div id="frame_update">
    <?php echo get_partial('menu_home', array('selected' => 'news'));?>
    <div id="status_box">
        <span><?php echo image_tag('update/red/icons/indicator-big.gif');?></span>
    </div>

    <?php echo javascript_tag(
        remote_function(array(
            'update'  => 'status_box',
            'url'     => 'stInstallerWeb/ajaxHomepageStatus',
        ))
    );?>
    <script type="text/javascript">
        jQuery(function($) {
            $(document).ready(function() {   
                $.post('/update.php/communication/check');
            });
        });
    </script>
    <div class="st_clear_all"></div>
</div>