<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'stAdminGenerator') ?>

<?php st_include_partial('stBlogBackend/header', array('related_object' => null, 'title' => __('Meta tagi listy bloga', 
array(), 'stBlogBackend'), 'culture' => $config->getCulture(), 'route' => 'stBlogBackend/positioning')) ?>

<?php st_include_component('stBlogBackend', 'configMenu') ?>
  
<div id="sf_admin_content">
       <?php if ($sf_flash->has('notice')): ?>
        <div class="save-ok">
            <h2><?php echo $sf_flash->get('notice') ?></h2>
        </div>
    <?php endif; ?>

    <div id="sf_admin_content_config">
        <?php echo form_tag('stBlogBackend/positioning?culture='.$config->getCulture(), array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form', 'class' => 'admin_form'));?>
            
            <fieldset>
            		<div class="st_fieldset-content">
               		<div class="form-row">
               		<label for="positioning_title">
     				 <?php echo __('Tytuł strony', array(), 'stPositioningBackend'); ?> <a href="#" class="help" title="<?php echo htmlspecialchars(__('Tytuł należy zmieścić w około 65-75 znakach wraz ze spacjami.', null, 'stPositioningBackend')) ?>"></a></label>
     				<div><?php echo input_tag('positioning[title]', $config->get('title', null, true), array('size'=>'68', 'class'=>'input')) ?></div>
     				<div class="st_clear_all"></div>
               		</div>
                    
                    <div class="form-row">
                         <label for="positioning_description"><?php echo __('Opis strony', array(), 'stPositioningBackend'); ?> <a href="#" class="help" title="<?php echo htmlspecialchars(__('Opis strony powinien mieć mniej niż 160 znaków ze spacjami.', null, 'stPositioningBackend')) ?>"></a></label>
                          <?php echo textarea_tag('positioning[description]', $config->get('description', null, true), array('size'=>'65x3')); ?> 
                    </div>

                    <div class="form-row">
                    <label for="positioning_keywords"><?php echo __('Słowa kluczowe', array(), 'stPositioningBackend'); ?> <a href="#" class="help" title="<?php echo htmlspecialchars(__('Słowa kluczowe powinny być oddzielone przecinkiem. Przykład: słowo, słowo, słowo', null, 'stPositioningBackend')) ?>"></a></label>
                     <?php echo textarea_tag('positioning[keywords]', $config->get('keywords', null, true), array('size'=>'65x2')); ?> 
                    </div>

                    </div>
            </fieldset>
             <?php echo st_get_admin_actions_head() ?>
             <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
            <?php echo st_get_admin_actions_foot() ?>
        </form>
</div>
    

<?php st_include_partial('stBlogBackend/footer', array('related_object' => null)) ?>