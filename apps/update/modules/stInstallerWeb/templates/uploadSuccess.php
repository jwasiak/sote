<?php use_helper('I18N', 'Validation');?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1');?>
<?php echo get_partial('menu_top');?>
<div id="frame_update">
    <?php echo get_partial('menu_home', array('selected' => 'upload'));?>
    <div class="content">
        <div class="content_update_box">
            <h2 class="title"><?php echo __('Dodaj', null, 'stInstallerWeb');?></h2>
            <h2 class="subhead_txt_module">
                <?php echo __('Załączanie pakietów aktualizacji');?>
            </h2>
            <?php if (!empty($error)):?>
                <div style="background-color: #FF3333; color: #fff; padding: 5px 20px 5px 10px; font-size: 11px; font-weight: bold; margin-bottom: 10px; width: 324px;"><?php echo __($error);?></div>
            <?php elseif (!empty($notice)):?>
                <div style="background-color: #73B65A; color: #fff; padding: 5px 20px 5px 10px; font-size: 11px; font-weight: bold; margin-bottom: 10px; width: 324px;"><?php echo __($notice);?></div>
            <?php endif;?>
            <?php echo form_tag('installerweb/upload', 'multipart=true');?>
                <table style="width: 40%;" class="add_table">
                    <tr>
                        <td><?php echo __('Załącz pakiet');?></td>
                        <td><?php echo input_file_tag('upload[file]', '');?></td>
                    </tr>
                    <tr>
                        <td><?php echo __('Kod aktywacji');?></td>
                        <td><?php echo input_tag('upload[code]', '');?></td>
                    </tr>
                    <?php if (SF_ENVIRONMENT == 'dev'):?>       
                        <tr>
                            <td><?php echo __('Ignoruj zależności (nodeps)');?></td>
                            <td><?php echo checkbox_tag('upload[nodeps]', 1, true);?></td>
                        </tr>
                        <tr>
                            <td><?php echo __('Wymuś instalację (force)');?></td>
                            <td><?php echo checkbox_tag('upload[forced]', 1, true);?></td>
                        </tr>
                    <?php else:?>
                        <?php echo input_hidden_tag('upload[nodeps]', 0);?>
                        <?php echo input_hidden_tag('upload[forced]', 0);?>
                    <?php endif;?>
                    <tr>
                        <td></td>
                        <td><div class="button_add"><?php echo submit_tag(__('Załącz', null, 'stInstallerWeb'));?></div></td>
                    </tr>
               </table>
           </form>
           <?php if (SF_ENVIRONMENT == 'dev') echo 'CONTENT: '.$content;?>
        </div>
    </div>
    <div class="clear"></div>
</div>

