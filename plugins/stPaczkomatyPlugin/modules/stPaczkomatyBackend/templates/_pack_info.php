<?php if(!$paczkomaty_pack->isNew()):?>
    <div class="row">
        <label for="paczkomaty_pack_code">
            <?php echo __('Numer paczki', array(), 'stPaczkomatyBackend');?>:
        </label>
        <?php echo $paczkomaty_pack->getCode();?>
        <div class="clr"></div>
    </div>

    <div class="row">
        <label for="paczkomaty_pack_status">
            <?php echo __('Status paczki', array(), 'stPaczkomatyBackend');?>:
        </label>
        <div id="st-paczkomaty-status">
            <img src="/images/backend/icons/indicator.gif" alt="loading..." />
        </div>
        <div class="clr"></div>
    </div>

    <div class="row">
        <label for="paczkomaty_pack_status_changed_at">
            <?php echo __('Aktualizacja statusu w systemie Paczkomaty.pl', array(), 'stPaczkomatyBackend');?>:
        </label>
        <div id="st-paczkomaty-status-date">
            <img src="/images/backend/icons/indicator.gif" alt="loading..." />
        </div>
        <div class="clr"></div>
    </div>

    <script type="text/javascript" language="javascript">
        jQuery(function ($) {
            $(document).ready(function() {
                $.getJSON('/backend.php/paczkomaty/getPackStatus?code=<?php echo $paczkomaty_pack->getCode();?>', function(data) {
                    $('#st-paczkomaty-status').html(data.clientStatus);
                    $('#st-paczkomaty-status-date').html(data.date);
                    <?php if($paczkomaty_pack->getStatus() == 'Created'):?>
                        if (data.status != 'Created') {
                            $('.action-pay_for_pack').hide();
                            $('.action-download_sticker input').attr('value', 'Pobierz etykiete');
                            $('.action-download_sticker input').css('background-image', 'url(/images/backend/icons/download_sticker.png)');
                        }
                    <?php endif;?>
                });
                $.getJSON('/paczkomaty/getMachine?number=<?php echo $paczkomaty_pack->getCustomerPaczkomat();?>', function(data) {
                    $('#st-paczkomaty-customer-machine').html(data.number + ', ' + data.street + ' ' +  data.house + ', ' + data.postCode + ' ' + data.city);
                });
                <?php if($paczkomaty_pack->getUseSenderPaczkomat()):?>
                    $.getJSON('/paczkomaty/getMachine?number=<?php echo $paczkomaty_pack->getSenderPaczkomat();?>', function(data) {
                        $('#st-paczkomaty-sender-machine').html(data.number + ', ' + data.street + ' ' +  data.house + ', ' + data.postCode + ' ' + data.city);
                    });
                <?php endif;?>
                $('.action-save').hide();
                <?php if(!is_null($paczkomaty_pack->getStatus()) && $paczkomaty_pack->getStatus() != 'Created'):?>
                    $('.action-pay_for_pack').hide();
                    $('.action-download_sticker input').attr('value', 'Pobierz etykiete');
                <?php else:?>
                    $('.action-download_sticker input').css('background-image', 'url(/images/backend/icons/pay_and_download.png)');
                <?php endif;?>
            });
        });
    </script>
<?php else:?>
    <script type="text/javascript" language="javascript">
        jQuery(function($) {
            $(document).ready(function() {
                $('#sf_fieldset_informacje_o_paczce').hide();
                $('.action-pay_for_pack').hide();
                $('.action-download_sticker').hide();
                $('.action-list').hide();
            });
        });
    </script>
<?php endif;?>
