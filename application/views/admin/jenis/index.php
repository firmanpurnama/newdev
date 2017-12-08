<div class="row">
   <div class="col-lg-12">
      <?php if (!empty($this->error_msg)):?>
      <div class="alert alert-info alert-dismissable">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <?=$this->error_msg;?>.
      </div>
      <?php endif;?>

      <div class="panel panel-default">
         <div class="panel-heading">
         <!-- <h4>a</h4> -->
            <div class="pull-right">
               <a href="<?=base_url('admin/jenis/add/');?>"><i class="fa fa-plus-circle"></i></a>
            </div>
         </div>
         <!-- /.panel-heading -->
         <div class="panel-body">
            <?php if (count($jenis) > 0):?>
            <table class="table table-hover">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Nama</th>
                     <th>Detail</th>
                     <th></th>
                  </tr>
               </thead>
               <tbody>
                  <?php 
                  $i=0;
                  foreach ($jenis as $key => $jn) { 
                     $i++;
                     ?>
                     <tr>
                        <td><?=$i;?></td>
                        <td><?=$jn->nama_jenis;?></td>
                        <td><?=$jn->detail;?></td>
                        <td>
                           <a href="<?=base_url('admin/jenis/detail/'.$jn->id);?>"><i class="fa fa-eye"></i></a>
                           <a href="<?=base_url('admin/jenis/update/'.$jn->id);?>"><i class="fa fa-edit"></i></a>
                           <a href="<?=base_url('admin/jenis/delete/'.$jn->id);?>" onclick="konfirmasihapus(event)"><i class="glyphicon glyphicon-remove-sign"></i></a>
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