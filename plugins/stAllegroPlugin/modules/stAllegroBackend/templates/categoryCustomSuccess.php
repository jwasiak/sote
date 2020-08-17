<?php use_helper('stAdminGenerator', 'stProgressBar', 'stUrl', 'stAllegro');?>
<?php use_stylesheet('backend/stProgressBarPlugin/stProgressBarPlugin.css');?>
<?php use_stylesheet('backend/stAllegroPlugin.css');?>
<?php st_include_partial('stAllegroBackend/header', array('related_object' => $related_object, 'title' => __('Pobieranie kategorii Allegro'), 'culture' => null, 'route' => 'stAllegroBackend/categoryCustom'));?>
<?php st_include_component('stAllegroBackend', 'configMenu', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object));?>
  
<div id="sf_admin_content" style="padding: 10px;">
    <?php st_include_partial('stAllegroBackend/custom_messages', array('forward_parameters' => $forward_parameters)) ?>
    <div class="admin_form">
        <?php foreach ($environments as $environment):?>
            <?php if($environment['config']['enabled']):?>
                <fieldset>
                    <h2><?php echo __($environment['name']);?></h2>
                    <div class="content">
                        <?php if (stAllegro::getInstance($environment['environment'])->testConnection()):?>
                            <div class="row">
                                <?php if ($environment['config']['api_key']):?>
                                    <div id="progres-bar-<?php echo __($environment['htmlEnvironment']);?>">
                                        <div class="st-allegro-category-status">
                                            <?php echo st_allegro_show_category_status($environment['category']);?>
                                        </div>
                                        <input id="category-download-<?php echo __($environment['htmlEnvironment']);?>" type="button" value="<?php echo __("Pobierz kategorie");?>" style="background-image: url(/images/backend/icons/add.png);padding-left: 30px; padding-top: 5px;"/>
                                    </div>
                                <?php else:?>
                                    <div>
                                        <?php echo __('Przed przystąpieniem do importu kategorii należy');?> 
                                        <?php echo st_link_to(__('uzupełnić konfigurację'), 'stAllegroBackend/config');?>.
                                    </div>
                                <?php endif;?>
                                <div class="clr"></div>
                            </div>
                        <?php else:?>
                            <div class="row">
                                <?php echo __('Wystąpił problem w połączeniu z API.', null, 'stAllegroBackend');?>
                            </div>
                        <?php endif;?>
                    </div>
                </fieldset>
            <?php endif;?>
        <?php endforeach;?>
    </div>
</div>

<script type="text/javascript" language="javascript">
    jQuery(function($) {
        $(document).ready(function() {
            <?php foreach ($environments as $environment):?>
                $('#category-download-<?php echo __($environment['htmlEnvironment']);?>').click(function() {
                    $.ajax({ url: "<?php echo st_url_for('allegro/getCategories');?>?environment=<?php echo __($environment['htmlEnvironment']);?>", cache: false }).done(function(html) {
                        $("#progres-bar-<?php echo __($environment['htmlEnvironment']);?>").html(html);
                    });
                });
            <?php endforeach;?>
        });
    });
</script>
    
<?php st_include_partial('stAllegroBackend/footer', array('related_object' => null, 'forward_parameters' => $forward_parameters));?>
