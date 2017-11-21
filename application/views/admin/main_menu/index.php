<div class="row">
   <div class="col-lg-12">
      <?php if (count($main_menus) <= 0):?>
      <div class="alert alert-danger alert-dismissable">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         No data found for keyword <?=$this->keyword;?>.
      </div>
      <?php endif;?>
      <div class="panel panel-default">
         <div class="panel-heading">
         <!-- <h4>a</h4> -->
            <div class="col-md-4">
            <form action="<?=base_url('admin/main_menu/search');?>" method="POST" class="form-horizontal form-min-margin-top">
               <div class="form-group input-group">
                  <input type="text" name="search" class="form-control" required>
                  <span class="input-group-btn">
                     <!-- <input type="submit" class="btn btn-default a fa-search"> -->
                     <button class="btn btn-default"><i class="fa fa-search"></i></button>
                  </span>
               </div>
            </form>
            </div>
            <div class="col-md-4 col-md-offset-4">
               <a href="<?=base_url('admin/main_menu/add/');?>" class="pull-right"><i class="fa fa-plus-circle"></i></a>
            </div>
         </div>
         <!-- /.panel-heading -->
         <div class="panel-body">
            <?php if (count($main_menus) > 0):?>
            <div class="table-responsive">
               <table class="table table-hover">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Menu Name</th>
                        <th>Link</th>
                        <th>type</th>
                        <th>Back End</th>
                        <th>Front End</th>
                        <th>Order</th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                     $i=0;
                     foreach ($main_menus as $key => $mm) { 
                        $i++;
                        ?>
                        <tr>
                           <td><?=$i;?></td>
                           <td><?=$mm->main_menu_name;?></td>
                           <td><?=$mm->link;?></td>
                           <td><?=$mm->menu_type;?></td>
                           <td><?=$mm->back_end;?></td>
                           <td><?=$mm->front_end;?></td>
                           <td><?=$mm->menu_order;?></td>
                           <td>
                              <a href="<?=base_url('admin/main_menu/update/'.$mm->id);?>"><i class="fa fa-edit"></i></a>
                              <a href="<?=base_url('admin/main_menu/delete/'.$mm->id);?>" onclick="konfirmasihapus(event)"><i class="glyphicon glyphicon-remove-sign"></i></a>
                           </td>
                        </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
            <?php endif; ?>
         </div>
         <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
   </div>
<!-- /.col-lg-12 -->
</div>