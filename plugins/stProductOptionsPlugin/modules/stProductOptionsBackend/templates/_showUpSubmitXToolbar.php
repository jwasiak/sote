<div style="float: right">
                    <table class="x-btn-wrap x-btn st_ext_button-icon <?php echo (isset($disabled) && ($disabled)) ? 'x-item-disabled' : '' ?>" id="st_product_options-save_button_up" cellspacing="0" cellpadding="0" borders="0" style="width: auto;">
                        <tbody>
                            <tr>
                                <td class="x-btn-left"><i> </i></td>
                                <td class="x-btn-center">
                                    <em unselectable="on">
										<?php if(isset($disabled) && $disabled): ?>
										    <button type="button" id="product_options_template-visible_button"
	                                            class="x-btn-text" style="background-image: url(/images/backend/icons/save.png);"><?php echo __('Zapisz') ?></button>
										<?php else: ?>
	                                        <button type="button" id="product_options_template-visible_button_up"
	                                            onMouseOver="document.getElementById('st_product_options-save_button_up').className = 'x-btn-wrap x-btn st_ext_button-icon x-btn-over'" 
	                                            onMouseOut ="document.getElementById('st_product_options-save_button_up').className = 'x-btn-wrap x-btn st_ext_button-icon'"
	                                            onClick="document.getElementById('product_options_template-submit_button_up').click();
	                                                        this.style.backgroundImage = 'url(/images/backend/icons/ajax-loader.gif)';
	                                                        this.firstChild.nodeValue = '<?php echo __('Zapisuję...',null,'stProductOptionsBackend')?>';"
	                                            class="x-btn-text" style="background-image: url(/images/backend/icons/save.png);"><?php echo __('Zapisz', null, 'stAdminGeneratorPlugin') ?></button>
										<?php endif; ?>
                                    </em>
                                </td>
                                <td class="x-btn-right"><i> </i></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php echo submit_tag(__('Zapisz'), array('id' => 'product_options_template-submit_button_up')) ?>
</div>

