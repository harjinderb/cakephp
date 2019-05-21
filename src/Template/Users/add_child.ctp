<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1><?=__('Add Child')?></h1>
      <?= $this->Flash->render() ?>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="box box-primary">
         <div class="box-header bso-box-header">
            <div class="row">
               <div class="col-xs-7">
                  <h3 class="box-title"><?=__('Please enter child details')?></h3>
               </div>
               <div class="col-xs-5 text-right">
                <?php echo $this->Html->link(
                'Go to parent list',
                ['controller' => 'users', 'action' => 'parents'],
                ['escape' => false,'class'=>'btn btn-theme btn-round']);
            
	                     $relation = array('son'=>__('Son'),'daughter'=>__('Daughter'),'other'=>__('Other'));
	                    // pr($parents);die;
	                     $parent_id = $parents['id'];
	                     $post_code = $parents['post_code'];
	                     $address = $parents['address'];
	                     $Woonplaats=$parents['residence'];
                 	?>
               </div>
            </div>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
          
         	<?php echo $this->Form->create($user,['class'=>'myform','type'=>'file']); ?>
            	<div class="row">
                  <div class="col-md-2 col-sm-3">
                     <div class="form-group">
                        <div class="input-file-outer profile-input-file">
                           <div class="input-file-in">
                             <img id="UplodImg" src="<?php echo $this->request->webroot.'img/no-img.jpg';?>" alt="Image Name"/>
                           </div>
                           <input type="file" class="input-file" id="" onchange="readURL(this);">
                           <?= $this->Form->control('image', ['label' => false,'onchange'=>'readURL(this);','class'=>'input-file','type' => 'file','accept'=>'image/png, image/jpeg']);
                           ?>
                           <button class="btn btn-change-profile input-file-btn"> Upload Image..</button>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-10 col-sm-9">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label><?=__('First Name')?> *</label>
                              <?= $this->Form->control('firstname',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'First Name','type'=>'text']); 
                              ?>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label><?=__('Last Name')?> *</label>
                              <?= $this->Form->control('lastname',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Last Name','type'=>'text']); 
                              ?>
                             
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label><?=__('Date of Birth')?> *</label>
                              <?php 
                              if($user['dob'] != ''){

                                $dob = date('d-m-Y',strtotime($user['dob']));
                              }else{
                                $dob = '';
                              }
                              ?>
                             <?= $this->Form->control('dob',['type'=>'text','label' => false, 'class' => 'form-control', 'placeholder' => 'DOB','data-dtp'=>'dtp_QF1Am','id'=>'datepicker' ,'value'=> $dob]);?>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">

                              <label><?=__('Gender')?></label>
                              <?php if($user['gender'] =='1'){?>
                              <input name="gender" id="radio_48" class="with-gap radio-col-blue-grey" type="radio" value="1" type="hidden" checked="checked">
                              <label for="radio_48" class="radio-label"><?=__('Male')?></label>
                              <input name="gender" id="radio_49" class="with-gap radio-col-blue-grey" type="radio" value="2" type="hidden">
                              <label for="radio_49" class="radio-label"><?=__('Female')?></label>
                              <?php }else{?>
                              <input name="gender" id="radio_48" class="with-gap radio-col-blue-grey" type="radio" value="1" type="hidden">
                              <label for="radio_48" class="radio-label"><?=__('Male')?></label>
                              <input name="gender" id="radio_49" class="with-gap radio-col-blue-grey" type="radio" value="2" type="hidden" checked="checked">
                              <label for="radio_49"  class="radio-label"><?=__('Female')?></label>

                            <?php } ?>
                              
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label><?=__('Relation with child')?> *</label>
                              <?=$this->Form->input('relation_dropdown',['options'=>$relation,'empty'=>__('Please select relation'),'label' => false, 'class' => 'relation form-control show-tick','value'=>$user['relation']]);?>
                           </div>
                           
                        </div>
                        <div class="col-md-6">
                           <div class="form-group showrelation"  style="display:none;">
                                <label><?=__('Please specify relation with child')?> *</label>
                                <?= $this->Form->control('relation',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Relation with child','value' => '','type'=>'text']); ?>
                            </div>
                        </div>
                     </div>
                     <div class="row">
	                      <div class="col-md-6">
	                           <div class="form-group">
	                              <label><?=__('School')?> *</label>
	                              <?= $this->Form->control('school',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'School Name','type'=>'text']); ?>
	                           </div>
	                    </div>	
	                     <div class="col-md-6">
		                     <div class="form-group">
		                     	<label><?=__('Address')?> *</label><br>
                                <input name="group5" id="radio_50" class="with-gap radio-col-blue-grey" type="radio"> 
                                <label for="radio_50" class="radio-label">Same as parent</label>
                                <input name="group5" id="radio_51" class="with-gap radio-col-blue-grey" type="radio"> 
                                <label for="radio_51" class="radio-label">Differnt address</label>
		                        
		                     </div>
	                     </div>
                    
                     </div>
                      <div class="form-group Differnt">
                        <label><?=__('Pin Code')?> *</label>
                        <?= $this->Form->control('post_code', ['label' => false, 'class' => 'showdiff form-control', 'placeholder' => 'xxxx-xx-x','id'=>'autocomplete','data-mask'=>'0000-00-00']);?>
                        <div class="ui-widget" style="margin-top:2em; font-family:Arial">
                     </div>
                      </div>
                     <div class="form-group Differnt">
                        <label><?=__('Address (Area and Street)')?> *</label>
                        <?= $this->Form->control('address',   ['type'=>'textarea','label' => false, 'class' => 'showdiff form-control', 'placeholder' => 'Address','id'=>'address']);?>
                     </div>
                     <div class="form-group Differnt">
                        <label><?=__('City/District')?> *</label>
                        <?= $this->Form->control('residence', ['type'=>'textarea','label' => false, 'class' => 'showdiff form-control', 'placeholder' => 'Residence','id'=>'city']);?>
                     </div>
                      <div class="form-group Same" style="display:none">
                        <label><?=__('Post Code')?> *</label>
                        <?= $this->Form->control('post_code', ['label' => false, 'class' => 'showsame form-control','value'=> $this->Decryption->mc_decrypt($post_code,$parents['encryptionkey'])]);?>
                        <div class="ui-widget" style="margin-top:2em; font-family:Arial">
                            
                    </div>
                    </div>
                    <div class="form-group Same" style="display:none">
                        <label><?=__('Address (Area and Street)')?> *</label>
                        <?= $this->Form->control('address',   ['label' => false, 'class' => 'showsame form-control','value'=> $this->Decryption->mc_decrypt($address,$parents['encryptionkey'])]);?>
                    </div>
                    <div class="form-group Same" style="display:none">
                        <label><?=__('City/District')?> *</label>
                        <?= $this->Form->control('residence', ['label' => false, 'class' => 'showsame form-control','value'=> $this->Decryption->mc_decrypt($Woonplaats,$parents['encryptionkey'])]);?>
                    </div>
                    <div class="form-group">
                        <!--  -->
                        <?= $this->Form->control('parent_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=>$parent_id]);?>
                    </div>
                     
                     <div class="form-group text-right">
                     	<?= $this->Form->button(__('Add Child'),['class' => 'btn btn-theme btn-round-md']);
                        ?>
                        
                     </div>
                  </div>
               </div>
           <?php echo $this->Form->end(); ?>  
         </div>
         <!-- /.box-body -->
      </div>
      <!-- /.box -->
   </section>
   <!-- /.content -->
</div>
<!-- Page script -->
