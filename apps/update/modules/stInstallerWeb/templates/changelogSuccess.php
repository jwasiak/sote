<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php use_javascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype'); ?>
<?php use_helper('stUpdate') ?>

<?php echo get_partial('stInstallerWeb/menu_top');?>
<div id="frame_update"> 
        <?php echo get_partial('menu_home',array('selected'=>'syncList'));?>
        <div class="box_content">
            <div class="content_update_box">
                   <div style="float:right; margin-right:10px"><?php echo image_tag('/images/update/installerweb/arrow_down.png')?></div>
                   <h2 class="subhead_txt_module">
                        <?php echo __('Opis zmian aktualizacji');?> <?php // echo $active ?>
                   </h2>
                           
                   <?php if ($smarty_changed):?>
                   <?php echo __('W Twoim sklepie wykryto indywidualny temat graficzny:').' <b>'.$smarty_theme.'</b>.<br />'.__('Poniżej przedstawione pliki zostaną zarchiwizowane i napisane. Przeczytaj opis zmian.') ?>
                   <p />
                   <?php endif ?>
                          
                   <?php foreach ($output as $priority=>$content):?>
                         <?php if ($priority=='P1') $bgcolor='#FAAAAA'; else $bgcolor='#FFF';?>
                         <?php foreach ($content as $app=>$content2):?>                                                        
                            <div class="content_update_box" style="width:845px; margin-bottom: 10px; background-color: <?php echo $bgcolor ?>">
                              <div style="float:right">                      
                                 <span style="font-size:9px"><?php echo __('Aplikacja')?>:</span> <span style="font-size:12px"><?php echo $app;?></span>
                                 <?php if ($priority=='P1'):?>
                                     <br />
                                     <div style="float:right; margin-right:5px"><?php echo image_tag('/images/update/installerweb/icon_warning.png')?></div>
                                 <?php endif ?>
                              </div>
                              <div class="content_update_box" style="width:650px; margin-bottom: 0px; background-color: #fff">
                              <?php foreach ($content2['keyname'] as $keyname=>$content3): ?>
                                  <?php echo $content3['content'] ?>
                                  <?php if (! empty($content3['url'])):?>
                                      <div style="float:right">     
                                          <p />                         
                                          <a href="<?php echo url_for($content3['url']) ?>" target="update_info"><?php echo __('Więcej informacji') ?></a>
                                      </div>
                                  <?php endif ?>
                                  <p />
                              <?php endforeach ?>
                              <p />
                              <?php echo $content2['resume'] ?>
                              </div>
                  
                            </div>
                         <?php endforeach ?>           
                   <?php endforeach ?>   

                   <?php if ($smarty_changed):?>
                     <div class="content_update_box" style="width:845px; margin-bottom: 0px; background-color: #fff">
                        <?php echo "<b>".__('Lista zmienionych plików')."</b>"?>
                        <div style="float:right; margin-right:10px;"><?php echo link_to(__('Pobierz pliki'),'stInstallerWeb/backup?token='.$backup_token);?> 
                        <?php echo link_to(image_tag('/images/update/installerweb/icon_download.png'),'stInstallerWeb/backup?token='.$backup_token)?></div>
                        <ul>
                        <?php foreach ($smarty_files as $file): ?>
                           <li><?php echo $file ?></li>
                        <?php endforeach ?>
                        </ul>
                        

                     </div>
                   <?php endif ?>
                    <div class="clear"></div>
                   <?php if ($confirmation) :?>          
                       <div style="float:right; width=200px">
                             
                             <div style="float:right;">
                                <div class="form-error-msg" id="noconfirm-error" style="display:none; color: #FF3333">↓&nbsp;<?php echo __("Proszę zaakceptować zmiany")?>&nbsp;↓</div>
                                <?php echo __('Akceptuję opisane zmiany') ?> <?php echo checkbox_tag('confirm', 1, 0, array('onChange'=>'if ($("confirm").checked == false) {$("changelog_confirm_actions").style.display = "none";$("changelog_noconfirm_actions").style.display = "block";} else {$("changelog_confirm_actions").style.display = "block";$("noconfirm-error").style.display = "none"; $("changelog_noconfirm_actions").style.display = "none";}')); ?>
                             </div>            
                             <div id="changelog_confirm_actions" style="float:right;display:none; clear: both">
                              <?php echo st_get_update_actions_head('style="float:right";') ?>       
                              <?php echo st_get_update_action('install', __('Aktualizuj wszystkie'), 'stInstallerWeb/verify', 'post=true') ?>
                              <?php echo st_get_update_actions_foot() ?>        
                             </div>
                             <div id="changelog_noconfirm_actions" style="float:right; clear: both">
                              <?php echo st_get_update_actions_head('style="float:right";') ?>       
                              <?php echo st_get_update_action('install', __('Aktualizuj wszystkie'), null, array('type'=>'button', 'onClick'=>'$("noconfirm-error").style.display = "block";')) ?>
                              <?php echo st_get_update_actions_foot() ?>        
                             </div>

                       </div>
                   <?php else: ?>
                       <div style="float:right; width=200px">
                            <?php echo st_get_update_actions_head('style="float:right"') ?>       
                            <div style="float:right"><?php echo st_get_update_action('install', __('Aktualizuj wszystkie'), 'stInstallerWeb/verify', 'post=true') ?></div>
                            <div style="float:right; margin-right:30px"><?php echo input_hidden_tag('confirm', 1, 1); ?></div>
                            <?php echo st_get_update_actions_foot() ?>        
                          </div>    
                   <?php endif ?>
                    <div class="clear"></div>
              </div>
          
    </div>
</div>