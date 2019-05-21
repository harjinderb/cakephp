<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Manage Services</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-sm-6">
								<h2>
								Services List
								</h2>
								<?= $this->Flash->render() ?>
							</div>
							<div class="col-sm-6 text-right">
								<?php echo $this->Html->link(
					                'Add Service',
					                ['controller' => 'users', 'action' => 'addServices'],
					                ['class' => 'btn bg-green','escape' => false]); 
					            ?>
							</div>
						</div>
					</div>
					<div class="body">
						<div class="search-right text-right">
							
							<?= $this->Form->create('Search',['type'=>'get', 'url' => ['controller'=>'Users', 'action' => 'manageServices'],
								]) ?>
								<div class="form-group">
									<?php echo $this->Form->control('ids',   ['label' => false, 'class'=>'search-input', 'placeholder' => 'Search...']
	                                );?>
	                               
                                
                                	<?= $this->Form->button(__('Search'),['label' => false,'class' => 'btn bg-blue-grey search-btn']) ?>
                            	</div>
                           			 <?= $this->Form->end() ?>
									<!-- <input type="text" class="search-input" placeholder="Search ...">
									<a href="javascript:void(0)" class="btn bg-blue-grey search-btn"> Serach</a> -->
								</div>
							
						</div>
						<div class="table-responsive">
							<table class="table table-bordered table-checkbox">
								<thead>
									<tr>
										<th>
											<div class="check-box-cs">
												<input id="checkall" class="filled-in chk-col-red customerIDCell"type="checkbox" value="0">
                                           		 <label for="checkall"></label>
											</th>
										</div>
										<th>#</th>
										<th>Day</th>
										<th>Service</th>
										<th>Start Time</th>
										<th>End Time</th>
										<!-- <th>Status</th> -->
										<th>Action</th>
									</tr>
								</thead>
								<tbody class="table_body">
						<?= $this->element('Users/services'); ?>

								</tbody>
							</table>
						</div>
						<div class="pagination-wrap">
						<?php
							echo "<div class='center'><ul class='pagination' style='margin:20px auto;'>";
							echo $this->Paginator->prev('< ' . __('previous'), array('tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'disabled'), null, array('class' => 'prev disabled'));
							echo $this->Paginator->numbers(array('separator' => '','tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active'));
							echo $this->Paginator->next(__('next').' >', array('tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'disabled'), null, array('class' => 'next disabled'));
							echo "</div></ul>";
						?>						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>