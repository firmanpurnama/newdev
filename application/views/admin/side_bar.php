<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                <!-- /input-group -->
            </li>
            <?php foreach($this->sidebar_main_menu as $smm){
                if ($smm->menu_type == 1){
                    ?>
                    <li>
                        <a href="#"><i class="fa fa-dashboard fa-fw"></i> <?=$smm->main_menu_name;?><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <?php foreach($this->sidebar_menu as $mn){
                                if ($mn->main_menu_id == $smm->main_menu_id){
                                    ?>
                                    <li>
                                        <a href="<?=base_url('admin/'.$mn->menu_link);?>"><?=$mn->menu_name;?></a>
                                    </li>
                                    <?php 
                                }
                            } 
                            ?>
                        </ul>
                    </li>
                    <?php 
                }else{
                    ?>
                    <li>
                        <a href="<?=base_url('admin/'.$smm->link);?>"><i class="fa fa-dashboard fa-fw"></i> <?=$smm->main_menu_name;?></a>
                    </li>
                    <?php
                }
            } 
            ?>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->