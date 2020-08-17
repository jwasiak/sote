<?php use_helper('stPaczkomaty');?>
<?php if($paczkomaty_pack->isNew()):
    $paczkomaty_params = array();

    if ($paczkomaty_pack->hasAllegroTransactionId())
    {
        $paczkomaty_params['function'] = 'ParcelSend,AllegroParcelSend';
    }
    else
    {
        $paczkomaty_params['function'] = 'ParcelSend';
    }

?>
    <div class="row">
        <label for="paczkomaty_pack_use_sender_paczkomat">
            <?php echo __('Użyj Paczkomatu', array(), 'stPaczkomatyBackend');?>
        </label>
        <?php $useSenderPaczkomat = !$sf_request->hasParameter('paczkomaty_pack[use_sender_paczkomat]') ? $paczkomaty_pack->getUseSenderPaczkomat() : $sf_request->getParameter('paczkomaty_pack[use_sender_paczkomat]');?>
        <?php echo checkbox_tag('paczkomaty_pack[use_sender_paczkomat]', 1, $useSenderPaczkomat);?> 
        <div class="clr"></div>
    </div>

    <div class="row">
        <label for="paczkomaty_pack_sender_paczkomat">
            <?php echo __('Paczkomat nadawcy', array(), 'stPaczkomatyBackend');?>
        </label>
        <?php show_paczkomaty_dropdown_list('paczkomaty_pack[sender_paczkomat]', $paczkomaty_pack->getSenderPaczkomat(), array('disabled' => !$useSenderPaczkomat, 'paczkomaty' => array('function' => 'ParcelSend')));?>
        <div class="clr"></div>
    </div>
    <script type="text/javascript" language="javascript">
        jQuery(function($) {
            $(document).ready(function() {
                $('#paczkomaty_pack_use_sender_paczkomat').change(function() {
                    $('#paczkomaty_pack_sender_paczkomat').prop('disabled', !$(this).prop('checked'));
                });
            });
        });
    </script>
<?php else:?>
    <div class="row">
        <label for="paczkomaty_pack_customer_email">
            <?php echo __('Użyj Paczkomatu', array(), 'stPaczkomatyBackend');?>:
        </label>
        <?php if ($paczkomaty_pack->getUseSenderPaczkomat()):?> 
            <img src="/images/backend/beta/icons/16x16/tick.png" alt="loading..." />
        <?php else:?>
            <img src="/images/backend/beta/icons/16x16/cancel.png" alt="loading..." />
        <?php endif;?>
        <div class="clr"></div>
    </div>
    <div class="row">
        <label for="paczkomaty_pack_sender_paczkomat">
            <?php echo __('Paczkomat nadawcy', array(), 'stPaczkomatyBackend');?>:
        </label>
        <?php if ($paczkomaty_pack->getUseSenderPaczkomat()):?> 
            <div id="st-paczkomaty-sender-machine">
                <img src="/images/backend/icons/indicator.gif" alt="loading..." />
            </div>
        <?php else:?>
            -
        <?php endif;?>
        <div class="clr"></div>
    </div>
<?php endif;?>
