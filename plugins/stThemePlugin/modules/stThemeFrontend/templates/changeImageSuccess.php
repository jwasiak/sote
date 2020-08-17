<div style="margin:10px;">

    <?php if($resetElement==1): ?>
    <?php echo form_tag('stThemeFrontend/setDefault','post'); ?>
    
    <?php echo input_hidden_tag('element',$element[1]) ?>
        <div class="st_button st_align-left">
            <div class="st_button-left">
                <?php echo submit_tag(__('Przywróć pierwotny obraz tego elementu.')) ?>
            </div>
        </div>
    
    <?php if($baner): ?>
        <br class="st_clear_all" />
        <div style="max-width: 300px; min-width: 25px; max-height: 100px; min-height: 25px; border: 1px dotted red;">
        <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" WIDTH="300" HEIGHT="50">
        <PARAM NAME=movie VALUE="<?php echo $banerPath; ?>"><PARAM NAME=quality VALUE=best><PARAM NAME=wmode VALUE=transparent>
        <EMBED wmode="transparent" src="<?php echo $banerPath; ?>" quality=best WIDTH="300" HEIGHT="50" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED>
        </OBJECT>
        </div>
        <?php echo input_hidden_tag('baner',1) ?>
        
    <?php endif; ?>
    
    </form>
    <br class="st_clear_all" />
    <?php endif; ?>
        
    <?php if(!$baner): ?>
    <img src="<?php echo $element[3]; ?>" style="max-width: 300px; min-width: 25px; max-height: 100px; min-height: 25px; border: 1px dotted red;" >
    <?php else: ?>
        
    <?php endif; ?>
    <br/>
    <?php if($resetElement==1 && !$baner): ?>
    <?php echo form_tag('stThemeFrontend/modCss','post'); ?>
    
    <?php echo input_hidden_tag('element[0]',$element[0]) ?>
    <?php echo input_hidden_tag('element[1]',$element[1]) ?>
    <?php echo input_hidden_tag('element[2]',$element[2]) ?>
    <?php echo input_hidden_tag('element[3]',$element[3]) ?>
    <?php echo input_hidden_tag('element[4]',$element[4]) ?>
    <?php echo input_hidden_tag('filename',$element[4]) ?>
    
    
        <div class="st_button st_align-left">
            <div class="st_button-left">
                <?php echo submit_tag(__('Edytuj właściwości obrazu.')) ?>
            </div>
        </div>
    </form>
    <br class="st_clear_all" />
    <?php endif; ?>
    
    <?php if(!$baner): ?>
    
    <?php echo form_tag('stThemeFrontend/changeImage','post'); ?>
    
    <?php echo input_hidden_tag('element[0]',$element[0]) ?>
    <?php echo input_hidden_tag('element[1]',$element[1]) ?>
    <?php echo input_hidden_tag('element[2]',$element[2]) ?>
    <?php echo input_hidden_tag('element[3]',$element[3]) ?>
    <?php echo input_hidden_tag('element[4]',$element[4]) ?>
    <?php echo input_hidden_tag('download',1) ?>
    
    
        <div class="st_button st_align-left">
            <div class="st_button-left">
                <?php echo submit_tag(__('Pobierz ten obraz na mój komputer.')) ?>
            </div>
        </div>
        <br class="st_clear_all" />
    </form>
    <?php endif; ?>
    <?php if(!$baner): ?>
    <br>
    <?php echo __('Wybierz plik graficzny na lokalnym komputerze, który ma zostać wstawiony w ten element strony.') ?>
    <?php echo form_tag('stThemeFrontend/UploadFile','multipart=true'); ?>
    <?php echo input_file_tag('filename', 'filename'); ?>
        
        <div class="st_button st_align-left">
            <div class="st_button-left">
                <?php echo submit_tag(__('Załaduj')) ?>
            </div>
        </div>
    
    <?php echo input_hidden_tag('element[0]',$element[0]) ?>
    <?php echo input_hidden_tag('element[1]',$element[1]) ?>
    <?php echo input_hidden_tag('element[2]',$element[2]) ?>
    <?php echo input_hidden_tag('element[3]',$element[3]) ?>
    <?php echo input_hidden_tag('element[4]',$element[4]) ?>
        
    </form>
    <?php endif; ?>                
</div>