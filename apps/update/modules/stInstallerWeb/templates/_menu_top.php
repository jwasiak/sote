<div class="horizontal_list">
    <a id="home" href="/update.php"><img src="/images/update/red/icons/home.png" alt=""></a>
    <?php echo link_to(__('Narzędzia eksperta', null, 'stInstallerWeb'),'stInstallerWeb/tools');?>                                                  
    <div class="auth_links">
        <span class="backend"><?php echo link_to(__('Panel sklepu', null, 'stInstallerWeb'),"../backend.php", array('popup'=>'backend'));?></span>
        <span class="frontend"><?php echo link_to(__('Strona sklepu', null, 'stInstallerWeb'),"../index.php", array('popup'=>'frontend'));?></span>
        <?php echo link_to(__('Wyloguj', null, 'stInstallerWeb'),"stAuth/logout", 'class="logout"');?>
    </div>
    <div class="clear"></div>
</div>
