<?php if ($order->getOrderDelivery()->getPaczkomatyNumber()):?>
    <div class="row">
        <span class="label"><?php echo __('Paczkomat odbiorcy', array(), 'stPaczkomatyBackend') ?>:</span>
        <div class="field"><?php echo $order->getOrderDelivery()->getPaczkomatyNumber();?></div>
    </div>
    <div class="row">
        <span class="label"><?php echo __('Adres Paczkomatu', array(), 'stPaczkomatyBackend') ?>:</span>
        <div id="paczkomat_address" class="field">
            <img src="/images/backend/icons/indicator.gif" alt="loading..." />
        </div>
    </div>

    <?php 
        $c = new Criteria();
        $c->add(PaczkomatyPackPeer::ORDER_ID, $order->getId());
        $pp = PaczkomatyPackPeer::doSelectOne($c);
    ?>

    <?php if (!is_object($pp)):?>
        <div class="row">
            <span class="label">&nbsp;</span>
            <div class="field"><a href="<?php echo url_for('@stPaczkomatyCreatePack?order='.$order->getId());?>"><?php echo __('Wyślij paczkę', array(), 'stPaczkomatyBackend') ?></a></div>
        </div>
    <?php else:?>
        <div class="row">
            <span class="label"><?php echo __('Numer paczki', array(), 'stPaczkomatyBackend') ?>:</span>
            <div class="field"><a href="<?php echo url_for('stPaczkomatyBackend/edit?id='.$pp->getId());?>"><?php echo $pp->getCode();?></a></div>
        </div>
    <?php endif;?>
    <script type="text/javascript" language="javascript">
        jQuery(function ($) {
            $(document).ready(function() {
                $.getJSON('/paczkomaty/getMachine/<?php echo $order->getOrderDelivery()->getPaczkomatyNumber();?>', function(data) {
                    $('#paczkomat_address').html(data.street + ' ' +  data.house + '<br />' + data.postCode + ' ' + data.city);
                });
            });
        });
    </script>
<?php else:?>
    <script type="text/javascript" language="javascript">
        jQuery(function ($) {
            $(document).ready(function() {
                $('.sf_fieldset_paczkomaty').hide();
            });
        });
    </script>
<?php endif;?>
