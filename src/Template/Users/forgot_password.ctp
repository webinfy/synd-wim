<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title><?= SITE_NAME ?> : Forgot Password </title>

        <base href="<?= HTTP_ROOT; ?>" target="_self">

        <meta name="description" content="User login page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.css" />
        <link rel="stylesheet" href="components/font-awesome/css/font-awesome.css" />

        <!-- text fonts -->
        <link rel="stylesheet" href="assets/css/ace-fonts.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="assets/css/ace.css" />

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="assets/css/ace-part2.css" />
        <![endif]-->
        <link rel="stylesheet" href="assets/css/ace-rtl.css" />
        <style>
            /*******Succes & Error Message Start*******/
            div.message::before {
                background-color: #fff;
                border-radius: 15px;
                color: #1AAF65;
                content: "i";
                display: inline-block;
                font-size: 16px;
                left: -11px;
                padding: 2px 11px 2px 5px;
                position: relative;
                text-align: center;
                vertical-align: middle;
                width: 12px;
            }
            div.message {
                background-color: #1AAF65;
                color: #FFF;
                cursor: pointer;
                display: block;
                font-size: 13px;
                font-weight: normal;
                overflow: hidden;
                padding: 5px 15px;
                position: relative !important;
                left: 0;
                top: -10px;               
                transition: height 300ms ease-out 0s;
                z-index: 999;
            }
            div.message.error {
                background-color: #C3232D;
                color: #FFF;
            }
            div.message.error:before {   
                color: #C3232D;
                content: "x";
            }
            .logo-row-1 {
                background: #e5e6e8;
                width: 100%;
                float: left;
                padding: 10px;
            }
        </style>
    </head>

    <body class="login-layout light-login" style="background: #FFEC69;">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">
                            <div class="space-24"></div>
                            <div class="space-32"></div>
                            <!--
                            <div class="center">
                                <h4 class="blue" id="id-company-text"><img src="img/logo/web-info-mart-logo.png" /></h4>
                            </div>
                            -->
                            <div class="space-6"></div>                           

                            <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="logo-row-1">
                                            <img style="width: 150px; " src="img/logo/smarthub-logo.png" />
                                            <img style="width: 150px; float:right;" src="img/logo/hdfc-logo.png" />
                                        </div>
                                        <div class="widget-main">

                                            <h4 class="header blue lighter bigger" style="text-align: left;">                                               
                                                <i class="ace-icon fa fa-key green"></i>
                                                Retrieve Password 
                                            </h4>

                                            <?= $this->Flash->render() ?>

                                            <div class="space-6"></div>

                                            <!--<form method="post">-->
                                            <?php echo $this->Form->create(NULL, ['type' => 'post']); ?>
                                            <fieldset>
                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <?php echo $this->Form->input('phone', ['type' => 'text', 'class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Enter Email or Phone', 'required' => TRUE]); ?>
                                                        <i class="ace-icon fa fa-envelope"></i>
                                                    </span>
                                                </label>


                                                <div class="space"></div>

                                                <div class="clearfix">                                                    

                                                    <button type="submit" name="login" class="width-35 pull-right btn btn-sm btn-primary button-red">
                                                        <i class="ace-icon fa fa-lightbulb-o"></i>
                                                        <span class="bigger-110">Send OTP</span>
                                                    </button>
                                                </div>

                                                <div class="space-4"></div>
                                            </fieldset>
                                            <!--</form>-->
                                            <?php echo $this->Form->end(); ?> 

                                        </div><!-- /.widget-main -->

                                        <div class="toolbar clearfix" style="background: #F26321;">

                                            <div>                                               
                                                <a href="<?= HTTP_ROOT ?>" class="forgot-password-link">
                                                    <i class="ace-icon fa fa-arrow-left"></i>
                                                    Back to Login
                                                </a>
                                            </div>

                                        </div>
                                    </div><!-- /.widget-body -->
                                </div><!-- /.login-box -->  


                            </div><!-- /.position-relative -->                          

                            <!--<div style="position: relative; margin: auto; width: 400px; ">-->
                            <div style="color: #318BCC; text-align: center; margin: 25px; font-size: 16px;" class="blue bolder">Powered by  &nbsp;<img style="margin-top: -5px;" src="img/logo/PayUbiz-Logo.png" /></div>
                            <!--</div>-->

                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.main-content -->
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->
        <script src="components/jquery/dist/jquery.js"></script>   
    </body>
</html>
