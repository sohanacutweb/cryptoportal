<?php
if($this->session->userdata('order_details')){
	$session_order = $this->session->userdata('order_details');
	$productName = $session_order['item_name'];
	$productTotal = $session_order['item_price'];
}
?>
<div class="thankyou col-lg-12 text-center">
	<h2>Thank You for completing your order</h2>
	<p>Here is your order receipt</p>
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
                  <td class="cell100 column1"><?=$productName?></td>
                  <td class="cell100 column2">$<?=$productTotal?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
</div>
