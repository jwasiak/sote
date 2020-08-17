<?php if (SF_ENVIRONMENT == 'edit' && $isAuthenticated):?>
    <div id="portal-column-block-list" style="opacity: 0.999999; z-index: 10000; position: fixed; left: 50px; top: 50px; min-width: 200px; display:none; background-color: #fefefe; border:1px dotted red;">
        <div style="width:300px; height:400px; float:left; overflow:auto;">
            <div id="magazine1" class="portal-column" style="float:left; width:100%">
                <div style="background-color:#ccc; width:100%"><h3 style="font-size:16px;">
                    <?php echo __('Schowek elementów');?></h3>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function showToolbarOptions(cn) {
            var count = 0;

            $A($$('.' + cn)).each(function(e) {
                count++;
                e.insert({top: '<div id="st_theme-toolbar-'+count+'" style="height:1px; position:absolute; z-index:1; margin-bottom:-25px;"><div style="text-align:center;float:left; height:20px; width: 20px; background-color: #fefefe; opacity: 0.7; cursor: move;"><img src="/images/frontend/theme/default/icon_move.png" alt=""/></div><div id="st_theme-toolbar-'+count+'-hidden" style="text-align:center; float:left; height:20px; width:20px;  background-color: #fefefe; opacity: 0.7; cursor: pointer; cursor: hand;" class="st_theme-toolbar-hidden"><img src="/images/frontend/theme/default/icon_delete.png" alt=""/></div><div id="st_theme-toolbar-'+count+'-visible" style="text-align:center; float:left; height:20px; width: 20px;  background-color: #fefefe; opacity: 0.7; cursor: pointer; cursor: hand;" class="st_theme-toolbar-visible"><img src="/images/frontend/theme/default/icon_add.png" alt=""/></div></div>'});

                $('st_theme-toolbar-'+count+'-hidden').observe('click', function() {
                    new Ajax.Request('<?php echo url_for('stThemeFrontend/hiddenBlock');?>?block_id=' + e.id, {
                        method: 'post',
                        onSuccess: function() { $('magazine1').insert({bottom: e}); }
                    });
                });

                $('st_theme-toolbar-'+count+'-visible').observe('click', function() {
                    new Ajax.Request('<?php echo url_for('stThemeFrontend/visibleBlock') ?>?block_id=' + e.id, {
                        method: 'post',
                        onSuccess: function() {
                            document.getElementById(e.id).style.display = "none";
                            document.getElementById("portal-column-block-list").style.display = "none";
                            location.reload();
                        }
                    });
                });
            });
        }
        showToolbarOptions('block');
    </script>
<?php else:?>
    <div id="portal-column-block-list" style="display:none;">
        <div>
            <div id="magazine1" class="portal-column"></div>
        </div>
    </div>
<?php endif;?>