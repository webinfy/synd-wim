<?php
$amount = $payment->fee;
$late_fee_amount = 0;
if (date('Y-m-d') > date('Y-m-d', strtotime($payment->uploaded_payment_file->payment_cycle_date))) {
    if ($payment->webfront->fixed_late_fee == 2) {
        $days = floor((time() - strtotime($payment->uploaded_payment_file->payment_cycle_date)) / (60 * 60 * 24));
        $late_fee_amount = $payment->webfront->late_fee_amount * $days;
    } else {
        $late_fee_amount = $payment->webfront->late_fee_amount;
    }
}
$amount += $late_fee_amount;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title><?= SITE_NAME ?> : Pay Now</title>

        <base href="<?= HTTP_ROOT; ?>" target="_self">
        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.css" />
        <link rel="stylesheet" href="components/font-awesome/css/font-awesome.css" />
        <!-- page specific plugin styles -->
        <!--<link rel="stylesheet" href="components/bootstrap-duallistbox/dist/bootstrap-duallistbox.css" />-->
        <!-- text fonts -->
        <link rel="stylesheet" href="assets/css/ace-fonts.css" />
        <link rel="stylesheet" href="assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
        <link rel="stylesheet" href="assets/css/ace-skins.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.css" />
        <!-- ace settings handler -->
        <script src="assets/js/ace-extra.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script> window.jQuery || document.write('<script src="components/jquery/dist/jquery.js"><\/script>');</script>     
        <?php echo $this->element('script_file'); ?>

        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            th, td {
                padding: 5px;
                text-align: left;
            }
            table#t01 {
                width: 100%;    
                background-color: #f1f1c1;
            }
        </style>
    </head>

    <body class="skin-2">          

        <div class="main-container ace-save-state container" id="main-container">

            <?= $this->Flash->render() ?>  

            <!-- /section:basics/sidebar -->
            <div class="main-content"> 

                <?php echo $this->cell('Merchants::header', [$payment->webfront->merchant_id]); ?>  

                <div class="main-content-inner">
                    <!-- /section:basics/content.breadcrumbs -->
                    <div class="page-content">                           

                        <div class="page-header">
                            <h1 style="text-align: center; font-size: 25px; font-weight: bold;">                                    
                                Pay Online for <span style="color: green;"><?= $merchant->name ?></span>
                            </h1>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <?php if (!empty($payment->note)) { ?>
                                    <h2 style="text-align: center; font-size: 22px; font-weight: bold; color: #004184;">                                    
                                        <?= $payment->note ?>
                                    </h2>
                                <?php } ?>
                                <div class="go-back-box">
                                    <?php if ($this->request->session()->read('Auth.User.id')) { ?>
                                        <a style="font-weight: bold;color: #155092;" href="<?= HTTP_ROOT ?>">Go Back To Dashboard</a>    
                                    <?php } ?>&nbsp;&nbsp; |&nbsp;&nbsp;
                                    <?php if ($this->request->session()->read('Auth.User.id')) { ?>
                                        <a style="font-weight: bold;color: #155092;" href="<?= 'customer/view-transactions/' . $payment->webfront->user->uniq_id; ?>">Payment History</a>    
                                    <?php } ?>
                                </div><br>
                                <form action="customer/payments/pay-now-redirect/<?= $payment->uniq_id ?>" role="form" class="form-horizontal ng-pristine ng-valid">
                                    <h2 style="font-size: 18px;">Customer Details </h2>
                                    <div class="content-main-area">
                                        <table style="width:100%">
                                            <tr>
                                                <th><?= $payment->webfront->customer_name_alias ?></th>
                                                <th><?= $payment->webfront->customer_reference_number_alias ?></th>
                                                <th><?= $payment->webfront->customer_email_alias ?></th> 
                                                <th><?= $payment->webfront->customer_phone_alias ?> </th>
                                                <?php
                                                $payeeCustomFields = json_decode($payment->payee_custom_fields, TRUE);
                                                if (count($payeeCustomFields) > 0) {
                                                    foreach ($payeeCustomFields as $payeeCustomField) {
                                                        ?>
                                                        <th><?= $payeeCustomField['field'] ?></th>                                            
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tr>
                                            <tr>
                                                <td><?= $payment->name ?></td>
                                                <td><?= $payment->reference_number ?></td>
                                                <td><?= !empty($payment->email) ? $payment->email : "NA"; ?></td>
                                                <td><?= !empty($payment->phone) ? $payment->phone : "NA"; ?></td>
                                                <?php
                                                $payeeCustomFields = json_decode($payment->payee_custom_fields, TRUE);
                                                if (count($payeeCustomFields) > 0) {
                                                    foreach ($payeeCustomFields as $payeeCustomField) {
                                                        ?>
                                                        <td><?= $payeeCustomField['value'] ?></td>                                            
                                                        <?php
                                                    }
                                                }
                                                ?>                                      
                                            </tr>   
                                        </table>
                                        <br>
                                        <h2 style="font-size: 18px;">Payment Details</h2>
                                        <table id="t01">
                                            <tr>
                                                <th>Due Date</th>
                                                <?php
                                                $paymentCustomFields = json_decode($payment->payment_custom_fields, TRUE);
                                                if (count($paymentCustomFields) > 0) {
                                                    foreach ($paymentCustomFields as $paymentCustomField) {
                                                        ?>
                                                        <th><?= $paymentCustomField['field'] ?></th>                                              
                                                        <?php
                                                    }
                                                }
                                                ?>                                      
                                                <th>Total Amount </th>                                            
                                                <!--<th>Convenience Fee </th>-->   
                                                <th>Late Fee </th>  
                                                <?php if ($payment->status == 1) { ?> 
                                                    <th style="text-align: center;">Status </th>  
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <td><?= date('M d, Y', strtotime($payment->uploaded_payment_file->payment_cycle_date)); ?></td>
                                                <?php
                                                $paymentCustomFields = json_decode($payment->payment_custom_fields, TRUE);
                                                if (count($paymentCustomFields) > 0) {
                                                    foreach ($paymentCustomFields as $paymentCustomField) {
                                                        ?>
                                                        <td>Rs. <?= $paymentCustomField['value'] ?></td>                                          
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <td>Rs. <?= $payment->fee ?></td>
                                                <!--<td>Rs. <?= $payment->convenience_fee_amount ?></td>-->                                                
                                                <td>Rs. <?= $late_fee_amount ?></td>                                                
                                                <?php if ($payment->status == 1) { ?> 
                                                    <td style="color: green; font-weight: bold; text-align: center;">Paid</td>   
                                                <?php } ?>
                                            </tr>
                                            <?php
                                            $colspanShow = 2 + count($paymentCustomFields) + (($payment->status == 1) ? 1 : 0);
                                            ?>
                                            <tr>
                                                <td colspan="<?= $colspanShow; ?>" style="color: #155092;font-weight: bold;font-size: 15px;text-align: right;">Net Bill Amount</td>
                                                <td style="font-weight: bold;">Rs. <?= ($amount) ?></td>
                                            </tr>
                                        </table>                                         
                                        <?php if ($payment->webfront->fixed_late_fee == 2) { ?>
                                            <div style="float: right; font-size: 14px; margin-top: 10px; display: block;"> Note : Late Fee is Rs <?= $payment->webfront->late_fee_amount ?> Per Day from Due Date.</div>
                                        <?php } else { ?>
                                            <div style="float: right; font-size: 14px; margin-top: 10px; display: block;"> Note : Late Fee is Flat Rs <?= $payment->webfront->late_fee_amount ?> after Due Date.</div>
                                        <?php } ?>
                                    </div>

                                    <?php if ($payment->status == 0) { ?> 
                                        <div class="form-group">
                                            <div style="width: 100%;float: left;text-align: center;margin-top: 20px;">                                           
                                                <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> &nbsp; </label> 
                                                <div class="col-sm-6 control-label no-padding-right ng-binding" style="text-align: left; color: green; font-weight: bold;"> 
                                                    <input type="checkbox" value="1" required="required" />  <a href="javascript:;" onclick="NewWindow(siteUrl + 'customer/users/term-and-conditions', 'Term & Conditions', 750, 600, true)"><label style="font-weight: bold;">Accept Term & Conditions</label></a>
                                                    <button type="submit"  class="btn btn-warning" style="margin:0 5px;">
                                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                                        Pay Now
                                                    </button>              

                                                    <a href="webfronts/basic/<?= $payment->webfront->url ?>" class="btn">
                                                        <i class="ace-icon fa fa-undo bigger-110"></i>
                                                        Back
                                                    </a>
                                                </div>       

                                            </div>
                                        </div>
                                    <?php } ?>

                                </form>
                            </div><!-- /.row -->     
                        </div><!-- /.row -->  
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->

            <?= $this->element('footer'); ?>

            <a href="javascript:;" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->

        <!--<script src="components/jquery/dist/jquery.js"></script>-->
        <script src="components/bootstrap/dist/js/bootstrap.js"></script>

        <script src="assets/js/src/ace.js"></script>
        <script src="assets/js/src/ace.basics.js"></script>
        <script src="assets/js/src/ace.sidebar.js"></script>

        <!-- inline scripts related to this page -->       
        <script src="js/common.js"></script>
    </body>
</html>



