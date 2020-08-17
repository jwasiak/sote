<?php if ($blog->getOptImage()): ?>
	<img src="/uploads/blog/post/<?php echo $blog->getImage(); ?>"><br /><br />
<?php else: ?>
	<img src="/images/backend/stBlogPlugin/image.png"><br /><br />
<?php endif; ?>
 <?php echo object_admin_input_file_tag($blog, 'getImage', array (
  'control_name' => 'blog[image]',
  'include_remove' => true,
)); ?>