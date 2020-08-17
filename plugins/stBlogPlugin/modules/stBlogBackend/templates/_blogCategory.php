<?php if ($row): ?>
<?php foreach ($row as $category) : ?>
	
	<input type="checkbox" <?php if($category['assighn']==1): ?> checked="checked" <?php endif; ?> value="<?php echo $category['assighn']; ?>" id="blog_category_<?php echo $category['id']; ?>" name="blog[category][<?php echo $category['id']; ?>]"> <?php echo $category['name']; ?><br/>
	
<?php endforeach ?>
<?php else: ?>
    <a href="/backend.php/blog/categoryList" ><?php echo __('Dodaj kategorię') ?></a>    
<?php endif; ?>