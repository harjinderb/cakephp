<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Child Payment Reciving')?></h1>
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="box box-primary">
					<div class="box-body">
						<div class="profile-info-left">
							<div class="profile-image">
							<?php 
								$payment_mode = array('Cash'=>__('Cash'),'Check'=>__('Check'),'Credit Card'=>__('Credit Card'),'Debit Card'=>__('Debit Card'));
								
                              if(!empty($user['image'])){
	                                echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$user['uuid'].'/'.$user['image'], ['alt' => 'John','class' => 'img-responsive max-width-user-pic','id'=>'UplodImg']),'',['escapeTitle' => false,]);
	                            }else{?>
                                                            
                                <img id="UplodImg" src ='<?php echo $this->request->webroot.'img/no-img.jpg';?>' alt="Image Name" />
                            <?php }?>
							</div>
							<h3 class="admin-name"><?= $user['firstname'].' '.$user['lastname']?></h3>
							
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('REG-ID')?></b>
									</div>
									<div class="col-xs-6">
										<p><?=__('REG-ID')?> 00<?=$user['registration_id']?></p>
									</div>
								</div>
							</div>
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('Gender')?></b>
									</div>
									<div class="col-xs-6">
										<p><?php if($user->gender == 1){?>
										<?=__('Male')?>
										<?php } else {?>
										<?=__('Female')?>
									<?php }?></p>
									</div>
								</div>
							</div>
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('DOB')?></b>
									</div>
									<div class="col-xs-6">
										<p> <?=date('d-m-Y', strtotime($user->dob));?></p>
									</div>
								</div>
							</div>
							
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('Contact Number')?></b>
									</div>
									<div class="col-xs-6">
										<p><?=$parent->mobile_no?></p>
									</div>
								</div>
							</div>
							
							
								
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="box box-primary">
					<div class="box-body">
						<div class="form-common">
							
								
								<div class="form-group border-btm-group">
									<div class="row">
										<div class="col-xs-6">
											<h4><?=__('Invoice Amount')?></h4>
										</div>
										<div class="col-xs-6">
											<?php 
													if($invpayments){?>
											
											<h4><?= '('.$GlobalSettings['currency'].' '.$GlobalSettings['currency_code'].')'.$invpayments->invoice_payment?></h4>
										<?php }?>
										</div>
									</div>
								</div>
								
								<?php echo $this->Form->create('',['class'=>'myform','type'=>'file']); ?>
								<div class="form-group border-btm-group">
									<div class="row">
										<div class="col-xs-6">
											<h4><?=__('Pay by Date')?></h4>
										</div>
										<div class="col-xs-6">
											<?php 
													if($invpayments){?>
											
											<h4><?= date('d-m-Y',strtotime($invpayments->invdue_date)) ?></h4>
											<?php }?>
										</div>
									</div>
								</div>
								<div class="form-group border-btm-group">
									<div class="row">
										<div class="col-xs-6">
											<h4><?=__('Pending Amount')?></h4>
										</div>
										<div class="col-xs-6">
											<h4><b><?= '('.$GlobalSettings['currency'].' '.$GlobalSettings['currency_code'].')'.$totalpendingpayment?></b></h4>
										</div>
									</div>
								</div>
								<?php
									//pr($user->bso_id);
								?>
								<div class="recive-paymnet-box">
									<div class="form-group">

										<label><?=__('Received Payment')?> <?= '('.$GlobalSettings['currency'].' '.$GlobalSettings['currency_code'].')'?></label>
										<?= $this->Form->control('paied_amt', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xx,xx,xx']);?>
									
									</div>
									<div class="form-group">
										<label><?=__('Mode of Paymnet')?></label>
										<?= $this->Form->control('payment_mode', ['options'=>$payment_mode,'empty'=>__('Please select Payment Mode'),'label' => false, 'class' => 'form-control']);?>
										 
										<?php
										if($invpayments){
											echo $this->Form->control('invoice_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $invpayments->id]);
											echo $this->Form->control('invoice_group', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $invpayments->invoice_group]);
											 echo $this->Form->control('child_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $user->id]);
											 echo $this->Form->control('bso_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $user->bso_id]);
											}
										  ?>
									</div>
									<div class="form-group text-right">
										<?= $this->Form->button('Payment',['class' => 'btn btn-theme btn-round-md']);
										?>
										
									</div>
								</div>
							<?php echo $this->Form->end(); ?>
						</div>
					</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			  
			</div>
		</div>	
		<div class="box box-primary">
            <div class="box-header bso-box-header">
				<h3 class="box-title"><?=__('Payment History')?></h3>
            </div>
            <?php
			echo $this->Form->control('childuu_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','id' => 'childuu_id','value'=> $user->uuid]);
			?>
            <div class="box-body">
				<div class="table-responsive">

				  <table id="payments" class="table table-striped table-hover v-center cell-pd-15">
					<thead>
					<tr>
					<th>
						<div class="cst-check">
							<input type="checkbox" class="cst-check__input">
							<span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span>
						</div>
					</th>
                  <th><?=__('Invoice Group Id')?></th>
                  <th><?=__('Name')?></th>
                  <th><?=__('Image')?></th>
                  <th><?=__('Gender')?></th>
				  <th><?=__('Invoice Date')?></th>
				  <th><?=__('Invoice Amount')?></th>
				  <th><?=__('Payment Status')?></th>
				  <th><?=__('Paied Amount')?></th>
				  <th><?=__('Balance')?></th>
				  <th><?=__('Payment Mode')?></th>
				<!--   <th><?php //__('Action')?></th> -->
                </tr>
					</thead>
					<tbody>
					
				
					</tbody>
					
				  </table>
				</div>
            </div>
            <!-- /.box-body -->
          </div>

    </section>
    <!-- /.content -->
  </div>