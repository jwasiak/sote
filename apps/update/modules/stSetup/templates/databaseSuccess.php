<?php use_helper('I18N', 'Date', 'Text', 'Object', 'Validation', 'ObjectAdmin', 'stUpdate') ?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<div id="sf_admin_container">
    <?php include_partial('header');?>
    <div class="bg_content">
    	<div class="stSetup-left_menu">
    	   <?php include_component('stSetup', 'leftMenu', array('step'=>'database')); ?>
    	</div>
    	<div id="stSetup-right_menu">	
        	<h2 class="title"><?php echo __("Konfiguracja bazy danych")?></h2>

        	<?php echo form_tag('stSetup/database'); ?>
            <fieldset class="datebase_create">
                <?php if($dbError) : ?>
        	    <div class="form-errors">
        	       <h2><?php echo __("Popraw dane w formularzu"); ?></h2>
        	       <dl>
        	           <dt><?php echo __("Problem:")?></dt>
        	           <dd><?php echo __($dbErrorMsg); ?></dd>
        	       </dl>
        	    </div>
        	    <?php endif; ?>
                <div class="st_fieldset-content">
        	        <div class="form-row">
        	            <label><?php echo __("Adres serwera bazy danych"); ?></label>
        	            <div class="content"><?php echo input_tag('host', $dbHost); ?></div>
        	        </div>
        	        <div class="form-row">
                        <label><?php echo __("Nazwa bazy danych"); ?></label>
        	            <div class="content"><?php echo input_tag('database', $dbDatabase); ?></div>
        	        </div>
                    <div class="form-row">
                        <label><?php echo __("Nazwa użytkownika bazy danych"); ?></label>
                        <div class="content"><?php echo input_tag('username', $dbUsername); ?></div>
                    </div>
                    <div class="form-row">
                        <label><?php echo __("Hasło"); ?></label>
                        <div class="content"><?php echo input_password_tag('password', $dbPassword); ?></div>
                    </div>
                </div>
            </fieldset>
            <div class="stSetup-actions"> 
                    <?php echo st_get_update_actions_head() ?>
                    <?php echo st_get_update_action('previous', __('Wstecz'), 'stSetup/require') ?>                   
                    <?php echo st_get_update_action('next', __('Dalej'), null) ?>                   
                    <?php echo st_get_update_actions_foot() ?>              
                    </form>
            </div>
        </div>	
        <div class="clear"></div>
    </div>
</div>