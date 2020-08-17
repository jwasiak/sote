<?php 
    $http = stConfig::getInstance('stSecurityBackend')->get('ssl') == 'shop' ? 'https' : 'http';
    $domain = $language->getDefaultDomain();
    $host = $domain ? $domain->getDomain() : $sf_request->getHost();
?>
<?php if ($domain): ?>
    <a href="<?php echo $http ?>://<?php echo $host; ?>/lang/<?php echo $language->getShortcut(); ?>"><?php echo $http ?>://<?php echo  $host; ?>/</a>
<?php else: ?>
    <a href="<?php echo $http ?>://<?php echo $host; ?>/lang/<?php echo $language->getShortcut(); ?>"><?php echo $http ?>://<?php echo  $host; ?>/lang/<?php echo $language->getShortcut(); ?></a>
<?php endif ?>