<?php 
										if(empty($users->toArray())){
											echo '<tr><td colspan="8">No record found!</td></tr>';
										}
										
										$i='1';
										$actionlist = array('Action', 'Deactivate', 'Activate', 'Delete');
										foreach ($users as $key => $value) { 
											//pr($value);die;
										?>
									
									<tr>
										<td><div class="check-box-cs checkboxes">
								            	<input id="<?=$value['uuid'];?>" class="filled-in chk-col-red cheks" type="checkbox" value="<?=$value['id'];?>">
								           	 	<label for="<?=$value['uuid'];?>"></label>
								        	</div>
								    	</td>
							    		<input  class="filled-in chk-col-red" id="role" value="4" type="hidden">
							    		<input  class="filled-in chk-col-red" id="bso_id" value="<?=$value['bso_id'];?>" type="hidden">
								    	<input  class="filled-in chk-col-red" id="parent_id" value="<?=$value['parent_id'];?>" type="hidden">
										<td><?= $i;?></td>
										<td><?= $this->Decryption->mc_decrypt($value['bsn_no'],$value['encryptionkey'])?></td>
										<td><?= $this->Decryption->mc_decrypt($value['firstname'],$value['encryptionkey']).' '.$this->Decryption->mc_decrypt($value['lastname'],$value['encryptionkey'])?> </td>
										<td>
										    <?php
												if (!empty($value['image'])) {
												        echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH . $value['uuid'] . '/' . $value['image'], ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
												    } else {
												        echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
												}
										    ?>
										</td>
										
										<td><?= $this->Decryption->emailDecode($value['email'])?></td>
										 <td>
									        <?php if ($value['is_active'] == 0) {?>
									            <span class="label bg-red">Not Activated</span>
									        <?php } else {?>
									            <span class="label bg-green">Activated</span>
									        <?php }?>
									    </td>
										<td>
											<div class="cs-btn-group">
												<?php echo $this->Html->link(
									                'View',
									                ['controller' => 'users', 'action' => 'parentProfile', $value->uuid],
									                ['class' => 'btn bg-teal','escape' => false]); 
									            ?>
												<?php echo $this->Html->link(
									                'Edit',
									                ['controller' => 'users', 'action' => 'editParents',$value->uuid],
									                ['class' => 'btn bg-blue','escape' => false]); 
									            ?>
									            <?php echo $this->Html->link(
									                'Add Child',
									                ['controller' => 'users', 'action' => 'addChild',$value->uuid],
									                ['class' => 'btn bg-cyan','escape' => false]); 
									            ?>
									            <?php echo $this->Html->link(
									                'Add Guardian',
									                ['controller' => 'users', 'action' => 'addGuardian',$value->uuid],
									                ['class' => 'btn bg-light-green','escape' => false]); 
									            ?>

												<?php 
													if($value['is_active'] == 1){ 
														echo $this->Form->postLink(__('<i class="fa fa fa-eye-slash"> </i>'.'Deactivate'), ['controller' => 'users','action' => 'parentDeactivate', $value->uuid], ['class' => 'btn btn-warning','confirm' => __('Are you sure you want to Deactivate {0}', trim($this->Decryption->mc_decrypt($value['firstname'],$value['encryptionkey']).' '.$this->Decryption->mc_decrypt($value['lastname'],$value['encryptionkey']))),'escape' => false]);
													}

													if($value['is_active'] == 0){ 
														echo $this->Form->postLink(__('<i class="fa fa fa-eye-slash"> </i>'.' '.'Activate'), ['controller' => 'users','action' => 'parentActivate', $value->uuid], ['class' => 'btn btn-success','confirm' => __('Are you sure you want to Activate {0}', trim($this->Decryption->mc_decrypt($value['firstname'],$value['encryptionkey']).' '.$this->Decryption->mc_decrypt($value['lastname'],$value['encryptionkey']))),'escape' => false]);
													}

												echo $this->Form->postLink(__('Delete'), ['controller' => 'users','action' => 'delete',$value->uuid],
												 ['class' => 'btn bg-deep-orange','confirm' => __('Are you sure you want to Delete {0}', trim($this->Decryption->mc_decrypt($value['firstname'],$value['encryptionkey']).' '.$this->Decryption->mc_decrypt($value['lastname'],$value['encryptionkey']))),'escape' => false]);
												?>
												
											</div>
										</td>
									</tr>
									<?php $i++; } if (!empty($users->toArray())) {
										//pr($users);die;
    									?>
									<tr>
									    <td colspan="9">
									        <div class="btm-action pull-right">
									            <?=$this->Form->select('parent_id', $actionlist, ['multiple' => false, 'value' => [], 'label' => false, 'class' => 'form-control usersetup','disabled'=>true]);?>
									            <form>

									            </form>
									        </div>
									    </td>
									</tr>
									<?php }?>
		<script>
			$(document).ready(function() {
     			$('.usersetup').on('change', function() {
                    var selected = $(this).val();
	            	var role = $('#role').val();
            		var bso_id = $('#bso_id').val();
		            var parent_id = $('#parent_id').val();
		            var allCheck = [];
		            $("input[type=checkbox]").each(function() {
						if ($(this).is(':checked')) {
		                    var value = $(this).closest('tr').find($("input[type=checkbox]")).val();

		                    allCheck.push(value);
		                }
		            });
		                    
		    		if(selected == '1'){
		                $.confirm({
		                    theme: 'light',
		                    title: 'Alert!',content: 'Are you sure you want to Deactivate !',
		                    buttons: {
		                        confirm: function () {
		                            updateusersetup(selected,role,bso_id,parent_id,allCheck);
		                        },
		                        cancel: function () {
		                            return false;

		                        },
		               
		                    }
		                });
		            }
		            if(selected == '2'){
		                $.confirm({
		                    theme: 'light',
		                    title: 'Alert!',content: 'Are you sure you want to Activate !',
		                    buttons: {
		                        confirm: function () {
		                            updateusersetup(selected,role,bso_id,parent_id,allCheck);
		                        },
		                        cancel: function () {
		                            return false;

		                        },
		               
		                    }
		                });
		            }
		            if(selected == '3'){
		                $.confirm({
		                    theme: 'light',
		                    title: 'Alert!',content: 'Are you sure you want to Delete !',
		                    buttons: {
		                        confirm: function () {
		                            updateusersetup(selected,role,bso_id,parent_id,allCheck);
		                        },
		                        cancel: function () {
		                            return false;

		                        },
		               
		                    }
		                });
		            }
				});

		       function updateusersetup(selected,role,bso_id,parent_id,allCheck){
		            var data = {
		                "action": selected,
		                "ids": allCheck,
		                "role":role,
		                "bso_id":bso_id,
		                "parent_id":parent_id
		            };
		           console.log(data);
		            $.ajax({
		                type: "POST",
		                dataType: "html",
		                url: baseurl + "users/usersetup", //Relative or absolute path to response.php file
		                data: data,
		                success: function(data) {
		                    $('#checkall').prop('checked', false);
		                    $('.table_body').html(data); 
								return false;
		                    }
		            });
		            return false;
				}
        	});
		</script>