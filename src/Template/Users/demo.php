<?

        if ($Setting['calendarfrmt'] == 'School calendar') {
            $date1 = date('Y-m-d', strtotime($Setting['schooldatestart']));
            $date2 = date('Y-m-d', strtotime($Setting['schooldateend']));
            $diff = abs(strtotime($date2) - strtotime($date1));
            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        } else {
            $months = 12;
        }
        $createddate = date("Y-m-d");
        $start_date = date("d-m-Y");
        $time = strtotime($start_date);
        $final = date("d-m-Y", strtotime("+10 days", $time));
        $alldates=[];

        foreach ($users['contracts'] as $key => $plan) {

	            $plandate = date('Y-m-d',strtotime($plan['start_date']));
	            $planday = $plan['service_day'];
	            $getplanday[] = $planday;

	            $next = 'next'.' '.$planday;
	            $nextdate = date('Y-m-d', strtotime($next , strtotime($plandate)));
	            $date1 = date('Y-m-d', strtotime($nextdate));
	            $date = new DateTime($date1);
	            $thisMonth = $date->format('m');

	            while ($date->format('m') === $thisMonth) {
	                $alldates[] = strtotime($date->format('Y-m-d'));
	                $date->modify($next);
	            }
                    //pr($alldates);
                         $keyc = $key;
                         $att = [];

                $final_charges = '';
                $total = '';
                $checkin_time = '';
                $checkout_time = '';
                $finalAttendanceArray = [];
                    $childAttandance =[];
                    $childAttandanceDatesheet = [];
                $i = 1;
                //$nextdate = date('Y-m-d', strtotime($next , strtotime($plan['start_date'])));
                //pr($users);die;
                    if(!empty($users['contracts'][$keyc]['attendances'])){
                        foreach ($users['contracts'][$keyc]['attendances'] as $key => $attendtt) {

                            $dateday =    date('l', strtotime($attendtt['date_time']));

                            //$alldates = [];
                            if($attendtt['type'] == 'Auth' && $attendtt['status'] == '1'){
                                $childAttandance[] = strtotime(date('Y-m-d', strtotime($attendtt['date_time'])));
                            }

                            $childAttandanceDatesheet[strtotime(date('Y-m-d', strtotime($attendtt['date_time'])))][] = $attendtt;
                        }

                        $result = array_diff($alldates,$childAttandance);
                        $resultmerge = array_merge($result,$childAttandance);
                        $finalAttendanceArray = array_unique($resultmerge);

                        sort($finalAttendanceArray);
                        $currentdate = strtotime($createddate);

                        $thisMonthcharges = 0;

                        //pr($finalAttendanceArray);die;

						//pr('===================After loop================');
                          $fullcharges = '';
                                    //$Overtime1 = '00:00:00';
                                    //$Overtime2 = '00:00:00';
                        foreach ($finalAttendanceArray as $key => $finalData) {
                             $plandaydate = date('Y-m-d', $finalData);

                            $dateday =    date('l', strtotime($plandaydate));

                            if($plan['service_day'] == strtolower($dateday)){
                               if (isset($childAttandanceDatesheet[$finalData])) {
                                    $checkin_time = date('H:i:s', strtotime($childAttandanceDatesheet[$finalData][0]['date_time']));

                                     $checkout_time = date('H:i:s', strtotime($childAttandanceDatesheet[$finalData][0]['date_time_end']));
                                } else {
                                    $checkin_time = '00:00:00';
                                     $checkout_time = '00:00:00';
                                }
                                $planestart_time = date('H:i:s', strtotime($plan['start_time']));
                                $planend_time = date('H:i:s', strtotime($plan['end_time']));
                                $workingcheckout_time = (strtotime($checkout_time));
                                $workingplanend_time = (strtotime($planend_time));
                                 $workingcheckin_time = (strtotime($checkin_time));
                                 $workingplanstart_time = (strtotime($planestart_time));
                                $a = new DateTime($checkout_time);
                                $b = new DateTime($planend_time);
                                $e =  new DateTime($checkin_time);
                                $f =  new DateTime($planestart_time);
                                // pr($e);
                                // pr($f);
                                if($workingcheckout_time > $workingplanend_time){
                                     $Overtimes  = $a->diff($b);
                                     $ovaf =  new DateTime($Overtimes->format("%H:%I:%S"));
                                     $ralaf =  new DateTime($Setting['relieftimeafterclass']);
                                     $Overtime  = $ovaf->diff($ralaf);
                                     //$Overtime = $Overtime->diff($Setting['relieftimeafterclass']);
                                    $Overtime1 = $Overtime->format("%H:%I:%S");
                                }
                                if($workingcheckin_time < $workingplanstart_time){
                                     $Overtimebf  = $f->diff($e);
                                     $ovbf =  new DateTime($Overtimebf->format("%H:%I:%S"));
                                     $ralbf =  new DateTime($Setting['relieftimebeforeclass']);
                                     $Overtime  = $ovbf->diff($ralbf);
                                     $Overtime2 = $Overtime->format("%H:%I:%S");
                                }
                                else{
                                    $Overtime ='00:00:00';
                                }
                                $time = $Overtime1;
                                $time2 = $Overtime2;
                                $secs = strtotime($time2)-strtotime("00:00:00");
                                $Overtime = date("H:i:s",strtotime($time)+$secs);

                                $c = new DateTime($planend_time);
                                $d = new DateTime($planestart_time);
                                $classtime = $c->diff($d);
                                $classtimehr = $classtime->format("%H");
                                $classtimemin = $classtime->format("%I");
                                $classtimehr = $classtimehr *60*60;
                                $classtimemin = $classtimemin *60;
                                $totaltimesec = $classtimehr + $classtimemin;
								if($plan['plan_type'] == 'price_yearly'){
                                     $year = $plan['price'];
                                    $month = round($year/$months);
                                    $daycharges = round($month/4);
                                    $persec_charges = $daycharges/$totaltimesec;
                                    $persec_overtimcharges = $Setting['overtimecost']/ 3600;
                                    if($workingcheckout_time > $workingplanend_time){
                                        $str_time = $Overtime;

                                        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

                                        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

                                         $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                         if(!empty($Setting['overtimecost'])){
                                             $Overtime_charges = $persec_overtimcharges * $time_seconds;
                                         }else{
                                            $Overtime_charges = $persec_charges * $time_seconds;
                                         }
                                    }
                                     elseif($workingcheckin_time < $workingplanstart_time){
                                         //echo $str_time = $Overtime;die('awe');
                                         $str_time = $Overtime;
                                        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

                                        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

                                         $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                         if(!empty($Setting['overtimecost'])){
                                             $Overtime_charges = $persec_overtimcharges * $time_seconds;
                                         }else{
                                            $Overtime_charges = $persec_charges * $time_seconds;
                                         }
                                     }
                                    else{
                                        $Overtime_charges = "00,00";
                                    }
                                }
                                if($plan['plan_type'] == 'price_monthly'){
                                    $month = round($plan['price']);
                                    $daycharges = round($month/4);
                                    $persec_charges = $daycharges/$totaltimesec;
                                     $persec_overtimcharges = $Setting['overtimecost']/ 3600;
                                    if($workingcheckout_time > $workingplanend_time){
                                         $str_time = $Overtime;

                                        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

                                        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

                                          $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;

                                         if(!empty($Setting['overtimecost'])){
                                             $Overtime_charges = $persec_overtimcharges * $time_seconds;
                                         }else{
                                            $Overtime_charges = $persec_charges * $time_seconds;
                                         }
                                    }
                                     elseif($workingcheckin_time < $workingplanstart_time){
                                         //echo $str_time = $Overtime;die('awe');
                                         $str_time = $Overtime;
                                        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

                                        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

                                         $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                         if(!empty($Setting['overtimecost'])){
                                             $Overtime_charges = $persec_overtimcharges * $time_seconds;
                                         }else{
                                            $Overtime_charges = $persec_charges * $time_seconds;
                                         }
                                     }
                                    else{
                                        $Overtime_charges = "00,00";
                                    }
                                }
                                if($plan['plan_type'] == 'price_weekly'){
                                    $daycharges = round($plan['price']);
                                    $persec_charges = $daycharges/$totaltimesec;
                                     $persec_overtimcharges = $Setting['overtimecost']/ 3600;
                                    if($workingcheckout_time > $workingplanend_time){
                                        $str_time = $Overtime;

                                        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

                                        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

                                         $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                         $Overtime_charges = $persec_charges * $time_seconds;
                                    }
                                     elseif($workingcheckin_time < $workingplanstart_time){
                                         //echo $str_time = $Overtime;die('awe');
                                         $str_time = $Overtime;
                                        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

                                        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

                                         $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                         if(!empty($Setting['overtimecost'])){
                                             $Overtime_charges = $persec_overtimcharges * $time_seconds;
                                         }else{
                                            $Overtime_charges = $persec_charges * $time_seconds;
                                         }
                                     }
                                    else{
                                        $Overtime_charges = "00,00";
                                    }
                                }
                                        $fullcharges = $daycharges + $Overtime_charges;

                                        if (in_array($finalData, $childAttandance)) {
                                            } else {
                                            //echo $daycharges;
                                            $fullcharges = $daycharges;
                                            }
                                        $total += $fullcharges;

                                    }

                                }
                            }    else {
                                        $planestart_time = date('H:i:s', strtotime($plan['start_time']));
                                        $planend_time = date('H:i:s', strtotime($plan['end_time']));
                                        $c = new DateTime($planend_time);
                                        $d = new DateTime($planestart_time);
                                        $classtime = $c->diff($d);
                                        $classtimehr = $classtime->format("%H");
                                        $classtimemin = $classtime->format("%I");
                                        $classtimehr = $classtimehr *60*60;
                                        $classtimemin = $classtimemin *60;
                                        $totaltimesec = $classtimehr + $classtimemin;
                                        $currentdate = strtotime($createddate);

                                if($plan['plan_type'] == 'price_yearly'){
                                            $year = $plan['price'];
                                            $month = round($year/$months);
                                            $daycharges = round($month/4);
                                            $persec_charges = $daycharges/$totaltimesec;
                                            // if($workingcheckout_time > $workingplanend_time){
                                            //     $str_time = $Overtime;

                                            //     $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

                                            //     sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

                                            //      $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                            //      $Overtime_charges = $persec_charges * $time_seconds;
                                            // }
                                            //  elseif($workingcheckin_time < $workingplanstart_time){
                                            //      //echo $str_time = $Overtime;die('awe');
                                            //      $str_time = $Overtime;
                                            //     $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

                                            //     sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

                                            //      $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                            //      $Overtime_charges = $persec_charges * $time_seconds;
                                            //  }
                                            // else{
                                                $Overtime_charges = "00,00";
                                            //}
                                        }
                                        if($plan['plan_type'] == 'price_monthly'){
                                            $month = round($plan['price']);
                                            $daycharges = round($month/4);
                                            $persec_charges = $daycharges/$totaltimesec;
                                            // if($workingcheckout_time > $workingplanend_time){
                                            //     $str_time = $Overtime;

                                            //     $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

                                            //     sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

                                            //      $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                            //      $Overtime_charges = $persec_charges * $time_seconds;
                                            // }
                                            //  elseif($workingcheckin_time < $workingplanstart_time){
                                            //      //echo $str_time = $Overtime;die('awe');
                                            //      $str_time = $Overtime;
                                            //     $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

                                            //     sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

                                            //      $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                            //      $Overtime_charges = $persec_charges * $time_seconds;
                                            //  }
                                            // else{
                                                $Overtime_charges = "00,00";
                                            //}
                                        }
                                        if($plan['plan_type'] == 'price_weekly'){
                                            $daycharges = round($plan['price']);
                                            $persec_charges = $daycharges/$totaltimesec;
                                            // if($workingcheckout_time > $workingplanend_time){
                                            //     $str_time = $Overtime;

                                            //     $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

                                            //     sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

                                            //      $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                            //      $Overtime_charges = $persec_charges * $time_seconds;
                                            // }
                                            //  elseif($workingcheckin_time < $workingplanstart_time){
                                            //      //echo $str_time = $Overtime;die('awe');
                                            //      $str_time = $Overtime;
                                            //     $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

                                            //     sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

                                            //      $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                            //      $Overtime_charges = $persec_charges * $time_seconds;
                                            //  }
                                            // else{
                                                $Overtime_charges = "00,00";
                                            // }
                                        }
                                            //pr($alldates);die;
                                        $alldates = array_unique($alldates);
                                            $fullcharges = $daycharges;
                                            foreach ($alldates as $key => $finalData) {
                                                 $plandaydate = date('Y-m-d', $finalData);
                                                 $dateday =    date('l', strtotime($plandaydate));
                                            if($plan['service_day'] == strtolower($dateday)){
                                        $total += $fullcharges;
                                            }
                                        }
            }
            $test_final += $total;

            //}
        }