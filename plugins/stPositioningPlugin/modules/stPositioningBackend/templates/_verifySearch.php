<?php if ($sf_flash->has('notice')):?>
    <div class="save-ok">
        <h2><?php echo __($sf_flash->get('notice'));?></h2>
    </div>
<?php endif;?>
<div id="sf_admin_content_config">
<?php echo form_tag('stPositioningBackend/verifySearchCustom', array('enctype'=>'multipart/form-data', 'class'=> 'admin_form'));?>

 

<fieldset>
	<h2><?php echo __('Zweryfikuj własność witryny plikiem') ?></h2>
	<div id="sf_fieldset_none_slide">
    <div class="form-row" style="padding: 10px 0px; text-align: center;">
        <?php echo __('Plik do pobrania');?>: Google - <a href="https://www.google.com/webmasters/tools/" target="_blank">https://www.google.com/webmasters/tools/</a>, Yahoo/Bing - <a href="http://www.bing.com/toolbox/webmaster/" target="_blank">http://www.bing.com/toolbox/webmaster/</a> <?php echo __('oraz');?> Yandex - <a href="https://webmaster.yandex.com/" target="_blank">https://webmaster.yandex.com/</a></li>
        </ul>
    </div> 
	<div class="form-row">
            <label><?php echo __('Dodaj plik') ?>:</label>
            <div class="content">
                <?php if ($sf_request->hasError('verify{file}')): ?>
                    <div class="error_field" style="color: red;">
                        <?php echo form_error('verify{file}', array('class' => 'form-error-msg')) ?>
                        <?php echo input_file_tag('verify[file]', 'verify_file') ?><br />
                    </div>
                <?php else: ?>
                    <?php echo input_file_tag('verify[file]', 'verify_file') ?><br />
                <?php endif;?> 
            <?php if ($added_files): ?>
            <p style="padding: 5px 5px 0px;">
            <?php echo __('Pliki weryfikacyjne') ?>:
            <ul>
             <?php foreach ($added_files as $added_file):?>
                <li style="padding: 2px;">
                <?php 
                if(strpos($added_file, "google")!== false){
                    $ico = "google";
                }elseif(strpos($added_file, "yandex")!== false){
                    $ico = "yandex";
                }elseif(strpos($added_file, "BingSiteAuth")!== false){
                    $ico = "bing";
                }
                ?>

                <img src="/images/backend/stPositioningPlugin/<?php echo $ico;?>_icon.png" width="16" height="16" style="position: relative;
top: 3px;">
                <span><?php echo $added_file;?></span>
                <?php echo link_to(image_tag('backend/icons/delete.gif', array('alt' => __('delete'), 'title' => __('delete'), 'style'=> "position: relative; top: 3px; padding-left: 3px;")), 'stPositioningBackend/removeFile?del='.$added_file, array (
      'post' => true,
      'confirm' => __('Potwierdź usuniecie pliku?', null, 'stPositioningBackend'),
)) ?>
                </li>
             <?php endforeach; ?>
             </ul>
            </div>
            </p>
            <?php endif;?>
        </div>

	</div>
</fieldset>
<?php if ($domains){ ?>
<fieldset>
	<h2><?php echo __('Meta Tag Google - metoda alternatywna');?></h2>
   <div class="form-row" style="padding: 10px 10px 10px 140px;">
        <?php echo __('Meta tag znajdziesz w');?> Google
        <a href="https://www.google.com/webmasters/tools/" target="_blank"> - https://www.google.com/webmasters/tools/</a>
    </div> 
    <div class="form-row">
                    <label><?php echo __('Wpisz kod z meta tag') ?>:</label>
                    <div class="content<?php if ($sf_request->hasError('verify{verify}')): ?> form-error<?php endif; ?>">
                    <?php if ($sf_request->hasError('verify{verify}')): ?>
                        <?php echo form_error('verify{verify}', array('class' => 'form-error-msg')) ?>
                    <?php endif; ?>
                    <ul>
                        <?php foreach ($domains as $domain):?>
                            <li><?php echo __('Dla domeny:').' '.st_external_link_to("http://".$domain->getDomain()."/","http://".$domain->getDomain()."/")?><br />
                            <div style="margin-top: 5px; float: left;">&lt;meta name="google-site-verification" content="</div>
                            <div style="float: left;"><?php echo input_tag('verify[verify]['.$domain->getDomain().']', @$domainsVerify[$domain->getDomain()] , array('size'=>55))?>
                            </div>
                            <div style="margin-top: 5px; float: left;">"&gt;</div>
                            <div class="st_clear_all" /></div>
                        </li>
                        <?php endforeach; ?>
                            
                    </ul>    
                    </div>
                    <br class="st_clear_all" />
                </div>
</fieldset>
<?php } ?>
    <?php echo st_get_admin_actions_head() ?>
        <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
    <?php echo st_get_admin_actions_foot() ?>

</form>
</div>
