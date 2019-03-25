<?php
// FROM HASH: 54fc6a4c292158d2190db7f29d65bf69
return array('macros' => array(), 'code' => function($__templater, array $__vars)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[live_publishable_key]',
		'value' => $__vars['profile']['options']['live_publishable_key'],
	), array(
		'label' => 'Live publishable key',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[live_secret_key]',
		'value' => $__vars['profile']['options']['live_secret_key'],
	), array(
		'label' => 'Live secret key',
		'explain' => 'Enter the live secret and publishable keys from your Stripe dashboard on the <a href="https://dashboard.stripe.com/account/apikeys" target="_blank">Developers > API keys</a> page. You also need to set up a webhook on the <a href="https://dashboard.stripe.com/account/webhooks">Developers > Webhooks</a> page.',
	)) . '

<hr class="formRowSep" />

' . $__templater->formTextBoxRow(array(
		'name' => 'options[test_publishable_key]',
		'value' => $__vars['profile']['options']['test_publishable_key'],
	), array(
		'label' => 'Test publishable key',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[test_secret_key]',
		'value' => $__vars['profile']['options']['test_secret_key'],
	), array(
		'label' => 'Test secret key',
		'explain' => 'The test keys will only be used if <code>enableLivePayments</code> is set to false in <code>config.php</code>.<br />
<br /><b>Note:</b> Before accepting live payments, you must activate your Stripe account from the Stripe Dashboard.',
	)) . '

<hr class="formRowSep" />

' . $__templater->formRow('
	<div class="formRow-explain">
		' . '<strong>Note:</strong> You must set up a webhook endpoint so that Stripe can send messages in order to verify and process payments. You can do this on the <a href="https://dashboard.stripe.com/account/webhooks">Developers > Webhooks</a> page in your dashboard with the following URL:
		<pre><code>' . $__templater->escape($__vars['xf']['options']['boardUrl']) . '/payment_callback.php?_xfProvider=stripe</code></pre>
		For additional security, it is also recommended to input your "Signing secret" below.' . '
	</div>
', array(
		'label' => '',
	)) . '

<hr class="formRowSep" />

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'label' => 'Verify webhook with signing secret' . $__vars['xf']['language']['label_separator'],
		'selected' => $__vars['profile']['options']['signing_secret'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'options[signing_secret]',
		'value' => $__vars['profile']['options']['signing_secret'],
	))),
		'_type' => 'option',
	)), array(
		'explain' => 'To verify incoming webhook signatures and prevent replay attacks you must provide the &quot;Signing secret&quot;. You can obtain this after setting up the webhook endpoint by clicking the endpoint in your dashboard on the <a href="https://dashboard.stripe.com/account/webhooks">Developers > Webhooks</a> page.',
	)) . '

<hr class="formRowSep" />

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[apple_pay_enable]',
		'selected' => $__vars['profile']['options']['apple_pay_enable'],
		'label' => '
		' . 'Enable Apple Pay support' . '
	',
		'_type' => 'option',
	)), array(
		'explain' => 'Requires domain verification using the <a href="https://dashboard.stripe.com/account/apple_pay" target="_blank">Apple Pay page</a> in your Stripe Dashboard.',
	));
	return $__finalCompiled;
});