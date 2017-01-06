<?php
$key = $payment->webfront->user->merchant_profile->payu_key; //"xlIeC9";
$salt = $payment->webfront->user->merchant_profile->payu_salt; //"qVCckzCA";
$txn = "TXN" . time() . rand(1111, 9999);

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


$email = $payment->email;
$name = $payment->name;
$phone = $payment->phone;

$productName = SITE_NAME . " Bill Payment";

$successUrl = HTTP_ROOT . "customer/payments/success/" . $payment->uniq_id;
$failureUrl = HTTP_ROOT . "customer/payments/failure/" . $payment->uniq_id;
$cancelUrl = HTTP_ROOT . "customer/payments/cancel/" . $payment->uniq_id;

$text = "{$key}|{$txn}|{$amount}|{$productName}|{$name}|{$email}|||||||||||{$salt}";
$output = strtolower(hash("sha512", $text));
?>
<form action='https://secure.payu.in/_payment' method='post' id="payUForm">

    <input type="hidden" name="key" value="<?= $key; ?>" />
    <input type="hidden" name="txnid" value="<?php echo $txn; ?>" />
    <input type="hidden" name="amount" value="<?= $amount; ?>" />
    <input type="hidden" name="productinfo" value="<?= $productName ?>" />
    <input type="hidden" name="firstname" value="<?= $name; ?>" />
    <input type="hidden" name="email" value="<?= $email; ?>" />  
    <input type="hidden" name="phone" value="<?= $phone ?>"/>

    <input type="hidden" name="surl" value="<?= $successUrl ?>" /> <!--Success URL where PayUMoney will redirect after successful payment.-->
    <input type="hidden" name="furl" value="<?= $failureUrl ?>" /> <!--Failure URL where PayUMoney will redirect after failed payment.-->  
    <input type="hidden" name="curl" value="<?= $cancelUrl ?>" />  <!--Cancel URL where PayUMoney will redirect when user cancel the transaction.-->

    <input type="hidden" name="hash" value = <?= $output; ?> /> 

</form>

<script>
    setTimeout(function () {
        document.getElementById("payUForm").submit();
    }, 1000);
</script>
<div style="position: relative; width: 600px; margin: auto;">
    <div style="font:bold 16px Arial;color:#333333;text-align:center;display:block;opacity:1;z-index:9999999; margin-top: 100px;">
        <div><?php echo $this->Html->image('loader_100x100.gif', array('alt' => "Loading...", 'title' => 'Please wait...')); ?></div>
        <br/><br/>
        <div>Please wait. We are redirecting you to PayU payment page.</div>
    </div>
</div>
