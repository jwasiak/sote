<?php use_stylesheet("backend/stInvoiceBackend.css"); ?>

<?php echo form_tag('stSlideBannerBackend/SaveConfigContent') ?>
<div>
  <fieldset id="sf_fieldset-none">
    <div class="st_fieldset-content" style="padding-bottom: 10px; padding-top: 10px;">

      <div class="row" style="padding: 4px 10px;">
        <label for="banner_banner_on" style="float: left; padding-right: 10px; text-align: right; width: 340px;"><?php echo __('Włącz baner') ?><?php echo ':' ?></label>
        <div class="field" style="margin-left: 230px;">
          <?php echo checkbox_tag('banner[banner_on]', 1, $bannerConfig['banner_on']) ?>
          <div class="clr"></div>
        </div>
      </div>
      
      
      <div class="row" style="padding: 4px 10px;">
        <label for="banner_banner_version" style="float: left; padding-right: 10px; text-align: right; width: 340px;"><?php echo __('Wersja') ?><?php echo ':' ?></label>
        <div class="field" style="margin-left: 230px;">      
          <select include_blank="" id="slide_banner_banner_version" name="banner[banner_version]">    
            <option class="none" value="1" <?php if($bannerConfig['banner_version']==1){ echo " selected";} ?>><?php echo __('Zdjęcie') ?></option>
            <option class="none" value="2" <?php if($bannerConfig['banner_version']==2){ echo " selected";} ?>><?php echo __('Zdjęcie z opisem') ?></option>                       
          </select>          
       <div class="clr"></div>
        </div>
      </div>   
      
      <div class="row" style="padding: 4px 10px;">
          
        <label for="banner_group_field_on" style="float: left; padding-right: 10px; text-align: right; width: 340px;"><?php echo __('Włącz grupy banerów') ?> <a class="help" title="<?php echo __('Opcja dla webmasterów dająca możliwość tworzenia kolejnych banerów w tematach indywidualnych') ?>" href="#"></a> :</label>
        <div class="field" style="margin-left: 230px;">
          <?php echo checkbox_tag('banner[group_field_on]', 1, $bannerConfig['group_field_on']) ?>
          <div class="clr"></div>
        </div>
      </div>

      <div class="row" style="padding: 4px 10px;">
        <label for="banner_ignore_language" style="float: left; padding-right: 10px; text-align: right; width: 340px;"><?php echo __('Ignoruj wersję językowe') ?> <a class="help" title="<?php echo __('Wyświetla wszystkie slajdy niezależnie od języka') ?>" href="#"></a><?php echo ':' ?></label>
        <div class="field" style="margin-left: 230px;">
          <?php echo checkbox_tag('banner[ignore_language]', 1, $bannerConfig['ignore_language']) ?>
          <div class="clr"></div>
        </div>
      </div>

      <?php if (!stTheme::hideOldConfiguration()): ?>

      <div class="row" style="padding: 4px 10px;">
        <label for="banner_caption_text_color" style="float: left; padding-right: 10px; text-align: right; width: 340px;"><?php echo __('Kolor tekstu') ?> <a class="help" title="<?php echo __('Kolor tekstu w opisie banera') ?>" href="#"></a><?php echo ':' ?></label>
        <div class="field" style="margin-left: 230px;">
          <?php echo input_tag("banner[caption_text_color]", $bannerConfig['caption_text_color'],array("size"=>"10px"))?>
          <div class="clr"></div>
        </div>
      </div>

      <div class="row" style="padding: 4px 10px;">
        <label for="banner_caption_background_color" style="float: left; padding-right: 10px; text-align: right; width: 340px;"><?php echo __('Kolor tła') ?> <a class="help" title="<?php echo __('Kolor tła w opisie banera') ?>" href="#"></a><?php echo ':' ?></label>
        <div class="field" style="margin-left: 230px;">
          <?php echo input_tag("banner[caption_background_color]", $bannerConfig['caption_background_color'],array("size"=>"10px"))?>
          <div class="clr"></div>
        </div>
      </div>

      <div class="row" style="padding: 4px 10px;">
        <label for="banner_effect" style="float: left; padding-right: 10px; text-align: right; width: 340px;"><?php echo __('Rodzaj zmiany') ?> <?php echo ':' ?></label>
        <div class="field" style="margin-left: 230px;">
          <?php echo select_tag('banner[effect]', options_for_select(
            array('random' => __('losowy'), 
                  'fade' => __('przenikanie'),
                  'fold' => __('fold'),
                  'sliceDown' => __('sliceDown'),
                  'sliceDownLeft' => __('sliceDownLeft'),
                  'sliceUp' => __('sliceUp'),
                  'sliceUpLeft' => __('sliceUpLeft'),
                  'sliceUpDown' => __('sliceUpDown'),
                  'sliceUpDownLeft' => __('sliceUpDownLeft'),
                  'slideInRight' => __('slideInRight'),
                  'slideInLeft' => __('slideInLeft'),
                  'boxRandom' => __('boxRandom'),
                  'boxRain' => __('boxRain'),
                  'boxRainReverse' => __('boxRainReverse'),
                  'boxRainGrow' => __('boxRainGrow'),
                  'boxRainGrowReverse' => __('boxRainGrowReverse')
                  ),
            array($bannerConfig['effect'])
          )) ?>
          <div class="clr"></div>
        </div>
      </div>

      <div class="row" style="padding: 4px 10px;">
        <label for="banner_pause" style="float: left; padding-right: 10px; text-align: right; width: 340px;"><?php echo __('Czas wyświetlania slajdu') ?> <?php echo ':' ?></label>
        <div class="field" style="margin-left: 230px;">
          <?php echo input_tag("banner[pause]", $bannerConfig['pause'],array("size"=>"10px"))?>
          <div class="clr"></div>
        </div>
      </div>

      <div class="row" style="padding: 4px 10px;">
        <label for="banner_anim" style="float: left; padding-right: 10px; text-align: right; width: 340px;"><?php echo __('Szybkość animacji') ?> <?php echo ':' ?></label>
        <div class="field" style="margin-left: 230px;">
          <?php echo input_tag("banner[anim]", $bannerConfig['anim'],array("size"=>"10px"))?>
          <div class="clr"></div>
        </div>
      </div>

      <?php endif; ?>

    </div>
  </fileset>
  </div>

  <?php echo st_get_admin_actions_head() ?>
    <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin')) ?>
  <?php echo st_get_admin_actions_foot() ?>

</form>
