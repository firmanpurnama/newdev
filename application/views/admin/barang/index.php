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
               <a href="<?=base_url('admin/barang/add/');?>"><i class="fa fa-plus-circle"></i></a>
            </div>
         </div>
         <!-- /.panel-heading -->
         <div class="panel-body">
            <?php if (count($barang) > 0):?>
            <table class="table table-hover">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Nama</th>
                     <th>Jenis</th>
                     <th>kemasan</th>
                     <th>Hpp</th>
                     <th>Harga</th>
                     <th>jumlah</th>
                     <th>detail</th>
                     <th></th>
                  </tr>
               </thead>
               <tbody>
                  <?php 
                  $i=0;
                  foreach ($barang as $key => $val) { 
                     $i++;
                     ?>
                     <tr>
                        <td><?=$i;?></td>
                        <td><?=$val->jenis;?></td>
                        <td><?=$val->kemasan;?></td>
                        <td><?=$val->product_name;?></td>
                        <td><?=$val->hpp;?></td>
                        <td><?=$val->harga;?></td>
                        <td><?=$val->jumlah;?></td>
                        <td><?=$val->detail;?></td>
                        <td>
                           <a href="<?=base_url('admin/barang/detail/'.$val->id);?>"><i class="fa fa-eye"></i></a>
                           <a href="<?=base_url('admin/barang/update/'.$val->id);?>"><i class="fa fa-edit"></i></a>
                           <a href="<?=base_url('admin/barang/delete/'.$val->id);?>" onclick="konfirmasihapus(event)"><i class="glyphicon glyphicon-remove-sign"></i></a>
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