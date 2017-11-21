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
            $attributes = array('class'=>'form-horizontal', 'id'=>'formMainMenu');
            echo form_open($this->action_form, $attributes);
            ?>               
               <div class="form-group">
                  <label class="col-md-3 control-label" for="main_menu_name">Menu name</label>
                  <div class="col-md-9">
                     <input type="text" name="main_menu_name" id="main_menu_name" class="form-control input-md" placeholder="menu name" value="<?=$this->main_menu_name;?>" required>
                  </div>
               </div>
               
               <div class="form-group">
                  <label class="col-md-3 control-label" for="link">Link</label>
                  <div class="col-md-9">
                     <input type="text" name="link" id="link" class="form-control input-md" placeholder="menu link" value="<?=$this->main_menu_link;?>" required>
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-3 control-label" for="menu_type">Menu type</label>
                  <div class="col-md-9">
                     <select name="menu_type" id="menu_type" class="form-control input-md" requred>
                        <option value="">select menu type</option>
                        <option value="0" <?php if ($this->menu_type == 0){echo "selected";} ?>>Single menu</option>
                        <option value="1" <?php if ($this->menu_type == 1){echo "selected";} ?>>Dropdown menu</option>
                     </select>
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
                  <label class="col-md-3 control-label" for="menu_order">Order menu</label>
                  <div class="col-md-9">
                     <input type="text" name="menu_order" id="menu_order" class="form-control input-md" value="<?=$this->menu_order;?>" placeholder="order menu">
                  </div>
               </div>

               <div class="form-group">
                  <div class="col-sm-12">
                     <a href="<?php echo base_url('admin/main_menu');?>" class="btn btn-sm btn-default btn-flat pull-left">Cancel</a>
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