<?php $smarty->assign('hasTrustedOpinion', $hasTrustedOpinion);?>
<?php if($hasTrustedOpinion === true):?>
    <?php $smarty->assign('shopId', $trustedOpinionId);?>
    <?php $smarty->assign('type', $trustedOpinionNewType);?>
    <?php $smarty->assign('email', $email);?>
    <?php $smarty->assign('order_id', $orderId);?>
    <?php $smarty->assign('order_amount', $orderAmount);?>
    <?php $smarty->assign('product_ids', $productIds);?>
    <?php $smarty->assign('showTransactionSystem', $showTransactionSystem);?>
<?php endif;?>
<?php $smarty->display("ceneo_trusted_opinion.html");?>