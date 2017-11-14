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
            $attributes = array('class'=>'form-horizontal', 'id'=>'formUser');
            echo form_open($this->action_form, $attributes);
            ?>
               <div class="form-group">
                  <label class="col-md-3 control-label" for="group_name">User group</label>
                  <div class="col-md-9">
                     <select name="group_id" class="form-control input-md" required>
                        <option value="">---</option>
                        <?php 
                        if (count($user_groups) > 0):
                           foreach ($user_groups as $key => $ug) {
                              ?>
                              <option value="<?=$ug->id;?>" <?php if($ug->id==$this->user_group_id){echo "selected";}?>><?=$ug->group_name;?></option>
                              <?php
                           }
                        endif;
                        ?>
                     </select>
                  </div>
               </div>
               
               <div class="form-group">
                  <label class="col-md-3 control-label" for="group_name">User name</label>
                  <div class="col-md-9">
                     <input type="text" name="user_name" id="user_name" class="form-control input-md" placeholder="user name" value="<?=$this->user_name;?>" required>
                  </div>
               </div>
               
               <div class="form-group">
                  <label class="col-md-3 control-label" for="email">Email</label>
                  <div class="col-md-9">
                     <input type="email" name="email" id="email" class="form-control input-md" placeholder="email" value="<?=$this->user_email;?>" required>
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-3 control-label" for="passwd">Password</label>
                  <div class="col-md-9">
                     <input type="password" name="passwd" id="passwd" class="form-control input-md" placeholder="password">
                  </div>
               </div>

               <div class="form-group">
                  <label class="col-md-3 control-label" for="passwd">Password confirmation</label>
                  <div class="col-md-9">
                     <input type="password" name="cpasswd" id="cpasswd" class="form-control input-md" placeholder="password confirmation">
                  </div>
               </div>

               <div class="form-group">
                  <div class="col-sm-12">
                     <a href="<?php echo base_url('admin/users');?>" class="btn btn-sm btn-default btn-flat pull-left">Cancel</a>
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