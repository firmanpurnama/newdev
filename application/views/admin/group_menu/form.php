<div class="row">
   <div class="col-lg-12">
      <?php if (!empty($this->error_msg)):?>
      <div class="alert alert-danger alert-dismissable">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
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
                  <label class="col-md-3 control-label" for="group_id">User Group</label>
                  <div class="col-md-9">
                     <select name="group_id" id="group_id" class="form-control input-md" requred>
                        <option value="">---</option>
                        <?php foreach($groups as $group){?>
                           <option value="<?=$group->id;?>" <?php if ($this->group_id == $group->id){echo "selected";} ?>><?=$group->group_name;?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>

               <div class="form-group">
                  <?php foreach($main_menu as $i => $mm) { ?>
                     <div class="checkbox col-md-4">
                        <label>
                           <?php 
                           $checked = false;
                           if (isset($group_menu)) {
                              foreach($group_menu as $j => $gm){ 
                                 if ($gm->main_menu_id == $mm->id){
                                    $checked = true;
                                    break;
                                 }
                              }
                           }
                           ?>
                           <input type="checkbox" name="ck_main_menu[]" value="<?php echo $mm->id;?>" <?php if ($checked==true) {echo "checked";}?> >
                           <?=$mm->main_menu_name;?>
                        </label>
                     </div>
                  <?php } ?>
               </div>
               

               <div class="form-group">
                  <div class="col-sm-12">
                     <a href="<?php echo base_url('admin/group_menu');?>" class="btn btn-sm btn-default btn-flat pull-left">Cancel</a>
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