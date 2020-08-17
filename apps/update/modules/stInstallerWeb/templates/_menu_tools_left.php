<?php if (!isset($selected)) $selected = '';?>
<ul id="menu_left">
    <?php if($selected=='verifyall') echo "<div class=\"selected\">"; else echo "<div>";?>
            <?php echo link_to(__('Weryfikacja systemu', null, 'stInstallerWeb'),'stInstallerWeb/verifyall');?>
    </div>
    <?php if($selected=='devel') echo "<div class=\"selected\">"; else echo "<div>";?>
            <?php echo link_to(__('Tryb developerski', null, 'stInstallerWeb'),'devel');?>
    </div>
    <?php if($selected=='history') echo "<div class=\"selected\">"; else echo "<div>";?>
            <?php echo link_to(__('Historia aktualizacji', null, 'stInstallerWeb'),'stInstallerWeb/history');?>
    </div>
    <?php if($selected=='reconfigure') echo "<div class=\"selected\">"; else echo "<div>";?>
            <?php echo link_to(__('Konfiguracja MySQL', null, 'stInstallerWeb'),'stSetup/reconfigure');?>
    </div>
    <div style="clear:both"></div>
</ul>

