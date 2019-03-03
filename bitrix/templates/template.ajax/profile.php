<?
    // function dump($var = null)
    // {
    // 	if($_GET['dump'] == 'on'){
    // 		if ($var == null) $var = 'Show test message';
    // 		echo '<pre style="clear: both; text-align: left; font: 12px Courier New, monospace;">';
    // 		print_r($var);
    // 		echo '</pre>';
    // 	}
    // }

    // function getWord($number, $suffix = array('день', 'дня', 'дней')) {
    //     $keys = array(2, 0, 1, 1, 1, 2);
    //     $mod = $number % 100;
    //     $suffix_key = ($mod > 7 && $mod < 20) ? 2: $keys[min($mod % 10, 5)];
    //     return $suffix[$suffix_key];
    // }
  
    function developDate($devYear){
        $curYear = date('Y');
        if ($devYear < $curYear) {
          $html = '&copy;&nbsp;'.$devYear.'—'.$curYear;
        }
        else {
          $html = '&copy;&nbsp;'.$devYear;
        }
        $html = $html.' '.$_SERVER['HTTP_HOST'];
        return $html;
    }

    function date2msql($date)
    {
        if($date) {
            list($day, $month, $year) = split('[/.-]', $date);
            $date = $year.'-'.$month.'-'.$day;
            return $date;
        }
        else {
            return false;
        }
    }

    function msql2date($date, $d = true, $m = true, $y = true)
    {
        if($date) {
            list($date, $time) = split(' ', $date);
            list($year, $month, $day) = split('-', $date);
            
            if($d){
                $date = $day;
            }
            if($m){
                if($d) $date.= '.';
                $date.= $month;
            }
            if($y){
                if($m) $date.= '.';
                $date.= $year;
            }
            
            //$date = $day.'.'.$month.'.'.$year;
            
            return $date;
        }
        else {
            return false;
        }
    }

  
?>