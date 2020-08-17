<script>
<?php foreach ($items as $item): ?>
    fbq('track', 'AddToCart', {
        value: '<?php echo $item['item']->getPriceBrutto() ?>',
        currency: '<?php echo $currency ?>',
        content_name: 'shopping cart',
        content_type: 'product',
        content_ids: ['<?php echo $item['item']->getCode() ?>']
    });
<?php endforeach ?>
</script>