<?php use_helper('stProgressBar')?>
<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator') ?>

<?php
$reference_cnt = 0;
if ($sf_params->get('force') == 'true' && !$sf_request->hasErrors())
{
    $sf_user->setAttribute('languages', $sf_params->get('language'), 'soteshop/stFixPositioning');
    $reference_cnt += $sf_params->get('seo_links[product]') && ($product_count = ProductPeer::doCount(new Criteria()));
    $reference_cnt += $sf_params->get('seo_links[category]') && ($category_count = CategoryPeer::doCount(new Criteria()));
    $reference_cnt += $sf_params->get('seo_links[productgroup]') && ($productgroup_count = ProductGroupPeer::doCount(new Criteria()));
    $reference_cnt += $sf_params->get('seo_links[webpage]') && ($webpage_count = WebpagePeer::doCount(new Criteria()));
    $reference_cnt += $sf_params->get('seo_links[producer]') && ($producer_count = ProducerPeer::doCount(new Criteria()));
    $reference_cnt += $sf_params->get('seo_links[blog]') && ($blog_count = BlogPeer::doCount(new Criteria()));
    $sf_user->setAttribute('reference_cnt', $reference_cnt, 'soteshop/stPositioningPlugin');
    if ($reference_cnt)
    {
        stLock::lock('frontend');
    }
}
?>

<?php 
echo st_get_admin_head('stPositioningPlugin', __('Generuj linki SEO'), '',array (
  0 => 'stLanguagePlugin',
  1 => 'stProduct',
  2 => 'stCategory',
  3 => 'stWebpagePlugin',
  4 => 'stProducer',
  5 => 'stBlogPlugin',
));

if ($related_object):
    st_include_component('stPositioningBackend', 'editMenu', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object, 'positioning' => null));
else:
    $related_object = PositioningPeer::retrieveByPk(1); 
    st_include_component('stPositioningBackend', 'editMenu', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object, 'positioning' => null));
endif;
;?>
    <div id="sf_admin_header">
    </div>
    
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message') ?>
        <?php if($sf_params->get('force') == 'true' && !$sf_request->hasErrors()): ?>
            <?php if(isset($product_count) && $product_count):  ?>
                <?php echo progress_bar('stPositioning_ProductUpdate', 'stFixPositioning', 'productUpdate', $product_count); ?>
            <?php endif; ?>
            <?php if(isset($category_count) && $category_count): ?>
                <?php echo progress_bar('stPositioning_CategoryUpdate', 'stFixPositioning', 'categoryUpdate', $category_count); ?>
            <?php endif; ?>
            <?php if(isset($productgroup_count) && $productgroup_count): ?>
                <?php echo progress_bar('stPositioning_ProductGroupUpdate', 'stFixPositioning', 'productGroupUpdate', $productgroup_count); ?>
            <?php endif; ?>
            <?php if(isset($webpage_count) && $webpage_count): ?>
                <?php echo progress_bar('stPositioning_WebpageUpdate', 'stFixPositioning', 'webpageUpdate', $webpage_count); ?>
            <?php endif; ?>
            <?php if(isset($producer_count) && $producer_count): ?>
                <?php echo progress_bar('stPositioning_ProducerUpdate', 'stFixPositioning', 'producerUpdate', $producer_count); ?>
            <?php endif; ?>
            <?php if(isset($blog_count) && $blog_count): ?>
                <?php echo progress_bar('stPositioning_BlogUpdate', 'stFixPositioning', 'blogUpdate', $blog_count); ?>
            <?php endif; ?>
        <?php else: ?>
        <?php echo form_tag('stPositioningBackend/rebuildSeoLinks?force=true');?>
            <div class="form-errors">
            <h2><?php echo __("Przywracanie domyślnych linków SEO")?></h2>
            <dl>
              <dt><?php echo __("Uwaga:")?></dt>
              <dd><?php echo __("Wykonanie funkcji przywracania domyślnych linków SEO, spowoduje utratę wcześniej wprowadzonych zmian w polach Przyjazny link dla produktów, grup produktów, kategorii oraz stron www i ustawienie wartości domyślnych.")?></dd>
            </dl>
            </div>
            <fieldset style="padding: 10px;">
                <div class="st_fieldset-content">
                    <div class="form-row">
                        <label><?php echo __('Przywróć przyjazne linki dla') ?>:</label>
                        <div class="content<?php if ($sf_request->hasError('seo_links')): ?> form-error<?php endif; ?>">
                        <?php if ($sf_request->hasError('seo_links')): ?>
                            <?php echo form_error('seo_links', array('class' => 'form-error-msg')) ?>
                        <?php endif; ?>
              
                        <ul>
                            <li><?php echo checkbox_tag('seo_links[product]',1, $sf_request->getParameter('seo_links[product]'));?><span style="padding-left: 10px;"><?php echo __("Produktów")?></span></li>
                            <li><?php echo checkbox_tag('seo_links[productgroup]',1, $sf_request->getParameter('seo_links[productgroup]'));?><span style="padding-left: 10px;"><?php echo __("Grupy produktów")?></span></li>
                            <li><?php echo checkbox_tag('seo_links[category]',1, $sf_request->getParameter('seo_links[category]'));?><span style="padding-left: 10px;"><?php echo __("Kategorie")?></span></li>
                            <li><?php echo checkbox_tag('seo_links[webpage]',1, $sf_request->getParameter('seo_links[webpage]'));?><span style="padding-left: 10px;"><?php echo __("Strony www")?></span></li>
                            <li><?php echo checkbox_tag('seo_links[producer]',1, $sf_request->getParameter('seo_links[producer]'));?><span style="padding-left: 10px;"><?php echo __("Producentów")?></span></li>
                            <li><?php echo checkbox_tag('seo_links[blog]',1, $sf_request->getParameter('seo_links[blog]'));?><span style="padding-left: 10px;"><?php echo __("Wpisów")?></span></li>
                        </ul>                
                        </div>                    
                        <br class="st_clear_all" />
                    </div>
                    <div class="form-row">
                        <label><?php echo __('Wybierz wersje językowe') ?>:</label>
                        <div class="content<?php if ($sf_request->hasError('language')): ?> form-error<?php endif; ?>">
                        <?php if ($sf_request->hasError('language')): ?>
                            <?php echo form_error('language', array('class' => 'form-error-msg')) ?>
                        <?php endif; ?>
                  
                        <ul>
                            <?php foreach (LanguagePeer::doSelectActive() as $lang): ?>
                                <li><?php echo checkbox_tag('language['.$lang->getId().']',1, $sf_request->getParameter('language['.$lang->getId().']'));?><span style="padding-left: 10px;"><?php echo $lang->getName() ?></span></li>
                            <?php endforeach ?>
                        </ul>                
                        </div>                    
                        <br class="st_clear_all" />
                    </div>
                </div>
            </fieldset>
            
        <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"');?>
            <?php echo st_get_admin_action('save', __('Generuj linki SEO'), null , array('name' => 'save'));?>
        <?php echo st_get_admin_actions_foot();?>
        <?php endif; ?>
    </div>
    
    <div id="sf_admin_footer">
    </div>
<br class="st_clear_all" />
<?php echo st_get_admin_foot() ?>