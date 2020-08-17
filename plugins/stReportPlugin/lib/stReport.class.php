<?php
sfLoader::loadHelpers(array('Helper', 'stDate'));
/* Klasa bazowa modułu raportów*/

class stReport
{

   /* Zwraca dane statystyczne produktu dla zadanego przedziału dat*/
   public static function getProductValue($filters, $product)
   {            
       
            $total_netto = 0; 
            $total_brutto = 0;
            $total_count = 0;

            $from_date = $filters['from_date'];
            $to_date = $filters['to_date'];
                
            $c = new Criteria();
            $c->addSelectColumn(OrderProductPeer::CREATED_AT);
            $inverse = stConfig::getInstance('stCurrencyPlugin')->get('inverse');
            $c->addSelectColumn(sprintf($inverse ? "SUM(%s * %s / %s)" : "SUM(%s * %s * %s)", OrderProductPeer::PRICE, OrderProductPeer::QUANTITY, OrderCurrencyPeer::EXCHANGE));
            $c->addSelectColumn(sprintf($inverse ? "SUM(%s * %s / %s)" : "SUM(%s * %s * %s)", OrderProductPeer::PRICE_BRUTTO, OrderProductPeer::QUANTITY, OrderCurrencyPeer::EXCHANGE));
            $c->addSelectColumn(sprintf("SUM(%s)", OrderProductPeer::QUANTITY));
            $c->addJoin(OrderProductPeer::ORDER_ID, OrderPeer::ID);
            $c->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);

            $c->add(OrderProductPeer::PRODUCT_ID, $product->getId());
            $criterion = $c->getNewCriterion(OrderProductPeer::CREATED_AT , $from_date, Criteria::GREATER_EQUAL  );
            $criterion->addAnd($c->getNewCriterion(OrderProductPeer::CREATED_AT , $to_date, Criteria::LESS_EQUAL ));
            $c->add($criterion);

            OrderPeer::addStatusFilterCriteria($c, $filters);
                        
            $display_type = stReport::chartDisplayType($from_date,$to_date);                                
              
            if($display_type == "day" ){                    
                $range = stReport::createDaysRangeArray($from_date,$to_date);
                $chart_type = "line";    
                $c->addGroupByColumn(OrderProductPeer::CREATED_AT);                
            }elseif($display_type == "month" ){
                $range = stReport::createMonthsRangeArray($from_date,$to_date);
                $chart_type = "bar";
                $c->addGroupByColumn(sprintf('MONTH(%s)', OrderProductPeer::CREATED_AT)); 
                $c->addGroupByColumn(sprintf('YEAR(%s)', OrderProductPeer::CREATED_AT));
            }

            $rs = OrderProductPeer::doSelectRS($c);

            $data = array();
            $quantities = array(); 

            foreach ($range['data'] as $type_select) {
                $data[$type_select] = 0;
                $quantities[$type_select] = 0;
            }

            while($rs->next())
            {
                $row = $rs->getRow();
                $time = strtotime($row[0]);
                $date = $display_type == "day" ? date('Y-m-d', $time) : date('Y-m', $time).'-01';
                $price_netto = stPrice::round($row[1]);
                $data[$date] += $price_netto;
                $quantities[$date] += $row[3];
                $total_netto += $price_netto;
                $total_brutto += stPrice::round($row[2]);
                $total_count += $row[3];
            }
            
            $result['set_step'] = $total_count > 0;

            $culture = sfContext::getInstance()->getUser()->getCulture();

            $chart_dates = array();
           
            foreach ($range["data"] as $value) 
            {
                $chart_dates[] = $culture == 'pl_PL' ? date('d-m-Y', strtotime($value)) : date('n/j/Y', strtotime($value));
            }
            
            $result['chart_labels'] = json_encode($range['view']);
            $result['chart_data'] = json_encode(array_values($data));  
            $result['chart_quantity'] = json_encode(array_values($quantities)); 
            $result['chart_dates'] = json_encode($chart_dates);      
            
            $result['total_netto'] = $total_netto;            
            $result['total_brutto'] = $total_brutto;
            $result['total_count'] = $total_count;
            $result['chart_type'] = $chart_type;
            $result['display_type'] = $display_type;  
            $result['period'] = count($range['data']);

            /* var_export($result['chart_dates']); */
                                   
            return $result;
   }  
    
    /* Zwraca rodzaj prezentowanego wykresu w zależności od zakresu dat */
    public static function chartDisplayType($from_date,$to_date)
    {        
        $range = stReport::createDaysRangeArray($from_date,$to_date);
        if(count($range['data']) <=61 ){
            $display_type = "day";
        }else{
            $display_type = "month";
        }
        
        return $display_type;
    }
    
    /* Zwraca dane z podziałem na dni*/
    public static function createDaysRangeArray($strDateFrom,$strDateTo) {
        
      $aryRange=array();  
      $aryRangeView=array();
      $aryRangeData=array();
    
      $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),substr($strDateFrom,8,2),substr($strDateFrom,0,4));
      $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),substr($strDateTo,8,2),substr($strDateTo,0,4));
    
      if ($iDateTo>=$iDateFrom) {
        array_push($aryRangeView,date('d',$iDateFrom)); // first entry
        array_push($aryRangeData,date('Y-m-d',$iDateFrom)); // first entry
    
        while ($iDateFrom <= $iDateTo - 86400) {
          $iDateFrom+=86400; // add 24 hours
          array_push($aryRangeView,date('d',$iDateFrom));
          array_push($aryRangeData,date('Y-m-d',$iDateFrom));
        }      
      
      }
      
      $aryRange['view'] = $aryRangeView;
      $aryRange['data'] = $aryRangeData;
      
      return $aryRange;
      
    }

    /* Zwraca dane z podziałem na miesiąe*/
    public static function createMonthsRangeArray($date1,$date2)
    {
        $start    = new DateTime($date1);
        $start->modify('first day of this month');
        $end      = new DateTime($date2);
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);
        
        
        $aryRange=array();  
        $aryRangeView=array();
        $aryRangeData=array();
        

        $culture = sfContext::getInstance()->getUser()->getCulture();

        foreach ($period as $dt) {
            
            array_push($aryRangeView, $culture == 'pl_PL' ? $dt->format("m-Y") : $dt->format("j/Y"));
            array_push($aryRangeData,$dt->format("Y-m-d"));
        }
        
        $aryRange['view'] = $aryRangeView;
        $aryRange['data'] = $aryRangeData;
      
        return $aryRange;
    }
  

}
