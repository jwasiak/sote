<?php
// auto-generated by sfPropelAdmin
// date: 2017/02/16 15:31:44
?>
<?php echo st_get_admin_actions_head('style="margin-top: 10px;  float: left"') ?>
  <?php echo st_get_admin_action('delete', __('Usuń zbiór'), '@stPocztaPolskaBackend?action=deleteBufor&bufor_id='.$sf_request->getParameter('bufor_id'), array("name" => "delete", "confirm" => __("Jesteś pewien?"))) ?>
</ul>

<?php if ($pager->getNbResults()): ?>
    <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
      <?php echo st_get_admin_action('printPdf', __('Pobierz wszystkie etykiety'), '@stPocztaPolskaBackend?action=downloadAddressLabels&bufor_id='.$sf_request->getParameter('bufor_id'), array("name" => "create",)) ?>
      <?php echo st_get_admin_action('printPdf', __('Pobierz wszystkie blankiety pobrań'), '@stPocztaPolskaBackend?action=downloadBlankietyPobrania&bufor_id='.$sf_request->getParameter('bufor_id'), array("name" => "create",)) ?>
      <?php echo st_get_admin_action('save', __('Wyślij'), '@stPocztaPolskaBackend?action=send&bufor_id='.$sf_request->getParameter('bufor_id'), array("name" => "create",)) ?>
    <?php echo st_get_admin_actions_foot() ?>
<?php endif ?>