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
               <a href="<?=base_url('admin/kemasan/add/');?>"><i class="fa fa-plus-circle"></i></a>
            </div>
         </div>
         <!-- /.panel-heading -->
         <div class="panel-body">
            <?php if (count($kemasan) > 0):?>
            <table class="table table-hover">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Nama</th>
                     <th>Isi</th>
                     <th>Tanggal</th>
                     <th></th>
                  </tr>
               </thead>
               <tbody>
                  <?php 
                  $i=0;
                  foreach ($kemasan as $key => $km) { 
                     $i++;
                     ?>
                     <tr>
                        <td><?=$i;?></td>
                        <td><?=$km->nama_kemasan;?></td>
                        <td><?=$km->isi;?></td>
                        <td><?=$km->tanggal;?></td>
                        <td>
                           <a href="<?=base_url('admin/kemasan/detail/'.$jn->id);?>"><i class="fa fa-eye"></i></a>
                           <a href="<?=base_url('admin/kemasan/update/'.$jn->id);?>"><i class="fa fa-edit"></i></a>
                           <a href="<?=base_url('admin/kemasan/delete/'.$jn->id);?>" onclick="konfirmasihapus(event)"><i class="glyphicon glyphicon-remove-sign"></i></a>
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