<?php use_helper('I18N') ?>

<?php echo __('Wysyłanie wiadomości %completed%/%from% zakończone sukcesem.', array('%completed%' => $steps, '%from%' => $steps)) ?>


<ul class="admin_actions">
    <li class="action-list">
        <input type="button" onclick="document.location.href='<?php echo "/backend.php/newsletter/edit?id=".$id; ?>';" value="<?php echo __('Powróć do edycji');?>" style="background-image: url('/images/backend/beta/icons/16x16/edit.png')" >
    </li>   
    <li class="action-list" style="float:right;"><input type="button" onclick="document.location.href='/backend.php/newsletter';" value="<?php echo __('Lista wiadomości');?>" style="background-image: url(/images/backend/icons/list.png)" name="list"></li>
</ul>
