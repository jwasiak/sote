<div style="margin:10px;">
    
    <img src="<?php echo $imgPath; ?>" style="max-width: 300px; min-width: 25px; max-height: 100px; min-height: 25px; border: 1px dotted red;" >
    <br/>
    <?php echo form_tag('stThemeFrontend/saveCss','post'); ?>
    
    <?php echo radiobutton_tag('modSize', '1', true) ?><?php echo __('Dopasuj wielkość obrazu do elementu strony.'); ?><br/>
    <?php echo radiobutton_tag('modSize', '2', false) ?><?php echo __('Dopasuj wielkość elementu strony do obrazu.'); ?><br/>
    
        
    <div id="extendEdit" style="display:none;">
    <?php print $element[2]; ?><br/>
    <?php echo __('Selektor'); ?>:&nbsp;<?php print $element[1]; ?><br/>
    <?php echo __('definicja stylu'); ?>:&nbsp;<br/>
    <?php echo textarea_tag('cssContent', $cssExtendContent, 'size=80x10') ?><br/>
    </div>
    
    <?php echo input_hidden_tag('filename', $fileName); ?>
    <?php echo input_hidden_tag('element[0]',$element[0]) ?>
    <?php echo input_hidden_tag('element[1]',$element[1]) ?>
    <?php echo input_hidden_tag('element[2]',$element[2]) ?>
    <?php echo input_hidden_tag('element[3]',$element[3]) ?>
    <?php echo input_hidden_tag('element[4]',$element[4]) ?>
    <?php echo input_hidden_tag('imgPropertis[0]',$imgPropertis[0]) ?>
    <?php echo input_hidden_tag('imgPropertis[1]',$imgPropertis[1]) ?>
    
    </br>
    <div class="st_button st_align-left">
            <div class="st_button-left">
                <?php echo submit_tag(__('Zapisz zmiany')) ?>
            </div>
        </div>
    
    </form>
    
</div>
