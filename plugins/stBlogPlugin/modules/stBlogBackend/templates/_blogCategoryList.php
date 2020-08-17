<?php foreach ($row as $category) : ?>

<?php if($category['assighn']==1): ?>
	<?php echo $category['name']; ?>
<?php endif; ?>	
	
<?php endforeach ?>