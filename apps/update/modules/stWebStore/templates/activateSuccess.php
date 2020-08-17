<?php use_helper('stUpdate');?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1');?>
<?php use_stylesheet('/css/update/stWebStorePlugin.css?version=1');?>
<?php echo get_partial('stInstallerWeb/menu_top');?>
<div id="frame_update">   
    <?php echo get_partial('stInstallerWeb/menu_home', array('selected' => 'webstore'));?>
    <div class="content">
        <div class="content_update_box">
            <h2 class="title">Webstore</h2>
            <h2 class="subhead_txt_module">
                <?php echo __('Aktywacja pakietu');?> <?php echo $package;?>
            </h2>
            <?php if (!empty($error)):?>
                <div style="background-color: #FF3333; color: #fff; padding: 5px 20px 5px 10px; font-size: 11px; font-weight: bold"><?php echo __($error);?></div>
            <?php elseif (!empty($notice)):?>
                <div style="background-color: #73B65A; color: #fff; padding: 5px 20px 5px 10px; font-size: 11px; font-weight: bold"><?php echo __($notice);?></div>
            <?php endif;?>
            <?php echo form_tag('webstore/activate?package='.$package);?>
            <?php echo input_hidden_tag('activate', 1);?>
                <table style="width:32%;">
                    <tr>
                        <td><?php echo __('Kod aktywacji');?></td>
                        <td><?php echo input_tag('code', '');?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="button_add"><?php echo submit_tag(__('Aktywuj'));?></td>
                    </tr>
               </table>
           </form>       
        </div>
    </div>
    <div class="clear"></div>
</div>