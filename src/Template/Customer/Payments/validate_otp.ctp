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

                <?php echo $this->element('Customer/outerpage-header'); ?>

                <div class="main-content-inner">
                    <!-- /section:basics/content.breadcrumbs -->
                    <div class="page-content" style="min-height: 500px;"> 
                        <div class="page-header">
                            <h1 style="text-align: center; font-size: 25px; font-weight: bold;">
                                Validate OTP              
                            </h1>
                        </div><!-- /.page-header -->
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                <form action="" method="POST" role="form" class="form-horizontal ng-pristine ng-valid">
                                    <!-- #section:elements.form -->

                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> <strong>Enter OTP : </strong> </label> 
                                        <div class="col-sm-5">                                
                                            <input type="text"  name="otp" class="form-control" placeholder="Enter OTP" />
                                        </div>
                                        <div class="col-sm-2 pull-left">
                                            <!--<a style="float: right;" class="btn btn btn-primary" href="<?= HTTP_ROOT . "customer/resend-otp/{$this->request->pass[0]}" ?>">Resend OTP</a>-->       
                                        </div> 
                                    </div> 

                                    <!--
                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> &nbsp; </label> 
                                        <div class="col-sm-6">                                
                                            <a style="float: right;" class="btn btn btn-primary" href="<?= HTTP_ROOT . "customer/resend-otp/{$this->request->pass[0]}" ?>">Resend OTP</a>                                            
                                        </div>
                                    </div> 
                                    -->
                                    
                                    <div class="form-group">
                                        <div class="col-md-offset-3 col-md-5 text-right">
                                            <a class="btn btn btn-sm btn-primary" href="<?= HTTP_ROOT . "customer/resend-otp/{$this->request->pass[0]}" ?>">Resend OTP</a>                          
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-3 col-md-5 text-center">
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


