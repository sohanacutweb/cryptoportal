<div class="login page-content">
  <div class="col-lg-12">
    <h2>Login</h2>
    <?php if(validation_errors()) { ?>
      <div class="alert alert-danger login_alert">
        <?php echo validation_errors(); ?>
      </div>
    <?php } ?>
    <?php if(isset($_SESSION['invalid'])) { ?>
      <div class="alert alert-danger login_alert">
        <?php echo $_SESSION['invalid']; ?>
      </div>
    <?php 
     unset($_SESSION['invalid']); }
     ?>
    <?php echo form_open('user/actionlogin'); ?>
    
      
      <div class="form-group">
         <input type="text" name="email" class="form-control" id="email" placeholder="Email" value="<?=set_value('email')?>">
      </div>
      <div class="form-group">
         <input type="password" name="password" class="form-control" id="password" placeholder="Password" >
      </div>
      <div class="form-group ">
         <button type="submit" id="register" class="btn btn-primary">Login</button>
      </div>
    </div>
    <?php echo form_close(); ?>
  
</div>