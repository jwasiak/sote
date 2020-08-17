<?php $webinstall = stInstallMethod::getWebInstall();?>
<ol>
    <li <?php echo ($step == 'index') ? 'class="stSetup-active_li"' : '';?>><?php echo __('Informacje ogólne');?></li>
    <li <?php echo ($step == 'license') ? 'class="stSetup-active_li"' : '';?>><?php echo __('Licencja');?></li>
    <li <?php echo ($step == 'require') ? 'class="stSetup-active_li"' : '';?>><?php echo __('Wymagania techniczne');?></li>
    <li <?php echo ($step == 'database') ? 'class="stSetup-active_li"' : '';?>><?php echo __('Konfiguracja bazy danych');?></li>
    <?php if ($webinstall):?>
        <li <?php echo ($step == 'dbdata') ? 'class="stSetup-active_li"' : '';?>><?php echo __('Budowanie bazy danych');?></li>
    <?php else:?>    
        <li <?php echo ($step == 'download') ? 'class="stSetup-active_li"' : '';?>><?php echo __('Pobieranie plików');?></li>
        <li <?php echo ($step == 'install') ? 'class="stSetup-active_li"' : '';?>><?php echo __('Instalacja');?></li>
    <?php endif;?>
    <li <?php echo ($step == 'settings') ? 'class="stSetup-active_li"' : '';?>><?php echo __('Domyślne ustawienia');?></li>
    <li <?php echo ($step == 'configure') ? 'class="stSetup-active_li"' : '';?>><?php echo __('Konfiguracja');?></li>
    <li <?php echo ($step == 'finish') ? 'class="stSetup-active_li"' : '';?>><?php echo __('Informacje końcowe');?></li>
</ol>