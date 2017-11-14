<div class="row">
   <div class="col-lg-12">
      <div class="panel panel-default">
         <div class="panel-heading">
         <!-- <h4>a</h4> -->
            <div class="pull-right">
               <a href="<?=base_url('admin/users_group/add/');?>"><i class="fa fa-plus-circle"></i></a>
            </div>
         </div>
         <!-- /.panel-heading -->
         <div class="panel-body">
            <?php if (count($user_groups) > 0):?>
            <table class="table table-hover">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Group Name</th>
                     <th></th>
                  </tr>
               </thead>
               <tbody>
                  <?php 
                  $i=0;
                  foreach ($user_groups as $key => $ug) { 
                     $i++;
                     ?>
                     <tr>
                        <td><?=$i;?></td>
                        <td><?=$ug->group_name;?></td>
                        <td>
                           <a href="<?=base_url('admin/users_group/edit/'.$ug->id);?>"><i class="fa fa-edit"></i></a>
                           <a href="<?=base_url('admin/users_group/delete/'.$ug->id);?>" onclick="konfirmasihapus(event)"><i class="glyphicon glyphicon-remove-sign"></i></a>
                        </td>
                     </tr>
                  <?php } ?>
               </tbody>
            </table>
            <?php endif; ?>
         </div>
         <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
   </div>
<!-- /.col-lg-12 -->
</div>