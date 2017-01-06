<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title><?= SITE_NAME ?></title>
        <base href="<?= HTTP_ROOT; ?>" target="">
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

                <!--
                <div id="navbar" class="navbar navbar-default ace-save-state" style="background: #bbb;">
                    <div class="main-container ace-save-state container" id="main-container" style="background: #f1f1f1;">
                        <div style="width: 100%; float: left;  padding: 10px;">
                            <div style="width: 30%; float: left;"> <img style="margin-top: 20px;" src="img/logo/smarthub-logo.png" /></div>
                            <div style="width: 40%; float: left; text-align: center;">
                                <img style="width: 120px;" src="<?= !empty($merchant['merchant_profile']['logo']) ? MERCHANT_LOGO . $merchant['merchant_profile']['logo'] : 'img/logo/web-info-mart-logo.png' ?>" />
                            </div>
                            <div style="width: 30%; float: right;"><img style="float:right; margin-top: 20px;" src="img/logo/hdfc-logo.png" /></div>
                        </div>
                    </div>
                </div>
                -->
                <?php echo $this->element('Customer/outerpage-header'); ?>
                
                <?php //pj($payment); ?>

                <div class="main-content-inner">
                    <!-- /section:basics/content.breadcrumbs -->
                    <div class="page-content" style="min-height: 500px;"> 
                        <div class="page-header">
                            <h1 style="text-align: center; font-size: 25px; font-weight: bold;">
                                Send OTP              
                            </h1>
                        </div><!-- /.page-header -->
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                <form action="" method="POST" role="form" class="form-horizontal ng-pristine ng-valid">
                                    <!-- #section:elements.form -->
                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> <strong>Phone No : </strong> </label> 
                                        <div class="col-sm-6">                                
                                            <input type="text"  name="phone" class="form-control" placeholder="Enter your phone number." />
                                        </div>
                                    </div> 
                                    <div class="form-group clearfixXX form-actionsXX">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button class="btn btn-success" type="submit">
                                                <i class="ace-icon fa fa-check bigger-110"></i>
                                                Submit
                                            </button>
                                            &nbsp; &nbsp; &nbsp;
                                            <button class="btn btn-default" type="reset">
                                                <i class="ace-icon fa fa-undo bigger-110"></i>
                                                Reset
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <!--<div class="hr hr-24"></div>-->
                            </div><!-- /.col -->
                        </div><!-- /.row -->    

                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->

            <?= $this->element('footer'); ?>

            <!--            <a href="javascript:;" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
                        </a>-->

        </div><!-- /.main-container -->
        <!--<script src="components/jquery/dist/jquery.js"></script>-->
        <script src="components/bootstrap/dist/js/bootstrap.js"></script>
        <script src="assets/js/src/ace.js"></script>
        <script src="assets/js/src/ace.basics.js"></script>
        <script src="assets/js/src/ace.sidebar.js"></script>
    </body>
</html>


