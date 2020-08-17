<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php echo get_partial('stInstallerWeb/menu_top');?>
<div id="frame_update"> 
  <?php echo get_partial('menu_home',array('selected'=>'syncList'));?>
  <div class="content">
      <h2 class="title"><?php echo __('Instaluj', null, 'stInstallerWeb');?></h2>
      <div class="content_update_box">
        <?php if ($linkToDownloadPackage):?>
            <h2 class="subhead_txt_module">
                <?php echo __('Pobieranie aktualizacji zostało przerwane i nie możliwa jest instalacja aktualizacji.');?>
            </h2>
            <?php echo link_to(__('Ponów pobieranie aktualizacji'), 'stInstallerWeb/upgradeAllBySteps');?>
        <?php else:?>
            <?php if (sizeof($apps)>0):?>
              <?php echo progress_bar('Verify', 'stAppVerify', 'step', $npkg);?>
              <?php $peari = new stPearInfo();?>
            <?php endif;?>
        <?php endif;?>
      </div>
      <div class="st_clear_all"></div>
    </div>
</div>
