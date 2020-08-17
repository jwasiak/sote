<?php if (SF_ENVIRONMENT == 'edit' && sfConfig::get('sf_st_theme_clipboard') && $isAuthenticated):?>
    <style>
        #magazine1 .st_theme-toolbar-hidden
        {
            display:none;
        }

        #st_container .st_theme-toolbar-visible
        {
            display:none;
        }
        
        .block-hover 
        {
            border: none;
        }
    
        .portal-column
        {
            background-color: #ccc;
            min-height: 30px;
        }
    </style>
    <div style="overflow:hidden; padding:5px 0px 5px 5px;">
        <div style="float:left; padding:4px 10px 0px 0px;">
            <?php echo __('Schowek');?>:
        </div>
        <a style="display:block; float:left;" id="portal-block-list-link" name="portal-block-list-link" href="#">
            <img id="schowek_add" src="/images/frontend/theme/default/schowek_add.png" alt=""/>
            <img src="/images/frontend/theme/default/schowek_del.png" alt=""/>
        </a>
        <div style="float:left; padding:4px 10px 0px 20px;">
            <a href="http://<?php echo $sf_request->getHost().'/backend.php';?>"><?php echo __('Panel administracyjny');?></a>
        </div>
        <div style="float:left; padding:4px 10px 0px 20px;">
            <?php echo link_to(__('Przywróć domyślny wygląd tematu'), 'stThemeFrontend/resetAllChanges', array(
                'post' => true,
                'confirm' => __('Użycie tej opcji spowoduje przywrócenie pierwotnego wyglądu strony. Czy jesteś pewien, że chcesz przywrócić oryginalny wygląd?'),
            ));?>
        </div>
        <div style="float:right; padding:4px 10px 0px 20px;">
            <?php echo form_tag('stThemeFrontend/changeActiveColor');?>
                <?php echo __('Edytujesz temat');?>:&nbsp;<b><?php echo $themeName;?></b> :
                <?php echo select_tag('theme_color', options_for_select($selectColors, $selectActiveColor), array('onchange' => 'this.form.submit()'));?>
            </form>
        </div>
    </div>
<?php else:?>
    <a id="portal-block-list-link" name="portal-block-list-link"></a>
<?php endif;?>