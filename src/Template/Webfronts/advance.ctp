<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title><?= SITE_NAME ?></title>
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

                <?php // echo $this->element('Customer/outerpage-header'); ?> 
                <?php echo $this->cell('Merchants::header', [$webfront->merchant_id]); ?>  


                <div class="main-content-inner">
                    <!-- /section:basics/content.breadcrumbs -->
                    <div class="page-content" style="min-height: 500px;"> 
                        <div class="page-header">
                            <h1 style="text-align: center; font-size: 25px; font-weight: bold;">
                                <?= $webfront->title ?>           
                            </h1>
                        </div><!-- /.page-header -->
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->


                                <div class="webfront">                                    
                                    <div class="webfront_main">
                                        <div class="web_left">
                                            
					    <?php if (!empty($webfront->logo)) { ?>
                                                <div class="bnnr profile_cont"> 
                                                    <img  src="<?= WEBFRONT_LOGO . $webfront->logo ?>"> 
                                                </div>
                                            <?php } else if (!empty($webfront->user->merchant_profile->logo)) { ?>
                                                <div class="bnnr profile_cont"> 
                                                    <img  src="<?= MERCHANT_LOGO . $webfront->user->merchant_profile->logo ?>"> 
                                                </div>
                                            <?php } ?>	
	
                                            <div class="get_in_tch">
                                                <h3 class="touch">Get in Touch</h3>
                                                <ul>
                                                    <li class="no_border"><span class="phn_number"></span>
                                                        <p class="contact_us ng-binding"><strong>Call</strong><br>
                                                            <?= $webfront->phone ?>
                                                        </p>
                                                    </li>
                                                    <li class="no_border"><span class="email"></span>
                                                        <p class="contact_us"><strong>Email</strong><br>
                                                            <a class="mail_thrw ng-binding" href="mailto:<?= $webfront->email ?>"><?= $webfront->email ?></a>
                                                        </p>
                                                    </li>
                                                    <li class="no_border"><span class="address"></span>
                                                        <p class="contact_us ng-binding"><strong>Address</strong><br>
                                                            <?= $webfront->address ?> 
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="web_right"> 
                                            <h2 class="head">
                                                <span> Payment Description</span>                                                
                                            </h2>
                                            <div style="clear: both;">&nbsp;</div>
                                            <div class="wbfrnt_desc"><?= $webfront->description ?></div>  
                                            <?php if ($webfront->is_published == 1) { ?>
                                                <div class="wbfrnt_paynow"><a href="<?= HTTP_ROOT . "webfronts/pay-now/" . $webfront->url ?>" class="pay_btn" > Pay Now </a></div>                                          
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>


                                <!--<div class="hr hr-24"></div>-->
                            </div><!-- /.col -->
                        </div><!-- /.row -->    

                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->
            <?= $this->element('footer'); ?>
        </div><!-- /.main-container -->
        <!--<script src="components/jquery/dist/jquery.js"></script>-->
        <script src="components/bootstrap/dist/js/bootstrap.js"></script>
        <script src="assets/js/src/ace.js"></script>
        <script src="assets/js/src/ace.basics.js"></script>
        <script src="assets/js/src/ace.sidebar.js"></script>
    </body>
</html>


