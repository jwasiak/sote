<?php use_helper('Validation', 'Object') ?>
<?php st_theme_use_stylesheet('stUser.css') ?>
  
<div id="st_user-edit_data" class="st_component" style="border: 0px;"> 

    <?php echo form_tag('stPartnerFrontend/savePartner', array('class' => 'st_form', 'name'=>'register')) ?>
    <fieldset>
              
        
        <?php echo form_error('partner_data[name]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>        
        <?php echo form_error('partner_data[surname]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>        
        <?php echo form_error('partner_data[street]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>        
        <?php echo form_error('partner_data[house]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>        
        <?php echo form_error('partner_data[code]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>        
        <?php echo form_error('partner_data[town]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>        
        <?php echo form_error('partner_data[phone]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>        
        <?php echo form_error('partner_data[vatNumber]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>        
        <?php echo form_error('partner_data[bankNumber]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')) ?>        
        
        
        
        <div id="st_form-user-field1" class="st_row">    
            <?php echo label_for('st_form-userData-field1',__('firma')) ?>
            <div class="st_field">
                <?php echo input_tag('partner_data[company]', $partnerData->getCompany(), array('id'=>'st_form-user-company', 'maxlength'=>'255')) ?> 
            </div>
        </div>        
       
        <div id="st_form-user-field3" class="st_row">
            <b><?php echo label_for('st_form-userData-field3',__('imię i nazwisko')) ?></b>
            <div class="st_field">
                <?php echo input_tag('partner_data[name]', $partnerData->getName(), array('id'=>'st_form-user-name', 'maxlength'=>'255', 'class'=>form_has_error('partner_data{name}') ? 'st_form-error' : '')) ?> 
                <?php echo input_tag('partner_data[surname]', $partnerData->getSurname(), array('id'=>'st_form-user-surname', 'maxlength'=>'255', 'class'=>form_has_error('partner_data{surname}') ? 'st_form-error' : '')) ?> 
            </div>
        </div>
       
        <div id="st_form-user-field4" class="st_row">
            <b><?php echo label_for('st_form-userData-field4',__('ulica, nr domu')) ?></b>
            <div class="st_field">
                <?php echo input_tag('partner_data[street]', $partnerData->getStreet(), array('id'=>'st_form-user-street', 'maxlength'=>'255', 'class'=>form_has_error('partner_data{street}') ? 'st_form-error' : '')) ?> 
                <?php echo input_tag('partner_data[house]', $partnerData->getHouse(), array('id'=>'st_form-user-house', 'maxlength'=>'255', 'class'=>form_has_error('partner_data{house}') ? 'st_form-error' : '')) ?>  /
                <?php echo input_tag('partner_data[flat]', $partnerData->getFlat(), array('id'=>'st_form-user-flat', 'maxlength'=>'255')) ?>
           </div>
        </div>
        
        <div id="st_form-user-field5" class="st_row">
            <b><?php echo label_for('st_form-userData-field5',__('kod, miasto')) ?></b>
            <div class="st_field">
                <?php echo input_tag('partner_data[code]', $partnerData->getCode(), array('id'=>'st_form-user-code', 'maxlength'=>'255', 'class'=>form_has_error('partner_data{code}') ? 'st_form-error' : '')) ?> 
                <?php echo input_tag('partner_data[town]', $partnerData->getTown(), array('id'=>'st_form-user-town', 'maxlength'=>'255', 'class'=>form_has_error('partner_data{town}') ? 'st_form-error' : '')) ?> 
            </div>
        </div>
        
        <div id="st_form-user-field6" class="st_row">
                <b><?php echo label_for('st_form-userData-field6',__('kraj')) ?></b>
                <div class="st_field">
                    <?php echo object_select_tag($partnerData->getCountriesId(), 'getId', array('id'=>'st_form-user-country', 'related_class' => 'Countries', 'peer_method'=>"doSelectActive", 'control_name' => 'partner_data[country]')) ?>                
                </div> 
        </div>
        
        <div id="st_form-user-field7" class="st_row">
             <b><?php echo label_for('st_form-userData-field7',__('telefon')) ?></b>
            <div class="st_field">
            <?php echo input_tag('partner_data[phone]', $partnerData->getPhone(), array('id'=>'st_form-user-phone', 'maxlength'=>'255', 'class'=>form_has_error('partner_data{phone}') ? 'st_form-error' : '')) ?> 
            </div>
        </div>
               
        <div id="st_form-user-field10" class="st_row">
            <?php echo label_for('st_form-userData-field10',__('nip')) ?>
            <div class="st_field">
                <?php echo input_tag('partner_data[vatNumber]', $partnerData->getVatNumber(), array('id'=>'st_form-user-nip', 'maxlength'=>'255', 'class'=>form_has_error('partner_data{vatNumber}') ? 'st_form-error' : '')) ?>
            </div>
        </div>   
        
        <div id="st_form-user-field11" class="st_row">
            <?php echo label_for('st_form-userData-field11',__('nr konta')) ?>
            <div class="st_field">
                <?php echo input_tag('partner_data[bankNumber]', $partnerData->getBankNumber(), array('id'=>'st_form-user-nip', 'maxlength'=>'255', 'class'=>form_has_error('partner_data{bankNumber}') ? 'st_form-error' : '')) ?>
            </div>
        </div>   
        
        <div id="st_form-user-field11" class="st_row">
            <?php echo label_for('st_form-userData-field11',__('uwagi')) ?>
            <div class="st_field">
                <?php echo textarea_tag('partner_data[description]', $partnerData->getDescription(), array('id'=>'st_form-user-nip', 'maxlength'=>'255', 'class'=>form_has_error('partner_data{description}') ? 'st_form-error' : '')) ?>
            </div>
        </div>   
        <div class="st_row">
            <div class="st_field">
                <span><b>* <?php echo __('Pola pogrubione są wymagane.');?></b></span>
            </div>
        </div>
        
        <div id="st_form-user-field10" class="st_row">
        <div id="st_button-user-edit_data" class="st_button-container" style="margin-right:17px;">
            <div class="st_button st_align-right">
                <div class="st_button-left">
                    <?php echo submit_tag(__('Zarejestruj'),array('name'=>'submit_save')) ?>                        
                </div>
            </div>
        </div>
        </div>
        
        
        <?php echo input_hidden_tag('partner_data[user_id]', $partnerData->getSfGuardUserId()); ?>
        
    </form>
    
    
</div>