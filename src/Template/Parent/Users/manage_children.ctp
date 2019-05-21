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
                  <h3 class="box-title"><?=__('Children List')?></h3>
               </div>
               <div class="col-xs-5 text-right">
                  <?php 
                     echo $this->Html->link(__('Add new Child'),['controller' => 'users', 'action' => 'addChild'],
                                          ['class' => 'btn btn-theme btn-round','escape' => false]); 
                  ?>
               </div>
            </div>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
            <table id="managechild" class="table table-striped table-hover v-center cell-pd-15">
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
                     <th><?=__('Apply Leave')?></th>
                     <th><?=__('Action')?></th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
         <!-- /.box-body -->
      </div>
      <!-- /.box -->
   </section>
   <!-- /.content -->
</div>
  <div class="modal fade" id="ApplyLeave">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header service-header bg-b-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?=__('Apply leave for "Nina Mcintire"')?> </h4>
              </div>
            <?php echo $this->Form->create('',['class'=>'myform','type'=>'file']); ?>
               <div class="modal-body">
                  <div class="event-details">               
                     <div class="form-group">
                        <label><?=__('Leave Title *')?></label>
                        <?= $this->Form->control('LeaveTitle',   ['label' => false, 'class' => 'form-control', 'placeholder' => __('Leave Title'),'type'=>'text']); ?>
                        
                     </div>
                     <?= $this->Form->control('child_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=>'']);?>
                     <div class="form-group">
                        <label><?=__('Leave Start Date *')?></label>
                           <div class="input-group">
                              <?= $this->Form->control('leavestartdate',   ['label' => false, 'class' => 'datepicker form-control', 'placeholder' => __('leave start date'),'type'=>'text']); ?>
                              <div class="input-group-addon">
                                 <i class="fa fa-calendar"></i>
                              </div>
                           </div>
                     </div>   
                     <div class="form-group">
                        <label><?=__('Leave End Date *')?></label>
                        
                        <div class="input-group">
                           <?= $this->Form->control('leaveenddate',   ['label' => false, 'class' => 'datepicker form-control', 'placeholder' => ('leave end date'),'type'=>'text']); ?>
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                                          
                     </div>                     
                     <div class="form-group">
                        <label><?=__('Description')?></label>
                         <?= $this->Form->control('leavedescription',   ['label' => false, 'class' => 'textarea-100 form-control', 'placeholder' => 'leave end date','type'=>'textarea']); ?>
                       
                     </div>
                  </div>
               </div>
               <div class="modal-footer pt_0 bt_0 text-right">
                  <button type="button" class="btn btn-default btn-round-md" data-dismiss="modal"><?=__('Cancel')?></button>
                  <button type="button" class="btn btn-theme btn-round-md  aplyleave" data-dismiss="modal"><?=__('Apply Leave')?></a>
               </div>
             <?php echo $this->Form->end(); ?>  
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>