<div style="margin:10px;">
    
    <div style="max-width: 300px; min-width: 25px; max-height: 100px; min-height: 25px; border: 1px dotted red;">
    <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" WIDTH="300" HEIGHT="50">
    <PARAM NAME=movie VALUE="/images/frontend/theme/<?php echo $theme ?>/<?php echo $fileName ?>"><PARAM NAME=quality VALUE=best>
    <EMBED src="/images/frontend/theme/<?php echo $theme ?>/<?php echo $fileName ?>" quality=best WIDTH="300" HEIGHT="50" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED>
    </OBJECT>
    </div>

    
    <?php echo form_tag('stThemeFrontend/saveSwf','post'); ?>
    
    <?php echo input_tag('sizeW', '985', array("size"=>"3")) ?><?php print __("Szerokość:"); ?><br/>
    <?php echo input_tag('sizeH', '199', array("size"=>"3")) ?><?php print __("Wysokość:"); ?><br/>
        
    <?php echo input_hidden_tag('filename', $fileName); ?>
    <?php echo input_hidden_tag('element', $element); ?>
    
    </br>
    <div class="st_button st_align-left">
            <div class="st_button-left">
                <?php echo submit_tag(__('Zapisz zmiany')) ?>
            </div>
        </div>
    
    </form>
    
</div>