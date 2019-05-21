<select>
<?php 
//pr($servicearray);die('op');


	foreach ($servicearray as $key => $value) {
		echo '<option>'.$value["start_time"]. ' ' .$value["end_time"].'</option>';
	}

?>
</select>