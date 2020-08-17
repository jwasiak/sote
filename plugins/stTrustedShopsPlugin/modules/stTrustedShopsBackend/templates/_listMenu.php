<div class="application-menu">
    <ul>
        <?php foreach ($items as $action => $name):?>
            <?php if (SF_ENVIRONMENT != 'dev' && $action == 'stTrustedShopsBackend/config') continue;?>
            <li class="<?php echo url_for($selected_item_path) == url_for($action) ? 'selected' : 'none';?>"><?php echo link_to(__($name), $action);?></li>
        <?php endforeach;?>
    </ul>
    <br style="clear: left" />
</div>