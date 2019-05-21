<section class="content">
	<div class="container-fluid">
		<div class="block-header">
<h1>Welcome To Payment</h1>

<?php 
//  pr($planides);
//  echo $child_id;
// // echo $bso_id;
// die;
echo $this->Form->create('service',['class'=>'','type'=>'file','controller' => 'users', 'action' => 'payService', 'prefix' => 'parent']); 
			
			echo $this->Form->control('bso_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $bso_id]);
			echo $this->Form->control('parent_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $parent_id]);
			echo $this->Form->control('child_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $child_id]);
			

	echo $this->Form->control('planid[]', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> json_encode($planides)]);
		echo  $this->Form->button('Pay Service',['class' => '']);
		
		?>
		<?php echo $this->Form->end(); ?>	
	</div>
	</div>
</section>