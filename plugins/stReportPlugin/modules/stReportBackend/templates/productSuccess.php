<?php
use_helper('I18N', 'stAdminGenerator', 'stJQueryTools','stCurrency', 'stOrder', 'stPrice', 'stJQueryTools', 'stProductImage', 'stDiscount','Validation', 'stDate');
sfLoader::loadHelpers('stProduct', 'stProduct');
?>
<script type="text/javascript" src="/js/backend/chart.bundle.min.js"></script>


<style>
.error_label{

    color: #c62929;
    padding: 5px 10px;

    background-color: #fff4f2;
    border: 1px solid #f3c0c0;
    margin-bottom: 10px;

}    

.list_filters select, .list_filters input {
    vertical-align: middle;
}

#filters_from_date, #filters_to_date {
    width: 75px;
}

#date-filters {
    display: inline-block;
}

#date-filters li {
    display: inline-block;
}

#total_amount {
    text-align: left;
    margin-top: 10px;
} 

#total_amount > div {
    margin-bottom: 10px;
}

#filters_period {
    text-align: right;
    margin-bottom: -20px;
}

#filters_period li {
    display: inline-block;
    margin-left: 5px;
}

#filter_message {
    text-align: center;
}

</style>

<?php st_include_partial('stProduct/header', array(
    'related_object' => $product, 
    'title' => __('Raport'), 
    'culture' => null, 
    'route' => null,
)) ?>

<?php st_include_partial('stAdminGenerator/message', array('labels' => $labels)); ?>

