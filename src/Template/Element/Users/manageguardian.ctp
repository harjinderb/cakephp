<tr>
	<?php
									$i=1; 
									$actionlist = array('Action', 'Deactivate', 'Activate', 'Delete');
									foreach ($users as $key => $childdata) {
										# code..
										//pr($childdata);
										?>
									
									<tr>
										<td><div class="check-box-cs checkboxes">
								            	<input id="<?=$childdata['uuid'];?>" class="filled-in chk-col-red cheks" type="checkbox" value="<?=$childdata['id'];?>">
								           	 	<label for="<?=$childdata['uuid'];?>"></label>
								        	</div>
								    	</td>
								    	<input  class="filled-in chk-col-red" id="role" value="4" type="hidden">
								    	<input  class="filled-in chk-col-red" id="bso_id" value="<?=$childdata['bso_id'];?>" type="hidden">
								    	<input  class="filled-in chk-col-red" id="parent_id" value="<?=$childdata['parent_id'];?>" type="hidden">
										<td><?=$i?></td>
										<td><?=$this->Decryption->mc_decrypt($childdata['firstname'],$childdata['encryptionkey']).' '.' '.$this->Decryption->mc_decrypt($childdata['lastname'],$childdata['encryptionkey'])?></td>
										<td> <?php
											if (!empty($childdata['image'])) {
										        echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH . $childdata['uuid'] . '/' . $childdata['image'], ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
										    } else {
										        echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
										    }
									    ?></td>
										<td><?php if($childdata->gender == 1){?>
												Male
												<?php } else {?>
												Female
											<?php }?>
										</td>
										<td><?= date('d-m-Y', strtotime($childdata['dob']));?></td>
										<td><?=$childdata['relation'];?></td>
										 <td>
									        <?php if ($childdata['is_active'] == 0) {?>
									            <span class="label bg-red">Not Activated</span>
									        <?php } else {?>
									            <span class="label bg-green">Activated</span>
									        <?php }?>
									    </td>
										<td>
											<div class="cs-btn-group">
												<?php echo $this->Html->link('<i class="fa fa-pencil"> </i><span>Edit</span>',['controller' => 'users', 'action' => 'guardianEdit', $childdata->uuid],['class' => 'btn btn-info','escape' => false]); 
													   if ($childdata['is_active'] == 1) {
										                    echo $this->Form->postLink(__('<i class="fa fa fa-eye-slash"> </i> ' . 'Deactivate'), ['controller' => 'users', 'action' => 'guardianDeactivate', 'prefix' => 'parent', $childdata->uuid], ['class' => 'btn btn-warning', 'confirm' => __('Are you sure you want to Deactivate {0}', trim($this->Decryption->mc_decrypt($childdata['firstname'],$childdata['encryptionkey']).' '.' '.$this->Decryption->mc_decrypt($childdata['lastname'],$childdata['encryptionkey']))), 'escape' => false]);
										                }

										                if ($childdata['is_active'] == 0) {
										                    echo $this->Form->postLink(__('<i class="fa fa fa-eye-slash"> </i>' . ' ' . 'Activate'), ['controller' => 'users', 'action' => 'guardianActivate', 'prefix' => 'parent', $childdata->uuid], ['class' => 'btn btn-success', 'confirm' => __('Are you sure you want to Activate {0}', trim($this->Decryption->mc_decrypt($childdata['firstname'],$childdata['encryptionkey']).' '.' '.$this->Decryption->mc_decrypt($childdata['lastname'],$childdata['encryptionkey']))), 'escape' => false]);
										                }
												echo $this->Form->postLink(__('<i class="fa fa fa-trash"> </i>'.' '.'Delete'), ['controller' => 'users','action' => 'guardianDelete', $childdata->id, 'prefix' => 'parent'], ['class' => 'btn bg-deep-orange','confirm' => __('Are you sure you want to Delete {0}', trim($this->Decryption->mc_decrypt($childdata['firstname'],$childdata['encryptionkey']).' '.' '.$this->Decryption->mc_decrypt($childdata['lastname'],$childdata['encryptionkey']))),'escape' => false]);?>
												
											</div>
										</td>
									</tr>
								
									<?php $i++ ;}
										if (!empty($value)) {}
    									?>
									<tr>
									<td colspan="9">
											<div class="btm-action pull-right">
												<?=$this->Form->select('parent_id', $actionlist, ['multiple' => false, 'value' => [], 'label' => false, 'class' => 'form-control usersetup']);?>
									            <form>

									            </form>
												<!-- <form>
													<select class="form-control show-tick">
														<option value="">-- Action --</option>
														<option value="">Delete</option>
													</select>
												</form> -->
											</div>
										</td>
									</tr>
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