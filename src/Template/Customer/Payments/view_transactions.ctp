<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title><?= SITE_NAME ?>: View Transaction & Upcoming Payments </title>
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
    </head>
    <body class="skin-2">   
        <div class="main-container ace-save-state container" id="main-container">
            <?= $this->Flash->render() ?>  
            <!-- /section:basics/sidebar -->
            <div class="main-content">
                <?php echo $this->cell('Merchants::header', [$merchant->id]); ?>  
                <div class="main-content-inner">
                    <!-- /section:basics/content.breadcrumbs -->
                    <div class="page-content">    
                        <div class="page-header">
                            <h1 style="text-align: center; font-size: 25px; font-weight: bold;">                                    
                                View Payment History & Upcoming Payments
                            </h1>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                <form role="form" class="form-horizontal tranfrom-box">
                                    <input type="hidden" id='merchnat-id' name="merchnat_id" value="<?= $merchant->id ?>" />
                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Merchant :  </label>
                                        <div class="col-sm-9  no-padding-left">                                
                                            <label style="text-align: left;" class="col-sm-12 control-label no-padding-right ng-binding" for="form-field-1"> <?= $merchant->name ?> </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Reference  No. :  </label>
                                        <div class="col-sm-9">
                                            <input id="customer-phone" type="text" class="col-xs-10 col-sm-10 phone" placeholder="Enter Reference  No." maxlength="15" >
                                        </div>
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right">&nbsp; </label>
                                        <div class="col-sm-9" id='error-msg' style="color: red; margin-top: 5px; display: none;">
                                            Invalid Phone
                                        </div>
                                    </div>
                                    <!--<div class="space-4"></div>-->    
                                    <div class="form-group">
                                        <div class="col-md-offset-3 col-md-9">
                                            <a  href="javascript:;" onclick='viewTransactions()'  class="btn btn-info"> <i class="ace-icon fa fa-check bigger-110"></i> Search </a>
                                            &nbsp; &nbsp; &nbsp;
                                            <button onclick="$('#view-bills-and-payments').hide();" type="reset" class="btn"> <i class="ace-icon fa fa-undo bigger-110"></i> Reset </button>
                                        </div>
                                    </div>
                                </form>
                                <!--<div class="hr hr-24"></div>-->

                            </div><!-- /.col -->
                        </div><!-- /.row -->   

                        <div class="row" id="view-bills-and-payments" style="display: none;">
                            <div class='col-xs-12'>
                                <h3 class='header smaller lighter blue'> Bills & Payments </h3>
                                <div class="content-main-area">
                                    <table class='table table-striped table-bordered table-hover'>
                                        <thead>
                                            <tr>   
                                                <th style='text-align: left;'> Name </th>
                                                <th style='text-align: left;'> Ref No. </th>
                                                <th style='text-align: left;'> Email </th>
                                                <th style='text-align: left;'> Phone </th>
                                                <th style='text-align: right;'> Bill Amount </th>                                   
                                                <th style='text-align: center;'> Due Date </th>
                                                <th style='text-align: center;'> Status </th>
                                                <th style='text-align: center;'> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody id="ajax-content"> 
                                            <!-- Ajax Content-->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.page-content -->

                </div>
            </div><!-- /.main-content -->
            <?= $this->element('footer'); ?>
            <!--
            <a href="javascript:;" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
            -->
        </div><!-- /.main-container -->       
        <script src="components/bootstrap/dist/js/bootstrap.js"></script>
        <script src="assets/js/src/ace.js"></script>
        <script src="assets/js/src/ace.basics.js"></script>
        <script src="assets/js/src/ace.sidebar.js"></script>
        <!-- inline scripts related to this page -->
        <script type="text/javascript">

                                                function viewTransactions() {
                                                    var merchnatId = $('#merchnat-id').val();
                                                    var phone = $('#customer-phone').val().trim();
                                                    if (phone) {
                                                        $.get('customer/payments/ajax-view-transactions', {'merchnat_id': merchnatId, 'phone': phone}, function (response) {
                                                            var response = JSON.parse(response);
                                                            if (response.status == 'success') {
                                                                $('#ajax-content').html(response.html);
                                                                $('#view-bills-and-payments').show();
                                                                $('#error-msg').html("").hide();
                                                            } else if (response.status == 'error') {
                                                                $('#view-bills-and-payments').hide();
                                                                $('#error-msg').html(response.msg).show();
                                                            }
                                                        });
                                                    } else {
                                                        $('#customer-phone').focus();
                                                        //$('#error-msg').html('Please enter a valid reference number.').show();
                                                    }
                                                }
                                                $(document).on('keydown', '#customer-id', function (e) {
                                                    if (e.keyCode == 32)
                                                        return false;
                                                });
                                                jQuery(function ($) {
                                                    $('[data-rel=tooltip]').tooltip({container: 'body'});
                                                    $('[data-rel=popover]').popover({container: 'body'});
                                                });
                                                $(document).ready(function () {
                                                    $(".phoneXX").keydown(function (e) {
                                                        // Allow: backspace, delete, tab, escape, enter and .
                                                        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                                                // Allow: Ctrl+A, Command+A
                                                                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                                                        // Allow: home, end, left, right, down, up
                                                                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                                    // let it happen, don't do anything
                                                                    return;
                                                                }
                                                                // Ensure that it is a number and stop the keypress
                                                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                    e.preventDefault();
                                                                }
                                                            });
                                                });
        </script>
    </body>
</html>


