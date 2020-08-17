<?php use_helper('Validation', 'I18N') ?>
<div id="sf_guard_container" align="center">
    <div id="sf_frame_login_top"></div>
    <div id="sf_frame_login_middle" align="center">

        <div id="background_frame_login">
            <br>                                             
            <span id="txt_login"><?php echo __('Korzystasz z przeglądarki')?>&nbsp;<b><?php echo __('Internet Explorer')?>&nbsp;<?php echo $ie ?></b>. &nbsp;<img src="/images/backend/browser/ie.gif" alt=""/></span>
            <br>
        </div>
        
        <div id="background_frame_login">
        <br>
                  <div style="margin: 15px; text-align: justify;"><?php echo __('Panel administracyjny sklepu wykorzystuje technologię, której przeglądarka Internet Explorer nie jest w stanie wykorzystać. Prosimy skorzystać z innej przeglądarki. Poniżej przedstawiono listę przeglądarek, dzięki którym będzisz mógł zalogować się do panelu administracyjnego i w pełni wykorzystać jego funkcjonalność. Pobranie, instalacja oraz użytkowanie tych przeglądarek jest ')?><b><?php echo __('całkowicie darmowe')?></b>.</div>
                     <br>        <br>           
            <div id="frame_login">
                
                <table width="100%" cellpadding="2" cellspacing="2">
                    <tr>
                        <td width="30%"><img src="/images/backend/browser/firefox.png" alt=""/></td>
                        <td align="left" width="50%"><a href="http://sote.pl/trac/wiki/doc/webbrowsers#FireFox" target="_blank"><?php echo __('Instrukcja instalacji przeglądarki FireFox')?></td>
                        <td align="left" width="20%"><a href="http://download.mozilla.org/?product=firefox-3.5.3&amp;os=win&amp;lang=pl" target="_blank"><?php echo __('pobierz')?></td>
                    </tr>
                
                    <tr>
                        <td width="30%"><img src="/images/backend/browser/chrome.png" alt=""/></td>
                        <td align="left"><a href="http://sote.pl/trac/wiki/doc/webbrowsers#Chrome" target="_blank"><?php echo __('Instrukcja instalacji przeglądarki Chrome')?></td>
                        <td align="left" width="20%"><a href="http://www.google.com/chrome" target="_blank"><?php echo __('pobierz')?></td>
                    </tr>
                                
                    <tr>
                        <td width="30%"><img src="/images/backend/browser/opera.png" alt=""/></td>
                        <td width="30%" align="left"><a href="http://sote.pl/trac/wiki/doc/webbrowsers#Opera" target="_blank"><?php echo __('Instrukcja instalacji przeglądarki Opera')?></td>
                        <td align="left" width="20%"><a href="http://operapl.net/pobierz/opera/windows/intel/" target="_blank"><?php echo __('pobierz')?></td>
                    </tr>
                </table>
                    
            </div>
            
        </div>
        
        </div>
    <div id="sf_frame_login_bottom"></div>
    <br class="clear"/>
</div>

        <div id="st_backend_logo" style="margin-right:10px;">
            <?php echo link_to(image_tag('backend/main/icons/logo_admin_sote.gif'),"http://www.sote.pl", array("target"=>"_blank")); ?>
        </div>

