									<?php 
										if(empty($users->toArray())){
											echo '<tr><td colspan="7">No record found!</td></tr>';
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
										<input  class="filled-in chk-col-red" id="role" value="7" type="hidden">							            		
							    		<input  class="filled-in chk-col-red" id="bso_id" value="<?=$value['bso_id'];?>" type="hidden">
								    	<input  class="filled-in chk-col-red" id="parent_id" value="0" type="hidden">
										<td><?= $i;?></td>
										<td><?= $value['service_day']?></td>
										<td><?= $value['service_type']?> </td>
										<td><?php echo date("H:i a", strtotime($value['start_time']));?></td>
										<td><?php echo date("H:i a", strtotime($value['end_time']));?></td>
										<!-- <td> -->
											<?php// if ($value['service_status'] == 1) {?>
									            <!-- <span class="label bg-green">Active</span> -->
									        <?php //} else {?>
									            <!-- <span class="label bg-red">Not Active</span> -->
									        <?php //}?>
									    <!-- </td> -->
										<td>
											<div class="cs-btn-group">
												<?php echo $this->Html->link(
								                'Edit',
								                ['controller' => 'users', 'action' => 'editServices',$value->uuid],
								                ['class' => 'btn bg-blue','escape' => false]); 
									            ?>
												<?php 
													// if($value['service_status'] == 1){ 
													// 	echo $this->Form->postLink(__('Deactivate'), ['controller' => 'users','action' => 'servicesDeactivate', $value->uuid], ['class' => 'btn btn-warning','confirm' => __('Are you sure you want to Deactivate # {0}?', trim($value->name)),'escape' => false]);
													// }

													// if($value['service_status'] == 0){ 
													// 	echo $this->Form->postLink(__('Activate'), ['controller' => 'users','action' => 'servicesActivate', $value->uuid], ['class' => 'btn btn-success','confirm' => __('Are you sure you want to Activate # {0}?', trim($value->name)),'escape' => false]);
													// }
												//echo $this->Form->postLink(__('Add teacher to service'), ['controller' => 'users','action' => 'servicesTeacher',$value->uuid],
												 //['class' => 'btn bg-blue-grey','escape' => false]);

												echo $this->Form->postLink(__('Delete'), ['controller' => 'users','action' => 'servicesDelete',$value->uuid],
												 ['class' => 'btn bg-deep-orange','confirm' => __('Are you sure you want to Delete # {0}?'),'escape' => false]);

												?>
											</div>
										</td>
									</tr>
									
									
									
								

									<?php 

									$i++ ; } 
									if (!empty($users->toArray())) {
    									?>
									<tr>
									    <td colspan="9">
									        <div class="btm-action pull-right">
									            <?=$this->Form->select('parent_id', $actionlist, ['multiple' => false, 'value' => [], 'label' => false, 'class' => 'form-control usersetup']);?>
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
									                 if(selected == '1'){
										                $.confirm({
										                    theme: 'light',
										                    title: 'Alert!',content: 'Are you sure you want to Deactivate !',
										                });
										            }
										            if(selected == '2'){
										                $.confirm({
										                    theme: 'light',
										                    title: 'Alert!',content: 'Are you sure you want to Activate !',
										                });
										            }
										            if(selected == '3'){
										                $.confirm({
										                    theme: 'light',
										                    title: 'Alert!',content: 'Are you sure you want to Delete !',
										                });
										            }   
									            // alert(selected);
									            var allCheck = [];
									            $("input[type=checkbox]").each(function() {

									                
									                if ($(this).is(':checked')) {
									                    var value = $(this).closest('tr').find($("input[type=checkbox]")).val();

									                    allCheck.push(value);
									                }
									            });

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

									        });
									});
									</script>