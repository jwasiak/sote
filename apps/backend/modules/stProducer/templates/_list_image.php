<?php
use_helper('stProducerImage');

echo link_to(st_producer_image_tag($producer, 'icon'), 'stProducer/edit?id=' . $producer->getId());
?>