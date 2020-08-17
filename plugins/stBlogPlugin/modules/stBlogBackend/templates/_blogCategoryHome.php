<?php foreach ($row as $category) : ?>
	
	<input type="checkbox" <?php if($category['assighn']==1): ?> checked="checked" <?php endif; ?> value="<?php echo $category['assighn']; ?>" id="blog_category_<?php echo $category['id']; ?>" name="config[category_home][<?php echo $category['id']; ?>]"> <?php echo $category['name']; ?><br/>
	
<?php endforeach ?>