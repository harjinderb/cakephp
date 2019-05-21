<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>INVOICE </h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-sm-6">
								<h2>
									INVOICE
								</h2>
							</div>
							<div class="col-sm-6">
								<?php echo $this->Html->link('Send Invoice In Mail',['controller' => 'users', 'action' => 'offlinePayment',$childuuid, 'prefix' => 'parent'],['escapeTitle' => false,'class'=>'btn bg-blue-grey','style'=> 'float: right;']);
                            	?>
							</div>
						</div>
					</div>
					<div class="body">
						<div class="bso-aggrement">
							<div class="row">
							
								
								<div class="col-ms-4 col-sm-4">
									<label>Your Selected Plans:</label>
									
									<?php 
									//pr($save);die('freach');
									foreach ($save as $key => $value) {

										$planid[]= $value['plan_id'];
											if($value['service_type']== 'voorschoolse'){
										$class="plan-head bg-teal";
										//$button="btn bg-teal";
										}elseif ($value['service_type']== 'tussenschoolse') {
											$class="plan-head bg-light-blue";
											//$button="btn bg-light-blue";
										}else{
											$class="plan-head bg-cyan";
											//$button="btn bg-cyan";
										}
									?>
									<div class="single-plan">
										<div class="<?= $class ;?>">
											<h1 class="plan-name">
												<?= $value['service_type'];?>
											</h1>
											<h3 class="plan-day">
												<?= $value['service_day'];?>
											</h3>
										</div>
										<?php 
										 	$stime = explode(",", $value->start_time);
										 	$etime = explode(",", $value->end_time);
										
										?> 
										<div class="plan-info">
											<ul>
												<li><span><b>Start Time :</b></span> <span class="plan-val"><?= $stime[1];?></span></li>
											<li><span><b>End Time :</b></span> <span class="plan-val"><?= $etime[1];?></span></li>
												<li class="plan-divider">Price:</li>
												<li class="price-info">€ <?= $value['price'];?> <span class="price-type">/<?= $value['plan_type'];?></span></li>
											</ul>
										</div>
									</div>
									<?php }
									$bsoid = $save[0]['bso_id'];
									?>
								</div>
								
								<?php 
								//pr($school);die;
								$dobnew = date('d-m-Y', strtotime($user['dob']));

								?>
								<div class="col-md-8 col-sm-4">
									<div class="row clearfix">

<!----------------------------------------------------------------------->

					<div class="header">
						<div class="row">
							<div class="col-sm-6">
								<h2>
									Invoice Details
								</h2>
							</div>
							<div class="col-sm-6">
							
								
									<div class="col-sm-3">
										<label>Due date:</label>
									</div>
									<div class="col-sm-9">
										<p><?= '30/09/2018' ;?></p>
									</div>
								
							
							</div>
						</div>
					</div>
					
				<div class="body">
					<div class="bso-aggrement">
						<h4>Invoice  for the payment</h4>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Gegevens Kind:</label>
									</div>
									<?php //pr($bso);die; ?>

									<div class="col-sm-9">
										<p>Name:<?=$user['firstname'].$user['lastname'];?></p>
										<p>Geboortedatum: <?= date('d-m-Y', strtotime($user['dob'])) ;?></p>
										<p>Contractnummer: <?=$parent['mobile_no'];?></p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Opvangsoort:</label>
									</div>
									<div class="col-sm-9">
										<p><?= RECEPTION_TYPE;  ?></p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Opvangorganisatie:</label>
									</div>
									<div class="col-sm-9">
										<p><?=$bso['firstname'].$bso['lastname'];?></p>
										<label>Locatie:</label>
										<p><?=$parent['address'];?><br>
											<?=$parent['residence'];?><br>
											<?=$parent['post_code'];?>
										</p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Registratienummer:</label>
									</div>
									<div class="col-sm-9">
										<p>____</p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Ingangsdatum:</label>
									</div>
									<?php 
									//pr($price);die;
									$start_date = date("d-m-Y");
									$time = strtotime($start_date);
									if($save[0]['plan_type'] == "Day"){
										$amt =$amount;
										$month ='';
										$hours = round($difference / 3600* CONTRACT_WEEK);
										$amtpersec = $amt / $difference;
										$rate = $amtpersec * 3600;
										$final = date("d-m-Y", strtotime("+7 days", $time));
									}elseif($save[0]['plan_type'] == "Month"){
										
										 $amt =$amount;
										 $month ='Month';
										 $hours = round($difference / 3600* CONTRACT_MONTH);
										$amtpersec = $amt / $difference;
										$rate = $amtpersec * 3600;
										 $final = date("d-m-Y", strtotime("+1 month", $time)); 
									}elseif ($save[0]['plan_type'] == "year") {
										$amt =$amount;
										$month ='Year';
										$hours = round($difference / 3600 *CONTRACT_YEAR);
										$amtpersec = $amt / $difference;
										$rate = $amtpersec * 3600 ;
										$final = date("d-m-Y", strtotime("+1 year", $time));
									}
									
									?>
									<div class="col-sm-9">
										<p><?= $start_date ;?></p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Einddatum:</label>
									</div>
									<div class="col-sm-9">
										<p><?= $final ;?></p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Kosten  <?= $month ;?>  (2018):</label>
									</div>
									<div class="col-sm-9">
										<p>&euro; <?= $amt ;?></p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Aantal uren  <?= $month ;?>:</label>
									</div>
									<div class="col-sm-9">
										<p><?= $hours ;?></p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Gemiddeld uurtarief:</label>
									</div>
									<div class="col-sm-9">
										<p>&euro; <?= $rate ;?></p>
										<p class="text-small text-danger">*prijswijziging voorbehouden</p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<p class="m-t-70"><b>datum:- </b><?= $start_date; ?></p>
									</div>
								<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-6">
												<div class="ulpd-signature m-t-15">
													<label>handtekening ouder(s), verzorger(s):</label>
													<div class="upload-img">
														<div class="input-file-outer">
															<div class="input-file-in">
																<?php
																if(!empty($parent['clint_sign'])){?>
															<img id="UplodImg" src ="<?php echo BASE_URL."/".USER_PICTURE_FOLDER_URL_PATH."/".$parent['uuid']."/".$parent['clint_sign'];?>" alt="Image Name" />
																
															<?php }else{ ?>
															
																<img id="UplodImg" src ='<?php echo $this->request->webroot.'img/no-img.jpg';?>' alt="Image Name" />
															<?php }?>
															</div>	


					</div>
				</div>



<!--------------------------------------------------------------------------->			
		</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	function readURL(input) {
	          if (input.files && input.files[0]) {
	              var reader = new FileReader();
	
	              reader.onload = function (e) {
	                  $('#UplodImg')
	                      .attr('src', e.target.result)
	                      .width(150)
	                      .height(150);
	              };
	
	              reader.readAsDataURL(input.files[0]);
	          }
	      }
</script>
