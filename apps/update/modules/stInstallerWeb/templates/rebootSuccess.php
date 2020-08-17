
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php echo get_partial('menu_top');?>
<div id="frame_update">                       
    <?php echo get_partial('menu_home',array('selected'=>'rescue'));?>
    <div class="content">
      <div class="content_update_box">
        <h2 class="title"><?php echo __('Naprawa aktualizacji') ?></h2>
        
          <?php if ($linkToDownloadPackage):?>
            <div class="st_head_txt_installer_sync">
              <?php echo __('Pobieranie aktualizacji zostało przerwane i nie możliwa jest instalacja aktualizacji.');?>
            </div>
            <?php echo link_to(__('Ponów pobieranie aktualizacji'), 'stInstallerWeb/upgradeList');?>
          <?php else:?>       

            <?php
            /*
            // Debugowanie taskow, wywolania z wyswietleniem wyniku na stronie
            $browser = new sfWebBrowser();
            $browser->get("http://pear.soteshop/task_web.php",array('task'=>'cc'));
            $page=$browser->getResponseBody();

            echo "<pre>";echo $page;echo "</pre>";
            */
            ?>

            <?php if ($time): ?>
            	<?php $PBparams = array('reload_url'=>url_for('stInstallerWeb/rescueReboot',true), 'reload_time'=>30000);	?>
            <?php echo progress_bar('Installer', 'stInstallerTasksRescue', 'step', 15, $PBparams); ?>
            <?php else: ?>
              <?php echo __('Nie można wykonać instalacji, gdyż czas wykonania skryptu na serwerze jest zbyt krótki.');?><br />
              <?php echo __('Minimalny czas jaki jest wymagany do poprawnego wykonania instalacji to').'<b> '.$time_min.' '.__('sekund').'</b>.';?><br />
              <?php echo __("Maksymalny czas wykonania skryptu PHP na serwerze to").'<b> '.$time_server.' '.__('sekund').'</b>.'; ?>
              <?php echo '<br /><br />'.__("Jak zmienić czas wykonywania na serwerze:").'<br />';?><?php echo link_to('http://www.sote.pl/noc/wiki/max_execution_time','http://www.sote.pl/noc/wiki/max_execution_time', array('popup' => array('sote.pl')))?>
          <?php endif; ?>
        <?php endif; ?>
      </div> 
    </div>
    <div class="st_clear_all"></div>
</div>

