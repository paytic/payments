<?php
/** @var Organizers_Forms_Payment_Method_Details $form */
$form = $this->form;
$renderer = $form->getRenderer();
?>

<?php echo $renderer->renderMessages(); ?>
<?php echo $renderer->openTag(); ?>
<?php echo $renderer->renderHidden(); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->getDisplayGroup('Details')->render() ?>
    </div>
    <div class="col-sm-6">
        <?php foreach ($form->getPaymentGatewaysItems() as $gateway) { ?>
            <?php echo $form->getDisplayGroup($gateway->getLabel())->render() ?>
        <?php } ?>
    </div>
</div>
<?php echo $renderer->renderButtons(); ?>
<?php echo $renderer->closeTag(); ?>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        $('#payment_type').change(function () {
            checkPaymentGateway();
        });

        function checkPaymentGateway() {
            $('.payment_gateway_fieldset').hide();
            var gateway = $('#payment_type').val();
            $('#payment_gateway_' + gateway).show();
        }

        checkPaymentGateway();
    });
</script>