<ul class="open">
	<?php foreach ($parent->getChildren('doSelectWithI18n') as $child): ?>
		
			<li class="<?php echo isset($expanded[$child->getId()]) ? ' selected' : '' ?> children">
				<?php if ($child->hasChildren()): ?> 
				<img class="expandable show" src="/images/backend/beta/navigation/arrow_category_tree-open.png" style="width: 16px" />
				<?php else: ?>
				<img class="last" src="/images/backend/beta/navigation/arrow_category_tree.png"/>
				<?php endif; ?>
				<a href="<?php echo $url ?>?category_filter=<?php echo $child->getId() ?>" data-id="<?php echo $child->getId() ?>"><?php echo $child->getName() ?></a>
				<?php if ($child->hasChildren() && isset($expanded[$child->getId()])): ?>      
					<?php echo st_get_partial('stCategory/categories', array('parent' => $child, 'expanded' => $expanded, 'selected' => $selected, 'url' => $url)) ?>
				<?php endif; ?>      
			</li>   
		
	<?php endforeach; ?>
</ul>