<?php
// auto-generated by sfPropelAdmin
// date: 2012/10/16 12:10:47
?>
<?php echo st_get_admin_actions_head('style="float: left"') ?>
<?php if (method_exists($group_price, 'getIsSystemDefault') == false || (method_exists($group_price, 'getIsSystemDefault') && !$group_price->getIsSystemDefault())): ?>
		<?php if ($group_price->getId()): ?>
<?php echo st_get_admin_action('delete', __('Usuń', null, 'stAdminGeneratorPlugin'), 'stGroupPriceBackend/delete?id='.$group_price->getId(), array("confirm" => __("Are you sure?"),"name" => "delete",)) ?><?php endif; ?>
<?php endif; ?>
</ul>

<?php echo st_get_admin_actions_head('style="float: right"') ?>

      <ul class="admin_actions" style="float: right">
          <li class="action-list"><input type="button" onclick="document.location.href='<?php echo st_url_for("stGroupPriceBackend/list") ?>';" value="<?php echo __('Pokaż listę') ?>" style="background-image: url(/images/backend/icons/list.png)" name="list"></li>
          <?php if ($group_price->getId()): ?>
                <li class="action-sync"><input type="submit" onclick="return confirm('<?php echo __('Jesteś pewień, że chcesz zmienić cenę dla tej grupy, tego procesu nie da się odwrócić ?') ?>');" style="background-image: url(/images/backend/icons/save.png)" value="<?php echo __('Synchronizuj') ?>" name="save_and_add"></li>
          <?php endif; ?>
          <li class="action-save"><input type="submit" style="background-image: url(/images/backend/icons/save.png)" value="<?php echo __('Zapisz') ?>" name="save"></li>  
      </ul>
      
<?php echo st_get_admin_actions_foot() ?>