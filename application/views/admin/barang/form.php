<div class="row">
   <div class="col-lg-12">
      <?php if (!empty($this->error_msg)):?>
      <div class="alert alert-info alert-dismissable">
         <button type="button" class="close" data-dismiss="alert alert-danger" aria-hidden="true">×</button>
         <?=$this->error_msg;?>.
      </div>
      <?php endif;?>

      <div class="panel panel-default">
         <div class="panel-heading">
            <span>Form</span>
         </div>
         <!-- /.panel-heading -->
         <div class="panel-body">
            <?php 
            $attributes = array('class'=>'form-horizontal', 'id'=>'formBarang');
            echo form_open($this->action_form, $attributes);
            //print_r($list_jenis);
            ?>
               
               <div class="form-group">
                  <label class="col-md-3 control-label" for="jenis">Jenis</label>
                  <div class="col-md-9">
                     <select name="jenis" id="jenis" class="form-control input-md" required>
                        <option value=""></option>
                        <?php
                        if (count($list_jenis) > 0){
                           foreach ($list_jenis as $key => $jenis) {
                              if ($jenis->id == $this->jenis){
                                 ?>
                                 <option value="<?=$jenis->id;?>" selected><?=$jenis->nama_jenis;?></option>
                                 <?php
                              }else{
                                 ?>
                                 <option value="<?=$jenis->id;?>"><?=$jenis->nama_jenis;?></option>
                                 <?php
                              }
                           }
                        }
                        ?>
                     </select>
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-3 control-label" for="kemasan">Kemasan</label>
                  <div class="col-md-9">
                     <select name="kemasan" id="kemasan" class="form-control input-md" required>
                        <option value=""></option>
                        <?php
                        if (count($list_kemasan) > 0){
                           foreach ($list_kemasan as $key => $kemasan) {
                              if ($kemasan->id == $this->kemasan){
                                 ?>
                                 <option value="<?=$kemasan->id;?>" selected><?=$kemasan->nama_kemasan;?></option>
                                 <?php
                              }else{
                                 ?>
                                 <option value="<?=$kemasan->id;?>"><?=$kemasan->nama_kemasan;?></option>
                                 <?php
                              }
                           }
                        }
                        ?>
                     </select>
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-3 control-label" for="product_name">Nama</label>
                  <div class="col-md-9">
                     <input type="text" name="product_name" id="product_name" class="form-control input-md" placeholder="nama product" value="<?=$this->product_name;?>" required>
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-3 control-label" for="hpp">Hpp</label>
                  <div class="col-md-9">
                     <input type="text" name="hpp" id="hpp" class="form-control input-md" placeholder="hpp" value="<?=$this->hpp;?>">
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-3 control-label" for="harga">Harga</label>
                  <div class="col-md-9">
                     <input type="text" name="harga" id="harga" class="form-control input-md" placeholder="harga" value="<?=$this->harga;?>">
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-3 control-label" for="jumlah">Jumlah</label>
                  <div class="col-md-9">
                     <input type="text" name="jumlah" id="jumlah" class="form-control input-md" placeholder="jumlah" value="<?=$this->jumlah;?>">
                  </div>
               </div>
               
               <div class="form-group">
                  <label class="col-md-3 control-label" for="detail">Detail</label>
                  <div class="col-md-9">
                     <textarea name="detail" id="detail" class="form-control input-md" placeholder="detail"><?=$this->detail;?></textarea>
                  </div>
               </div>

               <div class="form-group">
                  <div class="col-sm-12">
                     <a href="<?php echo base_url('admin/barang');?>" class="btn btn-sm btn-default btn-flat pull-left">Cancel</a>
                     <input type="submit" value="Submit" class="btn btn-sm btn-default btn-flat pull-right">
                  </div>
               </div>
            </form>
         </div>
         <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
   </div>
</div>