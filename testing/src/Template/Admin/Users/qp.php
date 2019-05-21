<?php

	$postcode = explode("-", trim($postcode));
	$query_string = '';
	if($postcode[0]){
	 	$query_string .= 	"WHERE  `wijkcode` like '%$postcode[0]%'";  
	}
	if(!empty($postcode[1])){
		$query_string .= " AND `lettercombinatie` LIKE  '%$postcode[1]%' ";	
	}
	if(!empty($postcode[2])){
		$query_string .= " AND `huisnr` LIKE  '%$postcode[2]%' ";	
	}
 	$query  = "SELECT * FROM  `pcdata` $query_string "; 	
	
	$data = $this->db->query($query)->result();
	
	//echo $sql = $this->db->last_query(); die;
	$test = array();
	if( count($data) > 0){		

		foreach ($data as $key => $value) {
			$test[$value->wijkcode."-".$value->lettercombinatie."-".$value->huisnr]['Straatnaam']  = $value->straatnaam    ;
			$test[$value->wijkcode."-".$value->lettercombinatie."-".$value->huisnr]['plaatsnaam']  = $value->plaatsnaam   ;
			$test[$value->wijkcode."-".$value->lettercombinatie."-".$value->huisnr]['gemeentenaam'] = $value->gemeentenaam;    				
				
		}
		  //row
		return $test;
	} else{
		return false;
	}