<legend><h2><?php echo __('Graf', null, 'sfStats') ?></h2></legend>
<br />
<div id="placeholder" style="width:<?php echo sfConfig::get('app_sfStats_chart_width', 800) ?>px;height:<?php echo sfConfig::get('app_sfStats_chart_height', 300) ?>px"></div>
<br />

<script type="text/javascript" charset="utf-8">
    <?php if (sfConfig::get('app_sfStats_use_flot', true)): ?>
        
        jQuery(function() {
            
            // Use jQuery flot
            data=[{label:"title1",
            data: [
            <?php foreach ($stats as $key => $value): ?>
            [<?php echo $key * 1000, ', ', $value ?>],
            <?php endforeach; ?>
            ], <?php echo $graph ?>: {show: true}
            }];
            options = {
            xaxis: { mode: 'time', timeformat: "%d/%m/%y" },
            legend: { show: false }
            };
            jQuery.plot(jQuery("#placeholder"), data, options);
            
        });
        
    <?php else: ?>
    
        // Use Google charts API
        var chartParams = {
          'chs':  '<?php echo sfConfig::get('app_sfStats_chart_width', 800) ?>x<?php echo sfConfig::get('app_sfStats_chart_height', 300) ?>',
          'chd':  't:<?php echo implode($stats->getRawValue(), ',') ?>',
          'chls': '3',
          'chds': '0,<?php echo max($stats->getRawValue()) ?>',
          'cht':  'lc',
          'chco': '76A4FB',
          'chm':  'B,CFE0FF,0,0,0',
          'chg':  '10,25,1,5',
          'chxt': 'x,y',
          'chxl': '0:|<?php $i=0; foreach ($stats as $key => $value): if(fmod($i, ceil(count($stats)/10)) == 0) echo format_date($key), '|'; $i++; endforeach ?>',
          'chxr': '1,0,<?php echo max($stats->getRawValue()) ?>'
        };
        var chartParamsArray = [];
        for(key in chartParams) { chartParamsArray.push(key + "=" + chartParams[key]) };
        document.getElementById('placeholder').innerHTML = "<img src=\"http://chart.apis.google.com/chart?" + chartParamsArray.join('&') + "\" width=\"800\" height=\"300\">";
        
    <?php endif; ?>
</script>