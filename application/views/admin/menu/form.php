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
            $attributes = array('class'=>'form-horizontal', 'id'=>'formMenu');
            echo form_open($this->action_form, $attributes);
            ?>
               <div class="form-group">
                  <label class="col-md-3 control-label" for="main_menu_id">Main Menu</label>
                  <div class="col-md-9">
                     <select name="main_menu_id" id="main_menu_id" class="form-control input-md" requred>
                        <option value="">select main menu</option>
                        <?php foreach($main_menu as $mm){?>
                           <option value="<?=$mm->id;?>" <?php if ($this->main_menu_id == $mm->id){echo "selected";} ?>><?=$mm->main_menu_name;?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-3 control-label" for="menu_name">Menu name</label>
                  <div class="col-md-9">
                     <input type="text" name="menu_name" id="menu_name" class="form-control input-md" placeholder="menu name" value="<?=$this->menu_name;?>" required>
                  </div>
               </div>
               
               <div class="form-group">
                  <label class="col-md-3 control-label" for="menu_link">Link</label>
                  <div class="col-md-9">
                     <input type="text" name="menu_link" id="menu_link" class="form-control input-md" placeholder="menu link" value="<?=$this->menu_link;?>" required>
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-3 control-label" for="back_end">Show backend</label>
                  <div class="col-md-9">
                     <select name="back_end" id="back_end" class="form-control input-md" requred>
                        <option value="">---</option>
                        <option value="0" <?php if ($this->backend == 0){echo "selected";} ?>>No</option>
                        <option value="1" <?php if ($this->backend == 1){echo "selected";} ?>>Yes</option>
                     </select>
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-3 control-label" for="back_end">Show frontend</label>
                  <div class="col-md-9">
                     <select name="front_end" id="fron_end" class="form-control input-md" requred>
                        <option value="">---</option>
                        <option value="0" <?php if ($this->frontend == 0){echo "selected";} ?>>No</option>
                        <option value="1" <?php if ($this->frontend == 1){echo "selected";} ?>>Yes</option>
                     </select>
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-3 control-label" for="menu_order">Order</label>
                  <div class="col-md-9">
                     <input type="text" name="menu_order" id="menu_order" class="form-control input-md" placeholder="menu order" value="<?=$this->menu_order;?>" required>
                  </div>
               </div>

               <div class="form-group">
                  <div class="col-sm-12">
                     <a href="<?php echo base_url('admin/menu');?>" class="btn btn-sm btn-default btn-flat pull-left">Cancel</a>
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