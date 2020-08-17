<div class="error_message" style="margin-top:5px">
    <?php echo __('Nie można zainstalować aktualizacji. System wykrył modyfikację kodu. Twoj system może nie działać poprawnie.', null, 'stInstallerWeb');?>
</div>
<br />
<h2 class="subhead_txt_module">
    <?php echo __('Zmodyfikowane pliki:', null, 'stInstallerWeb');?>
</h2>
<table border="0" width="100%">
    <?php foreach ($data as $app => $files):?>
        <tr>
            <th colspan="2" align="left">
                <?php echo $app;?>
            </th>
            <th>
                <?php echo __('Data modyfikacji', null, 'stInstallerWeb');?>
            </th>
        </tr>
        <?php foreach ($files as $file => $dat):?>
            <tr>              
                <td align="right">
                    -
                </td>
                <td align="left" style="padding-right:20px">
                    <?php echo str_replace(' / ', '/', $file);?>
                </td>           
                <td align="center" width="150">
                    <?php echo $dat['modified'];?>
                </td>
            </tr>
        <?php endforeach;?>
    <?php endforeach;?>
</table>
