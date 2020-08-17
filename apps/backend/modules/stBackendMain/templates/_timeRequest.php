<?php sfContext::getInstance()->getResponse()->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype');?>
<script type="text/javascript">
    function delayer()
    {
        var d = new Date();
        if (d.getTime() <= <?php echo $time;?>) {
            new Ajax.Request('<?php echo url_for('stBackendMain/timeRequestAjax'); ?>', {asynchronous:true});
            setTimeout('delayer()', 900000);
        }
    }
    delayer();
</script>