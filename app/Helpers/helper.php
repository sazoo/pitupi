<?php

class Helper {
	
	public static  function slider_ticks($min, $max){
		$str_ticks = "[";
		while ($min <= $max) {
			$str_ticks = $str_ticks.$min.",";
			$min+=10000;
		}
		$str_ticks = $str_ticks."]";
		$str_ticks = str_replace(",]","]",$str_ticks);

		return $str_ticks;
	}


	public static  function slider_labels($min, $max){
		$str_ticks = "[";
		while ($min <= $max) {
			$str_ticks = $str_ticks.'"P'.$min.'"'.",";
			$min+=10000;
		}
		$str_ticks = $str_ticks."]";
		$str_ticks = str_replace(",]","]",$str_ticks);

		return $str_ticks;
	}

	public static function get_civil_status($civil_status){
		if($civil_status == 0){
			return 'Single';
		}

		if($civil_status == 1){
			return 'Married';
		}

		if($civil_status == 2){
			return 'Divorced';
		}

		if($civil_status == 3){
			return 'Widowed';
		}
	}

	public static function get_balance($id){
		$balance = DB::table('transaction')->select( DB::raw('SUM(amount) as amount') )
		                        ->where(['user_id' => $id, 
		                                 'transaction_type' => 0])
		                        ->groupBy('transaction_type')->get();

		if (count($balance)){
		 	return $balance[0]->amount; 
		}
		else{ 
		   return '0.00';
		}
	}

	public static function get_total_fund($loan_id,$amount){
		$fund = DB::table('transaction')->select( DB::raw('SUM(amount) as amount') )
		                        ->where(['transaction_type' => 1,
		                                 'loan_id' => $loan_id])
		                        ->groupBy('transaction_type')->get();

		if (count($fund)){
		 	return ($fund[0]->amount / $amount) * 100; 
		}
		else{ 
		   return '0';
		}                         
	}


}


?>