
<?php echo checkbox_tag('category[is_active]', 1, $category->getIsActive(), array (
  'disabled' => $category->hasParent() && $category->getParent() && !$category->getParent()->getIsActive()
)); ?>

<?php if ($category->hasParent() && $category->getParent() && !$category->getParent()->getIsActive()): ?>
<a href="#" class="help" style="vertical-align: middle" title="<?php echo __('Nie możesz aktywować kategorii w przypadku, gdy kategoria narzędna jest nieaktywna') ?>"></a>
<?php endif ?>