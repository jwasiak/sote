<?php use_helper('Javascript', 'sfAsset') ?>

<?php if ($folder->isRoot()): ?>
<?php /*
<div class="form-row">
  <?php echo image_tag('/plugins/sfAssetsLibraryPlugin/images/images.png', 'align=top') ?>
  <?php echo link_to(__('Mass upload', null, 'sfAsset'), 'sfAsset/massUpload') ?>
</div>*/ ?>
<?php endif ?>

<?php echo form_tag('sfAsset/addQuick', 'method=post multipart=true') ?>
<?php echo input_hidden_tag('parent_folder', $parent_folder) ?>
<div class="form-row" style="border: none;padding-left: 1px;">
  <label for="new_file">
    <?php echo image_tag('/plugins/sfAssetsLibraryPlugin/images/image_add.png', 'align=top') ?>
    <?php echo link_to_function(__('Dodaj plik do tego katalogu', null, 'sfAsset'), 'document.getElementById("input_new_file").style.display="block"') ?>
  </label>
  <div class="content" id="input_new_file" style="display:none;padding-left: 1px;">
    <?php echo input_file_tag('new_file', 'size=7') ?> <?php echo submit_tag(__('Add', null, 'sfAsset')) ?>
  </div>
</div>
</form>

<?php echo form_tag('sfAsset/createFolder', 'method=post') ?>
<?php echo input_hidden_tag('parent_folder', $parent_folder) ?>
<div class="form-row" style="border: none;padding-left: 1px;">
  <label for="new_directory">
    <?php echo image_tag('/plugins/sfAssetsLibraryPlugin/images/folder_add.png', 'align=top') ?>
    <?php echo link_to_function(__('Dodaj podkatalog', null, 'sfAsset'), 'document.getElementById("input_new_directory").style.display="block"') ?>
  </label>
  <div class="content" id="input_new_directory" style="display:none;padding-left: 1px;">
    <?php echo input_tag('name', null, 'size=17') ?> <?php echo submit_tag(__('Utwórz', null, 'sfAsset')) ?>
  </div>
</div>
</form>

<?php if (!$folder->isRoot() && $folder->getIsEnabled() == true): ?>
<?php echo form_tag('sfAsset/renameFolder', 'method=post') ?>
<?php echo input_hidden_tag('id', $folder->getId()) ?>
<div class="form-row" style="border: none;padding-left: 1px;">
  <label for="new_folder">
    <?php echo image_tag('/plugins/sfAssetsLibraryPlugin/images/folder_edit.png', 'align=top') ?>
    <?php echo link_to_function(__('Zmień nazwę katalogu', null, 'sfAsset'), 'document.getElementById("input_new_name").style.display="block";document.getElementById("new_name").focus()') ?>
  </label>
  <div class="content" id="input_new_name" style="display:none;padding-left: 1px;">
    <?php echo input_tag('new_name', $folder->getName(), 'size=17') ?>
    <?php echo submit_tag(__('Ok', null, 'sfAsset')) ?>
  </div>
</form>
</div>
<?php echo form_tag('sfAsset/moveFolder', 'method=post') ?>
<?php echo input_hidden_tag('id', $folder->getId()) ?>
<div class="form-row" style="border: none;padding-left: 1px;">
  <label for="new_folder">
    <?php echo image_tag('/plugins/sfAssetsLibraryPlugin/images/folder_go.png', 'align=top') ?>
    <?php echo link_to_function(__('Przenieś katalog', null, 'sfAsset'), 'document.getElementById("input_move_folder").style.display="block"') ?>
  </label>
  <div class="content" id="input_move_folder" style="display:none;padding-left: 1px;">
    <?php echo select_tag('new_folder', options_for_select(sfAssetFolderPeer::getAllNonDescendantsPaths($folder), $folder->getParentPath()), 'style=width:170px') ?>
    <?php echo submit_tag(__('Ok', null, 'sfAsset')) ?>
  </div>
</div>
</form>

<div class="form-row" style="border: none;padding-left: 1px;">
  <?php echo image_tag('/plugins/sfAssetsLibraryPlugin/images/folder_delete.png', 'align=top') ?>
  <?php echo link_to(__('Usuń katalog', null, 'sfAsset'), 'sfAsset/deleteFolder?id='.$folder->getId(), array(
    'post' => true,
    'confirm' => __('Czy jesteś pewien?', null, 'sfAsset'),
  )) ?>
</div>

<?php endif; ?>
