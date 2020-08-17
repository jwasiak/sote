<?php use_helper('Javascript', 'sfAsset', 'sfAssetFile') ?>
<?php if (!$sf_asset->isNew()): ?>
  <div id="thumbnail">
    <a href="<?php echo $sf_asset->getUrl('full') ?>"><?php echo asset_image_tag($sf_asset, 'large', array('title' => __('See full-size version', null, 'sfAsset')), null) ?></a>
  </div>
  <p><?php echo auto_wrap_text($sf_asset->getFilename()) ?></p>
  <p><?php echo __('%weight% Kb', array('%weight%' => $sf_asset->getFilesize()), 'sfAsset') ?></p>
  <p><?php echo __('Created on %date%', array('%date%' => format_date($sf_asset->getCreatedAt('U'))), 'sfAsset') ?></p>

  <?php echo form_tag('sfAsset/renameAsset', 'method=post') ?>
  <?php echo input_hidden_tag('id', $sf_asset->getId()) ?>
  <div class="form-row" style="border: none;">
    <label for="new_name">
      <?php echo image_tag('/plugins/sfAssetsLibraryPlugin/images/page_edit.png', 'align=top') ?>
      <?php echo link_to_function(__('Zmień nazwę', null, 'sfAsset'), 'document.getElementById("input_new_name").style.display="block";document.getElementById("new_name").focus()') ?>
    </label>
    <div class="content" id="input_new_name" style="display:none;padding-left: 1px;">
      <?php echo input_hidden_tag('new_name_ext', getExtension($sf_asset->getFilename())) ?>
      <?php echo input_tag('new_name', getFileName($sf_asset->getFilename()), 'style=width:160px') ?>
      <?php echo submit_tag(__('Ok', null, 'sfAsset')) ?>
    </div>
  </div>
  </form>

<?php endif; ?>