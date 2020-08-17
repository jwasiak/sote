<?php
use_helper('stCurrency');
st_theme_use_stylesheet('stDelivery.css');



if( $off_date_picker == 1)
{
   $smarty->assign('date_on', 0);
   $smarty->assign('time_on', 0);
}
else
{
   $smarty->assign('date_on', $config->get('date_on'));
   $smarty->assign('time_on', $config->get('time_on'));
}

if( $off_date_picker == 1 && $config->get('date_on')==0)
{
   $smarty->assign('time_on', $config->get('time_on'));
}


$smarty->assign('def_time',$time_h_def.':'.$time_m_def);

$time_limit=$config->get('time_h_limit').$config->get('time_m_limit');

if(date('Hi')>=$time_limit)
{
   $add_day = 1;
}
else
{
   $add_day = 0;
}

if($language == 'pl_PL')
{
   $regional = 'pl';
}
else
{
   $regional = 'other';
}


$smarty->display("basket_dateTime.html");
?>

 <script type="text/javascript">

        jQuery(function($){


	$.datepicker.regional['pl'] = {
		closeText: 'Zamknij',
		prevText: '&#x3c;Poprzedni',
		nextText: 'Następny&#x3e;',
		currentText: 'Dziś',
		monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec',
		'Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'],
		monthNamesShort: ['Sty','Lu','Mar','Kw','Maj','Cze',
		'Lip','Sie','Wrz','Pa','Lis','Gru'],
		dayNames: ['Niedziela','Poniedzialek','Wtorek','Środa','Czwartek','Piątek','Sobota'],
		dayNamesShort: ['Nie','Pn','Wt','Śr','Czw','Pt','So'],
		dayNamesMin: ['N','Pn','Wt','Śr','Cz','Pt','So'],
		dateFormat: 'yy-mm-dd', firstDay: 1,
		isRTL: false
        };

        $.datepicker.regional['other'] = {
		dateFormat: 'yy-mm-dd', firstDay: 1,
		isRTL: false
        };

	$.datepicker.setDefaults($.datepicker.regional['<?php echo $regional; ?>']);

        <?php if (isset($allowed_dates) && $allowed_dates): ?>
            var allowed_dates = [<?php echo $allowed_dates; ?>];
        <?php else: ?>
            var allowed_dates = [];
        <?php endif; ?>


        $('#datepicker').datepicker({


        <?php if($config->get('min')<=0): ?>
            minDate: <?php echo $add_day; ?>,
        <?php else: ?>
            minDate: <?php echo $config->get('min')+$add_day; ?>,
        <?php endif; ?>

        <?php if ($config->get('max')>0): ?>
            maxDate: <?php echo $config->get('max') ?>,
        <?php endif; ?>

        dateFormat: 'dd-mm-yy',


        beforeShowDay: function(date) {

            var current = $.datepicker.formatDate('dd-mm-yy', date);

            var weekend = date.getDay()>0 && date.getDay()<6;

            <?php if($config->get('weekends_on')==1): ?>
               var is_allowed = [weekend];
            <?php else: ?>
               var is_allowed = [true];
            <?php endif; ?>

            $.each(allowed_dates, function() {
               if (this.allow_date == current)
               {
                  is_allowed = [false];
               }
             
            });

         return is_allowed;
         }

        });



        $('#datepicker').datepicker('setDate', '<?php echo $default_date; ?>');


        $("#show24").timeEntry({

           show24Hours: true,
           defaultTime: new Date(0, 0, 0, <?php echo $time_h_def; ?>, <?php echo $time_m_def; ?>, 0),
           minTime: new Date(0, 0, 0, <?php echo $config->get('time_h_from') ?>, <?php echo $config->get('time_m_from') ?>, 0), 
           maxTime: new Date(0, 0, 0, <?php echo $config->get('time_h_to') ?>, <?php echo $config->get('time_m_to') ?>, 0) 

         });

         $('#st_user-register_form').submit(function() {
            <?php if($config->get('date_on')): ?>
            var date = document.getElementById("datepicker").value;
            post_input_date = $('<input type="hidden" name="delivery[date]" value="'+date+'" />');
            $('#st_user-register_form').append(post_input_date);
            <?php endif; ?>
            
            <?php if($config->get('time_on')): ?>
            var time = document.getElementById("show24").value;
            post_input_time = $('<input type="hidden" name="delivery[time]" value="'+time+'" />');
            $('#st_user-register_form').append(post_input_time);
            <?php endif; ?>
         });

         $('#st_user-login_form').submit(function() {
            <?php if($config->get('date_on')): ?>
            var date = document.getElementById("datepicker").value;
            post_input_date = $('<input type="hidden" name="delivery[date]" value="'+date+'" />');
            $('#st_user-login_form').append(post_input_date);
            <?php endif; ?>

            <?php if($config->get('time_on')): ?>
            var time = document.getElementById("show24").value;
            post_input_time = $('<input type="hidden" name="delivery[time]" value="'+time+'" />');
            $('#st_user-login_form').append(post_input_time);
            <?php endif; ?>
         });
         
          $('#user_delivery_form').submit(function() {
            <?php if($config->get('date_on')): ?>
            var date = document.getElementById("datepicker").value;
            post_input_date = $('<input type="hidden" name="delivery[date]" value="'+date+'" />');
            $('#user_delivery_form').append(post_input_date);
            <?php endif; ?>

            <?php if($config->get('time_on')): ?>
            var time = document.getElementById("show24").value;
            post_input_time = $('<input type="hidden" name="delivery[time]" value="'+time+'" />');
            $('#user_delivery_form').append(post_input_time);
            <?php endif; ?>
         });

        });

</script>