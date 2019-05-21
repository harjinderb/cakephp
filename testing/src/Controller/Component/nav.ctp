<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <?php
                echo $this->Html->link('<span class="logo-icon">'.$this->Html->image('bso-icon.png', ['class' => '']).'</span>',['controller' => 'users', 'action' => 'dashboard', 'prefix' => 'admin'],['class'=>'navbar-brand','escape' => false]);
            ?>
            
        </div>
        <?php
            $dataid=$this->request->getSession()->read('Auth.User.id');
            $uuid=$this->request->getSession()->read('Auth.User.uuid');
            $dataimage=$this->request->getSession()->read('Auth.User.image');
            $name = $this->request->getSession()->read('Auth.User.firstname').' '.$this->request->getSession()->read('Auth.User.lastname');
        ?>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="pull-right dropdown p-b-10">
                    <a href="javascript:void(0);" class="dropdown-toggle user-pic-small" data-toggle="dropdown">
                        <?= $this->Html->image(($dataimage!='') ? USER_PICTURE_FOLDER_URL_PATH.$uuid.'/'.$dataimage: 'blank-avatar.png', ['alt' => $name,'class' => 'user-img img-circle']) ?>
                        <?= $name ?>
                        
                    </a>
                    
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php
                                if(!empty($dataimage)){
                                    echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$uuid.'/'.$dataimage, ['alt' => 'user','class' => 'user-img img-circle']),['controller' => 'users', 'action' => 'Profile', 'prefix'=>'admin', $uuid],['escapeTitle' => false,]);
                                }else{
                                    echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'user','class' => 'user-img img-circle']),['controller' => 'users', 'action' => 'Profile', 'prefix' => 'admin', $uuid],['escapeTitle' => false,]);
                                }
                            ?>
                            <h4><?=$this->request->getSession()->read('Auth.User.firstname');?></h4>
                        <!--     <p>Member since Feb. 2018</p> -->
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                         
                            <div class="pull-right" style="margin-right: 73px;">
                                <?php echo $this->Html->link('Sign Out',['controller' => 'users', 'action' => 'logout', 'prefix' => 'admin'],['class'=>'btn bg-blue-grey btn-lg','escape' => false]);
                                ?>                               
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>