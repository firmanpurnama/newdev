<div class="row">
   <div class="col-lg-12">
      <div class="panel panel-default">
         <div class="panel-heading">
         <!-- <h4>a</h4> -->
            <div class="pull-right">
               <a href="<?=base_url('admin/users/update/'.$user->id);?>"><i class="fa fa-edit"></i></a>
            </div>
         </div>
         <!-- /.panel-heading -->
         <div class="panel-body">
            <div>
               <div class="col-md-4 col-xs-6">User name</div>
               <div class="col-md-8 col-xs-6"><?=$user->user_name;?></div>
               <div class="col-md-4 col-xs-6">Email</div>
               <div class="col-md-8 col-xs-6"><?=$user->email;?></div>
               <div class="col-md-4 col-xs-6">User Group</div>
               <div class="col-md-8 col-xs-6"><?=$user->group_name;?></div>
               <div class="col-md-4 col-xs-6">Last login</div>
               <div class="col-md-8 col-xs-6"><?=$user->last_login;?></div>
            </div>
         </div>
         <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
   </div>
<!-- /.col-lg-12 -->
</div>