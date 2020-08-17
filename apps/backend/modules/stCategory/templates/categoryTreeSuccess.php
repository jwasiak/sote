<ul>
<?php foreach ($roots as $root): ?>
   <li>
      <a href="#"><?php echo $root->getOptName() ?></a>
   </li>
<?php endforeach ?>
</ul>