<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1><?=__('Children')?></h1>
      <?= $this->Flash->render() ?>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="box box-primary">
         <div class="box-header bso-box-header">
            <div class="row">
               <div class="col-xs-7">
                  <h3 class="box-title"><?=__('Children List')?> </h3>
               </div>
               <div class="col-xs-5 text-right">
                  <?php 
                     //echo $this->Html->link('Add new Child',['controller' => 'users', 'action' => 'addChild'],
                             //             ['class' => 'btn btn-theme btn-round','escape' => false]); 
                  ?>
               </div>
            </div>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
						
							<table id ="myinvoices" class="table table-striped table-hover v-center cell-pd-15">
								<thead>
									<tr>
									
										<th>#</th>
										<th><?=__('Name')?></th>
										<th><?=__('Image')?></th>
										<th><?=__('Invoice Start Period')?></th>
										<th><?=__('Invoice End Period')?></th>
										<th><?=__('Due Date')?></th>
										<th><?=__('Due Amount')?></th>
										<th><?=__('Action')?></th>
									</tr>
								</thead>
								<tbody class="table_body">
									<?php
									$i=1; 
									//$actionlist = array('Action', 'Delete');
									// pr($invoices);die;
									foreach ($invoices as $key => $childdata){
											
										// pr($childdata);die;
									?>
									
									<tr>
										
								    	<input  class="filled-in chk-col-red" id="role" value="5" type="hidden">
								    	<input  class="filled-in chk-col-red" id="bso_id" value="<?=$childdata['bso_id'];?>" type="hidden">
								    	<input  class="filled-in chk-col-red" id="parent_id" value="<?=$childdata['parent_id'];?>" type="hidden">
										<td><?=$i?></td>
										<td><?=$this->Decryption->mc_decrypt($childdata['user']['firstname'],$childdata['user']['encryptionkey']).' '.' '.$this->Decryption->mc_decrypt($childdata['user']['lastname'],$childdata['user']['encryptionkey'])?></td>
										<td> <?php
											if (!empty($childdata['user']['image'])) {
										        echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH . $childdata['user']['uuid'] . '/' . $childdata['user']['image'], ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
										    } else {
										        echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
										    }
									    ?></td>
										<td><?= date('d-m-Y', strtotime($childdata['invoicestart']));?></td>
										<td><?= date('d-m-Y', strtotime($childdata['invoiceend']));?></td>
										<td><?= date('d-m-Y', strtotime($childdata['due_date']));?></td>
										 <td><?= $childdata['totalpayment'];?></td>
										<td>
											<?php 
												echo $this->Form->create('', ['class'=>'','type'=>'GET','url' => ['controller'=>'Users', 'action' => 'downloadInvoice',$childdata['user']['uuid']]]); ?>
											<div class="cs-btn-group">
													<?= $this->Form->hidden('invoicestart',   ['value'=> date('d-m-Y', strtotime($childdata['invoicestart']))]); ?>
													<?= $this->Form->hidden('invoiceend',   ['value'=> date('d-m-Y', strtotime($childdata['invoiceend']))]); ?>
													<?= $this->Form->hidden('due_date',   ['value'=> date('d-m-Y', strtotime($childdata['due_date']))]); ?>
													<?= $this->Form->hidden('invoice_group',   ['value'=> $childdata['invoice_group']]); ?>
												<?php
													echo $this->Form->button('<span>View Invoice</span>',['class' => 'btn btn-info']);
										      ?>
												<?php echo $this->Form->end(); ?>
											</div>
										</td>
									</tr>
								
									<?php $i++ ;}
										if (!empty($value)) {}
    									?>
									
								</tbody>
							</table>
						</div>
						<div class="pagination-wrap">
								<?php
						// echo "<div class='center'><ul class='pagination' style='margin:20px auto;'>";
						// 	echo $this->Paginator->prev('< ' . __('previous'), array('tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'disabled'), null, array('class' => 'prev disabled'));
						// 	echo $this->Paginator->numbers(array('separator' => '','tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active'));
						// 	echo $this->Paginator->next(__('next').' >', array('tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'disabled'), null, array('class' => 'next disabled'));
						// echo "</div></ul>";
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

