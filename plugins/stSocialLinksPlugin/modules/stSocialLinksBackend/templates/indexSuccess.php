<?php use_helper('I18N', 'stAdminGenerator', 'stJQueryTools') ?>
<?php echo st_get_admin_head('stSocialLinksPlugin', __('Konfiguracja'), array('culture' => $config->getCulture()), array('stAddThisPlugin')) ?> 
<?php use_stylesheet('backend/stSocialLinksPlugin.css'); ?>

<?php if ($sf_flash->has('notice')): ?>
    <div class="save-ok">
        <h2><?php echo $sf_flash->get('notice') ?></h2>
    </div>
<?php endif; ?>

<div id="sf_admin_content">
    <div id="sf_admin_content_config">
        <?php echo form_tag('stSocialLinksBackend/index?culture='.$config->getCulture(), array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form')) ?>
            <fieldset>
              <div class="st_fieldset-content" id="social_links">
                  <div class="form-row">
                    <?php echo label_for('sociallinks[enable]', __('Włącz linki społecznościowe'), array('style' => 'width: 220px')) ?>
                    <?php echo checkbox_tag('sociallinks[enable]',true,$config->get('enable')) ?>
                    <br class="st_clear_all" />
                  </div>
                  <div class="form-row">
                    <div class="label">   
                      <div class="label_text"><?php echo __('Facebook');?></div>
                      <img src="/images/backend/stSocialLinksPlugin/fb.png" width="24" height="24" class="label_image" />
                      <br class="st_clear_all" />
                    </div>
                    <?php echo input_tag("sociallinks[facebook]", $config->get('facebook', null, true),array("size"=>"60px"))?>
                    <br class="st_clear_all" />
                  </div>  
                  <div class="form-row">
                    <div class="label">   
                      <div class="label_text"><?php echo __('Twitter');?></div>
                      <img src="/images/backend/stSocialLinksPlugin/tweet.png" width="24" height="24" class="label_image" />
                      <br class="st_clear_all" />
                    </div>
                    <?php echo input_tag("sociallinks[twitter]", $config->get('twitter', null, true),array("size"=>"60px"))?>
                    <br class="st_clear_all" />
                  </div>
                  <div class="form-row">
                    <div class="label">   
                      <div class="label_text"><?php echo __('Youtube');?></div>
                      <img src="/images/backend/stSocialLinksPlugin/yt.png" width="24" height="24" class="label_image" />
                      <br class="st_clear_all" />
                    </div>
                    <?php echo input_tag("sociallinks[youtube]", $config->get('youtube', null, true),array("size"=>"60px"))?>
                    <br class="st_clear_all" />
                  </div>
                  <div class="form-row">
                    <div class="label">   
                      <div class="label_text"><?php echo __('Instagram');?></div>
                      <img src="/images/backend/stSocialLinksPlugin/instagram.png" width="24" height="24" class="label_image" />
                      <br class="st_clear_all" />
                    </div>
                    <?php echo input_tag("sociallinks[instagram]", $config->get('instagram', null, true),array("size"=>"60px"))?>
                    <br class="st_clear_all" />
                  </div>
                  <div class="form-row">
                    <div class="label">   
                      <div class="label_text"><?php echo __('Pinterest');?></div>
                      <img src="/images/backend/stSocialLinksPlugin/pinterest.png" width="24" height="24" class="label_image" />
                      <br class="st_clear_all" />
                    </div>
                    <?php echo input_tag("sociallinks[pinterest]", $config->get('pinterest', null, true),array("size"=>"60px"))?>
                    <br class="st_clear_all" />
                  </div>
                  <div class="form-row">
                    <div class="label">   
                      <div class="label_text"><?php echo __('Allegro');?></div>
                      <img src="/images/backend/stSocialLinksPlugin/allegro.png" width="24" height="24" class="label_image" />
                      <br class="st_clear_all" />
                    </div>
                    <?php echo input_tag("sociallinks[allegro]", $config->get('allegro', null, true),array("size"=>"60px"))?>
                    <br class="st_clear_all" />
                  </div>
                  <div class="form-row">
                    <div class="label">   
                      <div class="label_text"><?php echo __('Newsletter');?></div>
                      <img src="/images/backend/stSocialLinksPlugin/newsletter.png" width="24" height="24" class="label_image" />
                      <br class="st_clear_all" />
                    </div>
                    <div style="padding-top: 5px;"><?php echo checkbox_tag('sociallinks[newsletter]',true,$config->get('newsletter')) ?></div>
                    <br class="st_clear_all" />
                  </div>            
                </div>
            </fieldset>
            <?php echo st_get_admin_actions_head() ?>
                <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
            <?php echo st_get_admin_actions_foot() ?>
        </form>
    </div>
</div>
<br class="st_clear_all">
<?php echo st_get_admin_foot() ?>
