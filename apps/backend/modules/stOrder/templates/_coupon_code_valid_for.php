<?php echo input_tag('coupon_code[valid_for]', $order_status->getCouponCodeValidFor(), array('size' => 3, 'disabled' => !$order_status->getAttachCouponCode(), 'class' => 'coupon_code_field')) ?> <?php echo __('dni') ?>