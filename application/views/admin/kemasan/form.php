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
            $attributes = array('class'=>'form-horizontal', 'id'=>'formKemasan');
            echo form_open($this->action_form, $attributes);
            ?>
               
               <div class="form-group">
                  <label class="col-md-3 control-label" for="nama_kemasan">Nama Kemasan</label>
                  <div class="col-md-9">
                     <input type="text" name="nama_kemasan" id="nama_kemasan" class="form-control input-md" placeholder="nama kemasan" value="<?=$this->nama_kemasan;?>" required>
                  </div>
               </div>
               
               <div class="form-group">
                  <label class="col-md-3 control-label" for="isi">isi</label>
                  <div class="col-md-9">
                     <textarea name="isi" id="isi" class="form-control input-md" placeholder="volume kemasan"><?=$this->isi;?></textarea>
                  </div>
               </div>

               <div class="form-group">
                  <div class="col-sm-12">
                     <a href="<?php echo base_url('admin/kemasan');?>" class="btn btn-sm btn-default btn-flat pull-left">Cancel</a>
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