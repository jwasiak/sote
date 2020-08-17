<?php use_helper('Javascript') ?>
<div class="form-row" style="border: none;padding-left: 1px;">
  <?php echo image_tag('/plugins/sfAssetsLibraryPlugin/images/magnifier.png', 'align=top') ?>
  <?php echo link_to_function(
    __('Szukaj', null, 'sfAsset'),
    'document.getElementById("sf_asset_search").style.display="block"'
  ) ?> 
</div>

<?php echo form_tag('sfAsset/search', array('method' => 'get', 'id' => 'sf_asset_search', 'style' => 'display:none')) ?>
    <div style="border: none;padding-left: 1px;">
    <label for="search_params_rel_path"><?php echo __('Folder:', null, 'sfAsset') ?></label>
    <div class="content">
        <?php echo select_tag('search_params[path]', '<option></option>'.options_for_select(sfAssetFolderPeer::getAllPaths(), isset($search_params['path']) ? $search_params['path'] : null), 'style=width:200px') ?>
    </div>
  </div>

  <div style="border: none;padding-left: 1px;">
  <label for="search_params_name"><?php echo __('Nazwa pliku:', null, 'sfAsset') ?></label>
    <div class="content">
    <?php echo input_tag('search_params[name]', isset($search_params['name']) ? $search_params['name'] : null, 'size=20') ?>
    </div>
  </div>


  <div style="border: none;padding-left: 1px;">
    <label for="search_params_created_at"><?php echo __('Data modyfikacji:', null, 'sfAsset') ?></label>
    <div class="content">
    <?php echo input_date_range_tag('search_params[created_at]', isset($search_params['created_at']) ? $search_params['created_at'] : null, array (
  'rich' => true,
  'withtime' => true,
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
)) ?>
    </div>
  </div>

  <div style="border: none;padding-left: 1px;">
    <label for="search_params_description"><?php echo __('Opis:', null, 'sfAsset') ?></label>
    <div class="content">
    <?php echo input_tag('search_params[description]', isset($search_params['description']) ? $search_params['description'] : null, 'size=20') ?>
    </div>
  </div>

  <?php include_partial('sfAsset/search_custom', array('search_params' => isset($search_params) ? $search_params : array())) ?>

  <ul class="sf_admin_actions">
    <li><?php echo submit_tag(__('Szukaj', null, 'sfAsset'), 'name=search class=sf_admin_action_filter') ?></li>
  </ul>

</form>