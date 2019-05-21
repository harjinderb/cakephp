<?php
if (empty($users->toArray())) {
        echo '<tr><td colspan="7">No record found!</td></tr>';
}
$i = '1';
$actionlist = array('Action', 'Deactivate', 'Activate', 'Delete');
foreach ($users as $data) {
    // if(empty($data['firstname'])){
    //     echo "No record found!";
    //     die;

    // }
    ?>
<tr>
    <td>
        <div class="check-box-cs checkboxes">
            <input id="<?=$data['uuid'];?>" class="filled-in chk-col-red cheks" type="checkbox" value="<?=$data['id'];?>">
            <label for="<?=$data['uuid'];?>"></label>
        </div>
    </td>
    <input  class="filled-in chk-col-red" id="role" value="2" type="hidden">
    <input  class="filled-in chk-col-red" id="bso_id" value="0" type="hidden">
    <input  class="filled-in chk-col-red" id="parent_id" value="0" type="hidden">
   <td><?=$i;?></td>
    <td><?=$this->Decryption->mc_decrypt($data['firstname'],$data['encryptionkey']);?></td>
    <td>
        <?php
    if (!empty($data['image'])) {
        echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH . $data['uuid'] . '/' . $data['image'], ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
    } else {
        echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
    }
    ?>
    </td>
    <td><?= $this->Decryption->emailDecode($data['email']);?></td>
    <td>
        <?php if ($data['is_active'] == 0) {?>
            <span class="label bg-red">Not Activated</span>
        <?php } else {?>
            <span class="label bg-green">Activated</span>
        <?php }?>
    </td>
    <td>
        <div class="btn-group-table">

            <?php echo $this->Html->link('<i class="fa fa-eye"> </i> <span>view</span>', ['controller' => 'users', 'action' => 'profile', 'prefix' => 'admin', $data->uuid], ['class' => 'btn bg-teal', 'escape' => false]); ?>

            <?php echo $this->Html->link('<i class="fa fa-pencil"> </i> <span>Edit</span>', ['controller' => 'users', 'action' => 'edit', 'prefix' => 'admin', $data->uuid], ['class' => 'btn btn-info', 'escape' => false]); ?>
            <?php
                if ($data['is_active'] == 1) {
                    echo $this->Form->postLink(__('<i class="fa fa fa-eye-slash"> </i> ' . 'Deactivate'), ['controller' => 'users', 'action' => 'deactivateBso', 'prefix' => 'admin', $data->uuid], ['class' => 'btn btn-warning', 'confirm' => __('Are you sure you want to Deactivate {0}', trim($this->Decryption->mc_decrypt($data['firstname'],$data['encryptionkey']))), 'escape' => false]);
                }

                if ($data['is_active'] == 0) {
                    echo $this->Form->postLink(__('<i class="fa fa fa-eye-slash"> </i>' . ' ' . 'Activate'), ['controller' => 'users', 'action' => 'activateBso', 'prefix' => 'admin', $data->uuid], ['class' => 'btn btn-success', 'confirm' => __('Are you sure you want to Activate {0}', trim($this->Decryption->mc_decrypt($data['firstname'],$data['encryptionkey']))), 'escape' => false]);
                }

                echo $this->Form->postLink(__('<i class="fa fa fa-trash"> </i>' . ' ' . 'Delete'), ['controller' => 'users', 'action' => 'delete', 'prefix' => 'admin', $data->uuid], ['class' => 'btn btn-danger', 'confirm' => __('Are you sure you want to Delete {0}', trim($this->Decryption->mc_decrypt($data['firstname'],$data['encryptionkey']))), 'escape' => false]);

            ?>

        </div>
    </td>
</tr>
<?php $i++;}
if (!empty($users->toArray())) {
    ?>
<tr>
    <td colspan="7">
        <div class="btm-action pull-right">
            <?=$this->Form->select('parent_id', $actionlist, ['multiple' => false, 'value' => [], 'label' => false, 'class' => 'form-control usersetup','disabled'=>'disabled']);?>
            <form>

            </form>
        </div>
    </td>
</tr>
<?php }?>
<script>
$(document).ready(function() {
     $('.usersetup').on('change', function() {
                                //alert("I Am At alert");
            
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
                    //console.log(data);
                    $('#checkall').prop('checked', false);
                    $('.table_body').html(data); 

                              return false;
                    }
            });
            return false;

        }
        });
</script>