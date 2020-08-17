<?php use_helper('stUpdate') ?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php use_stylesheet('/css/update/stDevel.css?version=1'); ?>
<?php echo get_partial('menu_top');?>
<div id="frame_update">                       
    <?php echo get_partial('menu_tools',array('selected'=>'none'));?>
    <div class="content">
      <div class="content_update_box">
        <h2 class="subhead_txt_module"><?php echo __('Zmiana trybu pracy sklepu') ?></h2>                    
          <?php echo form_tag('installerweb/pearstate', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form'));?>
             <div class="main" style="padding:10px 0px;">
                 <div class="row">
                     <div class="column" id="info1">
                          <?php echo __('Uwaga')?>!                       
                          <i style="font-size:13px; padding-top:5px;"><?php echo __('Włączanie trybu beta nie jest zalecane dla sklepów produkcyjnych!')?></i>
                     </div>
                 </div>       
                 <div class="row pearstate_row">               
                     <div style="font-weight:bold; padding-bottom:10px;"><?php echo __('Tryb pracy');?>:</div>
                     <div class="st_clear_all"></div>
                     <span style="float:left; width:150px;"><?php echo __('wersja stabilna (stable)') ?></span><?php echo radiobutton_tag('pear[state]', 'stable', $isStable) ?>
                     <div class="st_clear_all" style="padding:5px 0px;"></div>
                     <span style="float:left; width:150px;"><?php echo __('wersja testowa (beta)') ?></span><?php echo radiobutton_tag('pear[state]', 'beta', !$isStable) ?>
                 </div>
                 <div id="pearstate_buttons">
                     <?php echo st_get_update_actions_head('style="float:left"') ?>
                     <?php echo st_get_update_action('save', __('Zapisz')) ?>
                     <?php echo st_get_update_actions_foot() ?>
                 </div>
             </div>
          </form>
      </div>
    </div>
</div>
