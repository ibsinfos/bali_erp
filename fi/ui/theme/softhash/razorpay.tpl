{include file="sections/header.tpl"}
<form action="{$_url}client/ipay_razorpay/{$id}/token_{$token}" method="POST">
  <script
    src="https://checkout.razorpay.com/v1/checkout-new.js"
    data-key="{$key}"
    data-amount="{$amount}"
    data-currency="INR"
    data-name="{$name}"
    data-image="{$image}"
    data-description="{$description}"
    data-prefill.name="{$name}"
    data-prefill.email="{$email}"
    data-prefill.contact="{$contact}"
    data-notes.shopping_order_id="{$order_id}"
    data-order_id="{$razorpayOrderId}"
  >
  </script>
  <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
  <input type="hidden" name="shopping_order_id" value="{$order_id}">
  <input type="hidden" name="order_id" value="{$razorpayOrderId}">
</form>
{include file="sections/footer.tpl"}