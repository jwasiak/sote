<div class="content_update_box">
    <table>
    <?php foreach ($items as $item) :?>
        <tr>
                <?php $item->setCulture($sf_params->get('culture')); ?>
            <td style="width: 130px; vertical-align: top;">
                <?php echo $item->getCreatedAt(); ?>

            </td>
            <td>
                <?php echo $item->getName(); ?>

            </td>
        <tr>
    <?php endforeach; ?>
    </table>
</div>
<style type="text/css">
.content_update_box {
    max-width: 480px; 
    margin: 0px auto
}
</style>
<div class="clear"></div>
