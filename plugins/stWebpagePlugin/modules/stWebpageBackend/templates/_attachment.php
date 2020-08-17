<?php 
    $path = $webpage->getPdfAttachmentPath(); 
    $url = $webpage->getPdfAttachmentPath(false); 
?>

<?php echo input_file_tag('webpage[attachment]') ?>
<?php if (is_file($path)): ?>
<p><a href="<?php echo $url ?>?v<?php echo filemtime($path) ?>" target="_blank"><?php echo __('Pokaż załącznik') ?></a> <a target="_self" href="/backend.php/webpage/deleteTerms?path=<?php echo $path; ?>&page=<?php echo sfContext::getInstance()->getRequest()->getParameter('id'); ?>" target="_blank"><?php echo __('Usuń') ?></a></p>
<?php endif ?>