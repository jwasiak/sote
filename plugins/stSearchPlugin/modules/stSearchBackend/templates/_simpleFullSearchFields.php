<ul>
    <?php foreach ($fields as $key=>$field): ?>
        <li><?php echo checkbox_tag('config[simple_full_search_fields]['.$key.']',1,(isset($configFields[$key]) && $configFields[$key])?1:0)?> <?php echo $field?></li>
    <?php endforeach; ?>
</ul>