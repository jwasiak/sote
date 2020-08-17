<?php use_helper('stAdminGenerator', 'stLanguageBackend');?>
<?php st_include_partial('stLanguageBackend/header', array('related_object' => $related_object, 'title' => __('Lista definicji językowych'), 'route' => 'stLanguageBackend/translationList'));?>
<?php st_include_component('stLanguageBackend', 'editMenu', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object));?>

<div id="sf_admin_content">
    <?php st_include_partial('stLanguageBackend/list_messages', array('forward_parameters' => $forward_parameters));?>

    <div style="display: table; width: 100%;">

        <?php echo form_tag('stLanguageBackend/translationList?id='.$forward_parameters['id'], array('id' => 'filter_list_form', 'class' => 'admin_form'));?>
            <div class="list_filters">
                <ul class="header">
                    <li>
                        <?php echo label_for('filters[catalogue]', __('Katalog tłumaczeń'));?>
                        <?php echo select_tag('filters[filter_catalogue]', options_for_select(array_merge(array('NONE' => __('---')), $catalogues), isset($filters['filter_catalogue']) ? $filters['filter_catalogue'] : 'NONE'));?>       
                    </li>
                    <li>
                        <?php echo label_for('filters[filter_phrase]', __('Fraza'));?>
                        <?php echo input_tag('filters[filter_phrase]', isset($filters['filter_phrase']) ? $filters['filter_phrase'] : null, array('size' => 40));?>  
                    </li>
                    <li>
                        <?php echo label_for('filters[filter_phrase_user]', __('Tłumaczenie w sklepie'));?>
                        <?php echo input_tag('filters[filter_phrase_user]', isset($filters['filter_phrase_user']) ? $filters['filter_phrase_user'] : null, array('size' => 40));?>  
                    </li>
                    <li>
                        <input type="submit" value="<?php echo __('Filtruj', null, 'stAdminGeneratorPlugin') ?>" style='background-image: url("/images/backend/beta/icons/16x16/search.png"); cursor: pointer; background-repeat: no-repeat; background-position: 5px center; background-color: #eee; line-height: 18px; min-height: 26px; padding: 3px 5px box-sizing: padding-box; -webkit-box-sizing:padding-box; -moz-box-sizing: padding-box; -ms-box-sizing: padding-box; margin-left: 10px; padding-left: 30px; padding-top: 5px; margin-top: -3px;' />
                    </li>
                    <?php if ($filters):?>
                        <li>
                            <input type="image" src="/images/backend/beta/icons/16x16/remove.png" onclick="this.form.action += '?filters_clear=1'" style="" />
                        </li>  
                    <?php endif;?>
                </ul>
                <div class="clr"></div>
            </div>
        </form>
        <div id="record_list_form">
            <table cellspacing="0" cellpadding="0" class="st_record_list record_list">
                <thead>
                    <tr>
                        <th width="1%">&nbsp;</th>
                        <th><?php echo __('Katalog tłumaczeń');?></th>
                        <th><?php echo __('Fraza');?></th>
                        <th><?php echo __('Tłumaczenie w sklepie');?></th>
                        <th width="1%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0;?>
                    <?php if($phrases):?>
                        <?php foreach ($phrases as $module => $translations):?>
                            <?php foreach ($translations as $index => $phrase):?>
                                    <tr<?php if($i%2) echo ' class="highlight"';?>>
                                        <td>
                                            <ul class="st_object_actions">
                                                <li>
                                                    <a href="<?php echo url_for('stLanguageBackend/translationEdit?id='.$related_object->getId().'&index='.$module.'_'.$index);?>">
                                                        <img src="/images/backend/beta/icons/16x16/edit.png" title="<?php echo __('edit') ?>" class="tooltip" />
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                        <!-- <td><?php echo $index;?></td> -->
                                        <td><?php echo $module;?></td>
                                        <td><?php echo st_language_colorize_phrase($phrase['phrase'], (isset($filters['filter_phrase']) ? $filters['filter_phrase'] : null), 75);?></td>
                                        <!-- <td><?php echo st_language_truncate_phrase($phrase['shop'], 75);?></td> -->
                                        <td>
                                            <?php echo st_language_colorize_phrase(isset($phrase['user']) ? $phrase['user'] : $phrase['shop'], (isset($filters['filter_phrase_user']) ? $filters['filter_phrase_user'] : null), 75);?>
                                        </td>
                                        <td>
                                            <?php if (isset($phrase['cache'])):?>
                                                <img src="/images/backend/beta/icons/16x16/info.png" title="<?php echo __('Zmieniono na');?>:<br /><?php echo $phrase['cache'];?>" class="cache_phrase"/>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                <?php $i++;?>
                            <?php endforeach;?>
                        <?php endforeach;?>
                    <?php elseif(empty($filters)):?>
                        <tr>
                            <td colspan="4"><?php echo __('Wybierz katalog tłumaczeń lub wyszukaj tekst');?></td>
                        </tr>
                    <?php else:?>
                        <tr>
                            <td colspan="4"><?php echo __('Brak rekordów - zmień kryteria wyszukiwania');?></td>
                        </tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="clr"></div>
</div>
<?php if($hasTranslationCache):?>
    <div id="edit_actions">
        <ul class="admin_actions" style="float: right">
            <li class="action-list">
                <input type="button" onclick="document.location.href='<?php echo url_for('stLanguageBackend/translationCacheList?id='.$related_object->getId());?>';" value="<?php echo __('Zobacz zmiany');?>" style="background-image: url(/images/backend/icons/list.png)" name="list">
            </li>
            <li class="action-save">
                <input type="button" onclick="document.location.href='<?php echo url_for('stLanguageBackend/generateXliff?id='.$related_object->getId());?>';" value="<?php echo __('Zastosuj zmiany');?>" style="background-image: url(/images/backend/icons/save.png)" name="list">
            </li>
        </ul>
        <div class="clr"></div>
    </div>
<?php endif;?>

<?php st_include_partial('stLanguageBackend/footer', array('related_object' => $related_object)) ?>

<script type="text/javascript">
   jQuery(function($) {
      $(document).ready(function() {
        $('.cache_phrase').tooltip({"tip":"#jquery_tooltip_99f16cbaa67629aa1ab4816a6434e156","delay":0,"position":"center left","offset":[0,10]});
        $('#edit_actions').stickyBox();
      });
   });
</script>
