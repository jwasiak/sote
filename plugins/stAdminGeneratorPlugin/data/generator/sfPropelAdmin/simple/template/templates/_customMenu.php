<div class="st_horizontal_list">
    <ul>
        [?php foreach ($items as $action => $name): ?]
            <li class="[?php echo url_for($selected_item_path) == url_for($action) ? 'st_horizontal_list-item-selected' : 'none' ?]">[?php echo link_to(__($name), $action) ?]</li>
        [?php endforeach; ?]
        <li class="st_horizontal_list-item-clear"></li>
    </ul>
</div>