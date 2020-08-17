<script language="javascript">
function showAvailability()
{
    if (document.getElementById('product_availability_id').disabled==true)
    {
        document.getElementById('product_availability_id').disabled=false;
    }
    else
    {
        document.getElementById('product_availability_id').disabled=true;
    }
}
</script>
<?php echo object_select_tag($selected, 'getId', array('related_class'=>'Availability', 'control_name'=>'product[availability_id]', 'disabled'=>$disable, 'include_custom'=>'-----'))?><span style="margin-left:20px"><?php echo __('Pokaż wg Magazynu', array(), 'stAvailabilityBackend');?> <?php echo checkbox_tag('product[is_depository]', 1, $is_depository, array('onChange' => 'Javascript:showAvailability();'))?></span>