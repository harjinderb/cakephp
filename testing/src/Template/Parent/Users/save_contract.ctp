<section class="content">
	<div class="container-fluid">
		<center><h1>Welcome To Payment</h1></center>
		<div class="block-header payment">
			<p class="margen"><b>Online Payment</b></p>
			<?php 
	
				echo $this->Form->create('service',['class'=>'','type'=>'file','controller' => 'users', 'action' => 'payService', 'prefix' => 'parent']); 
				echo $this->Form->control('bso_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $bso_id]);
				echo $this->Form->control('parent_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $parent_id]);
				echo $this->Form->control('child_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $child_id]);
				echo $this->Form->control('planid[]', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> json_encode($planides)]);
				
			?>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-12 paymentoption">
						<a href="#"><img src="<?= BASE_URL;?>/img/paypal.png" alt="user" class="table-img-thumb img-circle"></a>
						<label><b>Pay with paypal</b></label>
						<div class="check-box-cs paycheckboxes">
								<input id="paypal" class="filled-in chk-col-green cheks " type="checkbox" value="100">
								<label for="paypal"></label>
						</div>
					</div>
					<div class="col-sm-12 paymentoption">
						<a href="#"><img src="<?= BASE_URL;?>/img/ideal.png" alt="user" class="table-img-thumb img-circle"></a>
						<label><b>Pay with ideal</b></label>
						<div class="check-box-cs paycheckboxes">
								<input id="ideal" class="filled-in chk-col-green cheks " type="checkbox" value="200">
								<label for="ideal"></label>
						</div>
					</div>
					<div class="col-sm-12 paymentoption">
						<a href="#"><img src="<?= BASE_URL;?>/img/visa.png" alt="user" class="table-img-thumb img-circle"></a>
						<label><b>Pay with visa card</b></label>
						<div class="check-box-cs paycheckboxes">
							<input id="visa-card" class="filled-in chk-col-green cheks " type="checkbox" value="300">
							<label for="visa-card"></label>
						</div>
					</div>
					<div class="col-sm-12 paymentoption">
						<a href="#"><img src="<?= BASE_URL;?>/img/mastercard.png" alt="user" class="table-img-thumb img-circle"></a>
						<label><b>Pay with master card</b></label>
						<div class="check-box-cs paycheckboxes">
							<input id="master-card" class="filled-in chk-col-green cheks " type="checkbox" value="400">
							<label for="master-card"></label>
						</div>
					</div>
				</div>
			</div>
			<?php 
			echo  $this->Form->button('Pay Service',['class' => 'btn bg-blue-grey onlinepayment']);
			echo $this->Form->end(); ?>	
		</div>
		<div class="block-header payment">
			<p class="margen"><b>Ofline Payment</b></p>
			<?php 
				echo $this->Form->create('invoice',['class'=>'','type'=>'file', 'url' => ['controller' => 'users', 'action' => 'offlinePayment','prefix' => 'parent']]); 
				 #echo $this->Form->create('invoice',['class'=>'','type'=>'file', 'url' => ['controller' => 'users', 'action' => 'offlinePayment', '_ext'=>'pdf', 'prefix' => 'parent']]); 
				 echo $this->Form->control('bso_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $bso_id]);
				 echo $this->Form->control('parent_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $parent_id]);
				 echo $this->Form->control('child_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $child_id]);
				 echo $this->Form->control('planid[]', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> json_encode($planides)]);
				 echo  $this->Form->button('Invoice',['class' => 'btn bg-blue-grey offline']);
			?>
			<?php echo $this->Form->end(); ?>	
		</div>
	</div>
</section>