<?php use_helper('Javascript') ?>


<script type="text/javascript">
function prepareurl()
{
   
    var url = document.getElementById('input').value;
    var hash = document.getElementById('hash').value;
    var host = document.getElementById('host').value;
    
    document.getElementById('output1').value = url+'?partnerHash='+hash;
    
    document.getElementById('output2').value = "<a href='"+url+"?partnerHash="+hash+" target='_blank' >"+host+"</a>";
    
}

function select1()
{
      document.getElementById('output1').select();
}

function select2()
{
      document.getElementById('output2').select();
}


</script>

<p><?php echo __('Skorzystaj z automatycznego generowania linku partnerskiego. Opcja ta ułatwi Ci generowanie linków za pomocą, których klienci którym polecisz sklep dokonają zakupów rejestrowanych na Twoje konto.') ?></p>
<p><?php echo __('Wstaw link do dowolnej strony tego sklepu (np.')."<b>http://".$sf_request->getHost().'/</b>'.__('). Poniżej wygenerują się linki, które będą zawierały aktywację programu partnerskiego') ?></p>

<?php echo __('Wstaw link do strony sklepu') ?>:
<br />
<input type="text" id="input" onclick="prepareurl()" onchange="prepareurl()" onkeyup='prepareurl()' size="70" />
<br />
<div id="st_validate_error"></div>

<a style="cursor: pointer; cursor: hand;"><?php echo __('Zweryfikuj poprawność adresu'); ?></a>
<br /><br />
<?php echo __('Link partnerski do strony sklepu') ?>:
<br />
    <input type="text" id="output1" name="output1" onmouseover="select1();" readonly size="70" value="http://<?php echo $sf_request->getHost(); ?>/?partnerHash=<?php echo $partner_hash->getHash(); ?>" />
<br />
<?php echo __('Link partnerski do umieszczenia na stronie') ?>:
<br />
    <input type="text" id="output2" name="output2" onmouseover="select2();" readonly size="70" value="<a href='http://<?php echo $sf_request->getHost(); ?>/?partnerHash=<?php echo $partner_hash->getHash(); ?>' target='_blank' ><?php echo $sf_request->getHost(); ?></a>" />

<script type="text/javascript">
$('input').observe('change', 
function(event) { new Ajax.Updater('st_validate_error', '<?php echo url_for('stPartnerFrontend/ajaxValidateUrl', true) ?>', {
  parameters: { url: $F('input') }
});
 });
</script>

<input type="hidden" id="hash" value="<?php echo $partner_hash->getHash(); ?>">
<input type="hidden" id="host" value="<?php echo $sf_request->getHost(); ?>">

