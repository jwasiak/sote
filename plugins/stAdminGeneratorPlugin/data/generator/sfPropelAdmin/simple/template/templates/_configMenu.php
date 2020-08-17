<div class="application-menu">
    <ul>
        [?php foreach ($items as $action => $name): $url = url_for($action) ?]
            <li class="[?php echo $selected_item_path == $url ? 'selected' : 'none' ?]"><a href="[?php echo $url ?]">[?php echo $name ?]</a></li>
        [?php endforeach; ?]
    </ul>
    <br style="clear: left" />
</div>