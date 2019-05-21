<?php 
	if(empty($users)){
		//pr($users);die;
		echo '<tr><td colspan="8">No record found!</td></tr>';
	}
	$i='1';
	$actionlist = array('Action', 'Deactivate', 'Activate', 'Delete');
	foreach ($users as $key => $value) { 
		//pr($value);//die;
		//echo $value['contracts'][0]->plan_type ;
		//if(!empty($value['contracts'])){ echo $value['contracts'][0]->plan_type ;}
	
	//die;
	?>
									
									<tr>
										<td><div class="check-box-cs checkboxes">
								            	<input id="<?= $value->uuid ?>" class="filled-in chk-col-red cheks" type="checkbox" value="<?= $value->id ?>">
								           	 	<label for="<?= $value->uuid ?>"></label>
								        	</div>
								    	</td>
							    		<input  class="filled-in chk-col-red" id="role" value="4" type="hidden">
							    		<input  class="filled-in chk-col-red" id="bso_id" value="<?= $value->bso_id;?>" type="hidden">
								    	<input  class="filled-in chk-col-red" id="parent_id" value="<?= $value->parent_id;?>" type="hidden">
										<td><?= $i;?></td>
										<td><?= 'REG-ID'.$value->registration_id?></td>
										<td><?= $this->Decryption->mc_decrypt($value->firstname,$value['encryptionkey']).' '.$this->Decryption->mc_decrypt($value->lastname,$value['encryptionkey'])?> </td>
										
										
										<td><?= $value->created?></td>
										<td><?php if(!empty($value['contracts'])){ echo $value['contracts'][0]->plan_type ;}?></td>
										 <td>
									       
									    </td>
										<td>
											<div class="cs-btn-group">
												<?php echo $this->Html->link(
									                'View Service',
									                ['controller' => 'users', 'action' => 'childServices', $value->uuid],
									                ['class' => 'btn bg-teal','escape' => false]); 
									            ?>
									            <?php echo $this->Html->link(
									                'View Invoice',
									                ['controller' => 'users', 'action' => 'viewInvoice', $value->uuid],
									                ['class' => 'btn bg-green','escape' => false]); 
									            ?>
												<?php echo $this->Html->link(
									                'Send Invoice',
									                ['controller' => 'users', 'action' => 'sendInvoice',$value->uuid],
									                ['class' => 'btn bg-blue','escape' => false]); 
									            ?>
									            

												
											</div>
										</td>
									</tr>
									<?php $i++; } 
										
										// die;
										if (!empty($users)) {
    									?>
									 <tr>
									    <td colspan="9">
									        <div class="btm-action pull-right">
									            <?php $this->Form->select('parent_id', $actionlist, ['multiple' => false, 'value' => [], 'label' => false, 'class' => 'form-control usersetup']);?>
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