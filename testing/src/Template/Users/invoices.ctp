<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Genrate Invoice's</h2>
		</div>

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-sm-6">
								<h2>
								Genrate Invoice's
								</h2>
							</div>
							<div class="col-sm-6 text-right">
								
							</div>
						</div>
					</div>
					<div class="body">
						<div class="search-right text-right">
							<?= $this->Form->create('Search',['type'=>'post']) ?>
                            <div class="form-group">
                                <?php echo $this->Form->control('id',   ['label' => false, 'class'=>'search-input', 'placeholder' => 'Search...']
                                );?>
                                <?php echo $this->Form->control('role',   ['label' => false, 'class'=>'search-input','type'=>'hidden','value'=>'4']
                                );
                                ?>
                                <?= $this->Form->button(__('Search'),['label' => false,'class' => 'btn bg-blue-grey search-btn']) ?>
                            </div>
                            <?= $this->Form->end() ?>
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
										<th>REG ID.</th>
										<th><?php echo $this->Paginator->sort('name');?></th>
										<th>Registration Date</th>
										<th>Plane Type</th>
										<th>Previous Invoice Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody class="table_body">

									<?php  echo $this->element('Users/invoice'); ?>
								</tbody>
							</table>
						</div>
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
</section>