<div id="sf_admin_content" style="margin-top: 5px;">


    <?php 
        $datetime1 = date_create($from_date);
        $datetime2 = date_create($to_date);
        $interval = date_diff($datetime1, $datetime2);
        
        $period = $result['display_type']=="day" ? $interval->days : $result['period'];
    ?> 

    <form action="<?php echo url_for('stReportBackend/product?id='.$product->getId()) ?>" method="post" style="margin-bottom: 10px">
        <div class="list_filters">
            <ul class="header">
                <li><?php echo __('Status zamówienia') ?> <?php echo st_get_partial('stOrder/filter_order_status', array('filters' => $filters)) ?></li>
                <li><?php echo __("Okres sprzedaży")?> 
                    <?php echo input_date_tag('filters[from_date]', $from_date, _parse_attributes(array (
                        'rich' => true,
                        'withtime' => false,
                        'culture' => $sf_user->getCulture(),
                        'calendar_button_img' => '/sf/sf_admin/images/date.png',
                        'readonly' => 'readonly',
                        'class' => 'filters_date_range',
                    ))); ?>
                    - 
                    <?php echo input_date_tag('filters[to_date]', $to_date, _parse_attributes(array (
                        'rich' => true,
                        'withtime' => false,
                        'culture' => $sf_user->getCulture(),
                        'calendar_button_img' => '/sf/sf_admin/images/date.png',
                        'readonly' => 'readonly',
                        'class' => 'filters_date_range',
                    ))) ?>
            
                </li>
                <li>
                    <input type="submit" value="<?php echo __('Filtruj', null, 'stAdminGeneratorPlugin') ?>" style="background-image: url('/images/backend/beta/icons/16x16/search.png'); cursor: pointer; background-repeat: no-repeat; background-position: 5px center; background-color: #eee; line-height: 16px; min-height: 26px; padding: 3px 5px box-sizing: padding-box; -webkit-box-sizing:padding-box; -moz-box-sizing: padding-box; -ms-box-sizing: padding-box; margin-left: 10px; padding-left: 30px; padding-top: 5px; margin-top: -1px;">
                </li>
            </ul>
            <div class="clr"></div>
        </div>
        <div id="filters_period">
            <ul>
                <?php foreach ($periods as $date => $label): ?>
                    <li><button type="submit" name="filters[period]" value="<?php echo $date ?>"><?php echo $label ?></button></li>
                <?php endforeach ?>
            </ul>
        </div>
        <div style="text-align: center;"><?php echo __('Wartość sprzedaży netto') ?> (<?php echo $period." ";
         if($result['display_type']=="day"){
            if($period==1){
                echo __('dzień');    
            }else{
                echo __('dni');
            }    
        }else{
            if($period<=5){
            echo __('miesiące');    
            }else{
                echo __('miesięcy');
            }
        }

        ?>)</div>


            <canvas style="margin-top: 10px;" id="myChart" width="1180" height="270"></canvas>
            
            <div id="total_amount">
                <div>
                    <?php echo __('netto') ?>: <?php echo st_back_price($result['total_netto'], true, true) ?><br/>
                    <?php echo __('brutto') ?>: <?php echo st_back_price($result['total_brutto'], true, true) ?><br/><br/>
                    <?php echo __('ilość') ?>: <?php echo $result['total_count']; ?>
                </div>
                <?php if ($result['total_count'] > 0): ?>
                    <button id="order-view" type="button" style="background-image: url('/images/backend/beta/icons/22x22/reports.png'); cursor: pointer; background-repeat: no-repeat; background-position: 5px center; background-color: #eee; line-height: 16px; min-height: 26px; padding: 3px 5px box-sizing: padding-box; -webkit-box-sizing:padding-box; -moz-box-sizing: padding-box; -ms-box-sizing: padding-box; padding-left: 30px; padding-top: 5px; "><?php echo __('Pokaż zamówienia') ?></button>
                <?php endif ?>
            </div>
            <script>
            jQuery(function($) {
                var quantites = <?php echo $result['chart_quantity'] ?>;
                var chart_dates = <?php echo $result['chart_dates'] ?>;
                var display_type = "<?php echo $result['display_type'] ?>";
                $('#order-view').click(function() {
                    var params = [];
                    params.push('filters[order_product]=<?php echo $product->getId() ?>');
                    params.push('filters[filter_order_status]='+$('#filters_filter_order_status').val());
                    params.push('filters[created_at][from]='+$('#filters_from_date').val()+' 00:00:00');
                    params.push('filters[created_at][to]='+$('#filters_to_date').val()+' 23:59:59');
                    params.push('filters[_expanded]');
                    window.location = "<?php echo url_for('stOrder/list') ?>?"+params.join('&');
                });

                $('#filters_period').change(function() {
                    if ($(this).val()) {
                        $('.filters_date_range').prop('disabled', true);
                    } else {
                        $('.filters_date_range').prop('disabled', false);
                    }
                }); 

                $('#trigger_filters_from_date, #trigger_filters_to_date').click(function(e) {
                    e.stopImmediatePropagation();
                    e.event.stopPropagation();

                    return false;
                });

                var chart = $("#myChart");

                var data = {
                    labels: <?php echo $result['chart_labels']; ?>,
                    datasets: [
                        {
                            label: "",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(75,192,192,0.4)",
                            borderColor: "rgba(75,192,192,1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(75,192,192,1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(75,192,192,1)",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 3,
                            pointHitRadius: 10,
                            pointStyle: "circle",            
                            data: <?php echo $result['chart_data']; ?>,
                        }
                    ]
                };

                var options = {  
                    hover: {
                        onHover: function(data) {
                            if (display_type == "month") {
                                if (data.length && quantites[data[0]._index] > 0) {
                                    chart.css({ cursor: 'pointer' });
                                } else {
                                    chart.css({ cursor: 'default' });
                                }
                            }
                        }
                    },   
                    onClick: function(e) {
                        if (display_type == "month") {
                            var elements = this.getElementsAtEvent(e);

                            if (elements.length && quantites[elements[0]._index] > 0) {

                                window.location = chart.closest('form').attr('action')+'?filters[filter_order_status]='+$('#filters_filter_order_status').val()+'&filters[expand_date]='+chart_dates[elements[0]._index];
                            }
                        }
                    },        
                    responsive: false,
                    maintainAspectRatio: true,
                    legend: { display: false },
                    tooltips: {
                                enabled: true,
                                mode: 'single',
                                callbacks: {
                                    beforeLabel: function(tooltipItems, data) { 
                                        return "<?php echo __('ilość') ?>: "+quantites[tooltipItems.index];
                                    },
                                    label: function(tooltipItems, data) { 
                                        
                                        return "<?php echo __('netto') ?>: "+tooltipItems.yLabel + ' <?php echo $default_currency ?>';
                                    }
                                    <?php if ($result['display_type'] == "day"): ?>
                                    ,title: function(tooltipItems, data) {

                                        return chart_dates[tooltipItems[0].index]; 
                                    }
                                    <?php endif ?>
                                }
                            },       
                    scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true,
                                    <?php if(!$result['total_count']): ?>
                                    stepSize: 1,
                                    <?php endif; ?>
                                    userCallback: function(value, index, values) {
                                        value = Number(value);
                   

                                        return (options.scales.yAxes[0].ticks.stepSize == 1 || value > 10 || value == 0 ? value.toFixed(0) : value.toFixed(1)) + ' <?php echo $default_currency ?>';
                                    }
                                }
                            }]
                        } 
                }

                var myLineChart = new Chart(chart.get(0), {
                    type: '<?php echo $result['chart_type']; ?>',
                    data: data,
                    options: options
                });
            });
            </script>
    </form>
</div>

<br class="st_clear_all" />
<?php echo st_get_admin_foot(); ?>
 


