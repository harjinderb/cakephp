<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Children List')?></h1>
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="box box-primary">
            <div class="box-header bso-box-header">
				<div class="row">
					<div class="col-xs-7">
						<h3 class="box-title"><?=__('Children List')?></h3>
					</div>
				</div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-striped table-hover v-center cell-pd-15">
                <thead>
                <tr>
					<th>
						<div class="cst-check">
							<input type="checkbox" class="cst-check__input">
							<span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span>
						</div>
					</th>
                  <th>#</th>
                  <th><?=__('Name')?></th>
                  <th><?=__('Image')?></th>
				  <th><?=__('Gender')?></th>
				  <th><?=__('DOB')?></th>
				  <th><?=__('Reg No.')?></th>
				  <th><?=__('Action')?></th>
                </tr>
                </thead>
                <tbody>
                	<?php
                	//pr($child);die;
                 	$i =1;
                		foreach ($child as $key => $value) {
					?>
                <tr>
                  <td>
					  <div class="cst-check">
							<input type="checkbox" class="cst-check__input">
							<span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span>
						</div>
					</td>
					<td><?= $i?></td>
					<td><?=$this->Decryption->mc_decrypt($value[0]['firstname'],$value[0]['encryptionkey']).' '.' '.$this->Decryption->mc_decrypt($value[0]['lastname'],$value[0]['encryptionkey'])?></td>
					<!-- <img src="../dist/img/avatar3.png" alt="" class="table-img-thumb"> -->
					<td> <?php
								if (!empty($value[0]['image'])) {
							        echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH . $value[0]['uuid'] . '/' . $value[0]['image'], ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
							    } else {
							        echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
							    }
									    ?></td>
					<td><?php if($value[0]->gender == 1){?>
						<?=__('Male')?>
						<?php } else {?>
						<?=__('Female')?>
					<?php }?>
					</td>
					<td><?= date('d-m-Y', strtotime($this->Decryption->mc_decrypt($value[0]['dob'],$value[0]['encryptionkey'])))?></td>
					<td>002</td>
					
					<td>
						<div class="btn__group">
							<a href="#" class="btn btn-green-border"><?=__('View')?></a>
							<a href="#" class="btn btn-theme-border"><?=__('Attendance')?></a>
						</div>
					</td>
                </tr>
                <?php 
                	$i++;
                	}
                	
                ?>
				
				
				
			
                </tbody>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>