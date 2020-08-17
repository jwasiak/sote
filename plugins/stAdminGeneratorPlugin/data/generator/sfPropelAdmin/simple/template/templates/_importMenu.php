<div class="horizontal_list">
    <ul>
        [?php foreach ($items as $action => $name): ?]
            <li class="simple">[?php echo link_to(__($name), $action) ?]</li>
        [?php endforeach; ?]
        <li class="clear_item"></li>
    </ul>
</div>