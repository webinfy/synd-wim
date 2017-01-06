<div id="navbar" class="navbar navbar-default ace-save-state" style="background: #bbb;" >
    <div class="main-container ace-save-state containerXX" id="main-container" style="background: #f1f1f1;">
        <div class="merchant-header">
            <div class="logo-left"> <a href="<?= HTTP_ROOT ?>"><img src="img/logo/smarthub-logo.png" /></a> </div>            
            <div class="logo-center">
                <?php if (!empty($merchant['merchant_profile']['logo'])) { ?>
                    <img  style="width: 120px;" src="<?= MERCHANT_LOGO . $merchant['merchant_profile']['logo'] ?>" />
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
            </div>
            <div class="logo-right"><img src="img/logo/hdfc-logo.png" /></div>
        </div>
    </div>
</div>
