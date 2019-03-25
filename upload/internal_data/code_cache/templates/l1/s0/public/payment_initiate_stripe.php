<?php
// FROM HASH: 2549c454b27bf71d58505c8ec6f1f11d
return array('macros' => array(), 'code' => function($__templater, array $__vars)
{
	$__finalCompiled = '';
	$__templater->includeCss('payment_initiate.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'xf/payment.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Enter payment details');
	$__finalCompiled .= '

<div class="blocks">
	' . $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->formInfoRow('
					<div class="block-rowMessage block-rowMessage--error block-rowMessage--iconic u-hidden" id="card-errors"></div>
				', array(
		'id' => 'card-errors-container',
		'rowclass' => 'u-hidden',
	)) . '

				' . $__templater->formRow('
					<div class="inputGroup">
						<div class="inputGroup-text"><span style="width: 30px;">' . $__templater->fontAwesome('fa-lg fa-credit-card', array(
		'id' => 'brand-icon',
	)) . '</span></div>
						<div id="card-number-element" class="input"></div>
						<div class="inputGroup-splitter"></div>
						<div id="card-expiry-element" class="input" style="width: 130px"></div>
						<div class="inputGroup-splitter"></div>
						<div id="card-cvc-element" class="input" style="width: 75px"></div>
					</div>
					<div class="formRow-explain">' . 'Payments are processed securely by <a href="' . 'https://stripe.com/' . '" target="_blank">' . 'Stripe' . '</a>. We do not process or store your payment details.' . '</div>
				', array(
		'controlid' => 'card-number-element',
		'rowtype' => 'input',
		'label' => 'Pay by card',
	)) . '

				<hr class="formRowSep" />

				' . $__templater->formRow('
					' . $__templater->button('
						' . 'Pay ' . $__templater->filter($__vars['purchase']['cost'], array(array('currency', array($__vars['purchase']['currency'], )),), true) . '' . '
					', array(
		'type' => 'submit',
		'icon' => 'payment',
	), '', array(
	)) . '
				', array(
		'label' => '',
		'rowtype' => 'button',
	)) . '

				<script type="application/json" class="js-formStyles">
					{
						"base": {
							"color": "' . $__templater->filter($__templater->fn('parse_less_color', array($__templater->fn('property', array('textColor', '#141414', ), false), ), false), array(array('escape', array('json', )),), true) . '",
							"fontFamily": "' . $__templater->filter($__templater->fn('property', array('fontFamilyUi', ), false), array(array('escape', array('json', )),), true) . '",
							"fontSize": "16px"
						},
						"invalid": {
							"color": "#c84448"
						}
					}
				</script>
			</div>
		</div>
	', array(
		'action' => $__templater->fn('link', array('purchase/process', null, array('request_key' => $__vars['purchaseRequest']['request_key'], ), ), false),
		'class' => 'block block--paymentInitiate',
		'data-xf-init' => 'stripe-payment-form',
		'data-publishable-key' => $__vars['publishableKey'],
	)) . '

	';
	if ($__vars['paymentProfile']['options']['apple_pay_enable']) {
		$__finalCompiled .= '
		' . $__templater->form('

			<div class="blocks-textJoiner"><span></span><em>' . 'or' . '</em><span></span></div>
			<div class="block-container">
				<div class="block-body">
					' . $__templater->formRow('
						' . $__templater->button('&nbsp;', array(
			'class' => 'button--apple js-applePayButton',
		), '', array(
		)) . '
					', array(
			'rowtype' => 'button',
			'label' => 'Pay with Apple Pay',
		)) . '
				</div>
			</div>
		', array(
			'action' => $__templater->fn('link', array('purchase/process', null, array('request_key' => $__vars['purchaseRequest']['request_key'], ), ), false),
			'class' => 'block u-hidden',
			'data-xf-init' => 'stripe-apple-pay-form',
			'data-publishable-key' => $__vars['publishableKey'],
			'data-currency-code' => $__vars['purchase']['currency'],
			'data-title' => $__vars['purchase']['purchasableTitle'],
			'data-amount' => $__vars['purchase']['cost'],
		)) . '
	';
	}
	$__finalCompiled .= '
</div>';
	return $__finalCompiled;
});