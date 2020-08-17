<?php use_helper('stUpdate') ?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php echo get_partial('menu_top');?>
<div id="frame_update">     
  <?php echo get_partial('menu_home',array('selected'=>'syncList'));?>
  <div class="content">
      <div class="content_update_box">
        <h2 class="title"><?php echo __('Instaluj', null, 'stInstallerWeb');?></h2>
        <?php if ($linkToDownloadPackage):?>
            <h2 class="subhead_txt_module">
                <?php echo __('Pobieranie aktualizacji zostało przerwane i nie możliwa jest instalacja aktualizacji.');?>
            </h2>
            <?php echo link_to(__('Ponów pobieranie aktualizacji'), 'stInstallerWeb/upgradeList');?>
        <?php else:?>
            <?php if (!empty($apps['all'])):?>
                <div style="float:left">
                    <h2 class="subhead_txt_module">
                        <?php echo __('Instalacja aktualizacji');?>
                    </h2>
                </div>

                <div style="float:right" class="button_top">
                    <?php echo st_get_update_actions_head('style="float:right"') ?>
                    <?php echo st_get_update_action('install', __('Instaluj wszystkie'), 'stInstallerWeb/changelog', 'post=true') ?>
                    <?php echo st_get_update_actions_foot() ?>
                </div>
                
                <div class="st_clear_all"></div>

                <?php if (!empty($apps)): ?>
                    <?php echo get_partial('sync_list',array("apps"=>$apps));?>
                <?php endif;?>
                
                <div style="float:right">
                    <?php echo st_get_update_actions_head('style="float:right"') ?>
                    <?php echo st_get_update_action('install', __('Instaluj wszystkie'), 'stInstallerWeb/changelog', 'post=true') ?>
                    <?php echo st_get_update_actions_foot() ?>
                </div>

            <?php else:?>
                <div>
                    <h2 class="subhead_txt_module">
                        <?php echo __('Nie ma pobranych aktualizacji do instalacji.')?>
                    </h2>
                </div>
            <?php endif;?>
        <?php endif;?>
        <div class="clear"></div>
      </div>
    </div>
</div>