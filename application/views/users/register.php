<?php
if($this->uri->segment(3)){
$id = $this->uri->segment(3);
if($id==1){
  $productName='Basic';
  $productTotal=99;
}else if($id==2){
  $productName='Standard';
  $productTotal=199;
}else{
  $productName='Unlimited';
  $productTotal=299;
}
}
if($this->session->userdata('logged_in')){
  $loginDet = $this->session->userdata('logged_in');
  $fname = $loginDet['fname'];
  $lname = $loginDet['lname'];
  $uname = $loginDet['uname'];
  $email = $loginDet['email'];
}else{
  $loginDet = "";
  $fname = set_value('fname');
  $lname = set_value('lname');
  $uname = set_value('username');
  $email = set_value('email');
}
?>
<div class="register page-content">
  <div class="col-lg-12">
    <?php if(empty($loginDet)){ ?>
    <div class="return-alert col-lg-4">
      <p>Returning Customer? <a href="<?php echo base_url(); ?>user"> Click here to login</a></p>
    </div>
  <?php } ?>
    
    <?php if(validation_errors()) { ?>
      <div class="alert alert-danger auth_alert">
        <?php echo validation_errors(); ?>
      </div>
    <?php }
     ?>
    <?php echo form_open('user/actionregister/'.$id.''); ?>
    <div class="personal_details col-lg-6">
      <h2>Personal Details</h2>
        <input type="hidden" name="product_name" value="<?=$productName?>">
        <input type="hidden" name="product_price" value="<?=$productTotal?>">
      <div class="form-group customer_name">
         <input type="text" name="fname" class="form-control" id="fname" placeholder="First Name *" value="<?=$fname?>">
      </div>
      <div class="form-group customer_name">
         <input type="text" name="lname" class="form-control" id="lname" placeholder="Last Name" value="<?=$lname?>">
      </div>
      <div class="form-group">
         <input type="text" name="email" class="form-control" id="email" placeholder="Email *" value="<?=$email?>">
      </div>
      <?php if(empty($loginDet)){ ?>
      <div class="form-group">
         <input type="text" name="username" class="form-control" id="username" placeholder="User Name *" value="<?=$uname?>">
      </div>
      <div class="form-group">
         <input type="password" name="password" class="form-control" id="password" placeholder="New Signup Password *">
      </div>
      <div class="form-group">
         <input type="password" name="confirm_password" class="form-control" id="confirm-password" placeholder="Confirm Password *">
      </div>
    <?php } ?>
    </div>
    
    <div class="billing_details col-lg-6">
      <h2>Billing Details</h2>
      <div class="form-group">
        <input type="text" name="country" class="form-control" id="country" placeholder="Country *" value="<?=set_value('country')?>">
      </div>
      <div class="form-group">
        <input type="text" name="address" class="form-control" id="address" placeholder="Address *" value="<?=set_value('address')?>">
      </div>
      <div class="form-group">
        <input type="text" name="city" class="form-control" id="city" placeholder="Town / City *" value="<?=set_value('city')?>">
      </div>
      <div class="form-group">
        <input type="text" name="state" class="form-control" id="state" placeholder="State" value="<?=set_value('state')?>">
      </div>
      <div class="form-group">
        <input type="text" name="postcode" class="form-control" id="postcode" placeholder="Postcode / Zip *" value="<?=set_value('postcode')?>">
      </div>
      <div class="form-group">
        <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone" value="<?=set_value('phone')?>">
      </div>
    </div>
      <h2>Your Order</h2>
      <div class="order_details col-lg-12">
       <div class="table100 ver1 m-b-110">
        <div class="table100-head">
            <table>
              <thead>
                <tr class="row100 head">
                  <th class="cell100 column1">Product</th>
                  <th class="cell100 column2">Total</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="table100-body">
            <table>
              <tbody>
                <tr class="row100 body">
                  <td class="cell100 column1"><?= $productName; ?></td>
                  <td class="cell100 column2">$<?= $productTotal; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="form-group ">
         <button type="submit" id="register" class="btn btn-primary">Register</button>
      </div>
    </div>
    <?php echo form_close(); ?>
  
</div>