<?php 
$action = $_SERVER['REQUEST_URI'];
$action = explode("/", $action);
?>
<?php if(end($action)!="create"): ?>
    
    <div class="application-menu">
        <ul>
            <?php foreach ($items as $action => $name): $url = url_for($action) ?>
            <?php if (($name == "Punkty" || $name =="Points") && stTheme::hideOldConfiguration()) continue; ?>
                <li class="<?php echo $selected_item_path == $url ? 'selected' : 'none' ?>"><a href="<?php echo $url ?>"><?php echo $name ?></a></li>
            <?php endforeach; ?>
        </ul>
        <br style="clear: left" />
    </div>

<?php endif; ?>