!function($, window, document, _undefined)
{
	"use strict";

	XF.PaymentProviderContainer = XF.Element.newHandler({

		options: {},

		init: function ()
		{
			if (!this.$target.is('form'))
			{
				console.error('%o is not a form', this.$target[0]);
				return;
			}

			this.$target.on('ajax-submit:response', XF.proxy(this, 'submitResponse'));
		},

		submitResponse: function(event, response)
		{
			if (response.providerHtml)
			{
				event.preventDefault();

				var $replyContainer = this.$target.parent().find('.js-paymentProviderReply-'
					+ response.purchasableTypeId
					+ response.purchasableId
				);

				XF.setupHtmlInsert(response.providerHtml, function($html, container)
				{
					$replyContainer.html($html);
				});
			}
		}
	});

	XF.BraintreePaymentForm = XF.Element.newHandler({

		options: {
			clientToken: null,
			formStyles: '.js-formStyles'
		},

		xhr: null,

		init: function ()
		{
			this.$target.on('submit', XF.proxy(this, 'submit'));

			var urls = [
				'https://js.braintreegateway.com/web/3.19.0/js/client.min.js',
				'https://js.braintreegateway.com/web/3.19.0/js/hosted-fields.min.js'
			];
			XF.loadScripts(urls, XF.proxy(this, 'postInit'));

			var overlay = this.$target.closest('.overlay-container').data('overlay');
			overlay.on('overlay:hidden', function()
			{
				overlay.destroy();
			});
		},

		postInit: function()
		{
			if (!this.options.clientToken)
			{
				console.error('Form must contain a data-client-token attribute.');
				return;
			}

			var self = this,
				$styleData = this.$target.find(this.options.formStyles) || {},
				style = $styleData ? $.parseJSON($styleData.first().html()) : {},
				options = {
					authorization: this.options.clientToken
				};

			braintree.client.create(options, function(clientErr, clientInstance)
			{
				if (clientErr)
				{
					XF.alert(clientErr.message);
					return;
				}

				var options = {
					client: clientInstance,
					styles: style,
					fields: {
						number: {
							selector: '#card-number',
							placeholder: '1234 1234 1234 1234'
						},
						expirationDate: {
							selector: '#card-expiry',
							placeholder: 'MM / YY'
						},
						cvv: {
							selector: '#card-cvv',
							placeholder: 'CVC'
						}
					}
				};
				braintree.hostedFields.create(options, function (hostedFieldsErr, hostedFieldsInstance)
				{
					if (hostedFieldsErr)
					{
						XF.alert(hostedFieldsErr.message);
						return;
					}

					var fields = hostedFieldsInstance._fields;
					for (var key in fields)
					{
						if (fields.hasOwnProperty(key))
						{
							var $elem = $(fields[key]['containerElement']);
							$elem.removeClass('is-disabled');
						}
					}

					hostedFieldsInstance.on('cardTypeChange', function(e)
					{
						var brand = (e.cards.length === 1 ? e.cards[0].type : 'unknown'),
							brandClasses = {
								'visa': 'fa-cc-visa',
								'master-card': 'fa-cc-mastercard',
								'american-express': 'fa-cc-amex',
								'discover': 'fa-cc-discover',
								'diners-club': 'fa-cc-diners',
								'jcb': 'fa-cc-jcb',
								'unionpay': 'fa-credit-card-alt',
								'maestro' : 'fa-credit-card-alt',
								'unknown': 'fa-credit-card-alt'
							};

						if (brand)
						{
							var $brandIconElement = $('#brand-icon'),
								faClass = 'fa-credit-card-alt';

							if (brand in brandClasses)
							{
								faClass = brandClasses[brand];
							}

							$brandIconElement[0].className = '';
							$brandIconElement.addClass('fa');
							$brandIconElement.addClass('fa-lg');
							$brandIconElement.addClass(faClass);
						}
					});

					var $form = self.$target;
					$form.on('submit', function(e)
					{
						e.preventDefault();

						hostedFieldsInstance.tokenize(function (tokenizeErr, payload)
						{
							if (tokenizeErr)
							{
								var message = tokenizeErr.message,
									invalidKeys = tokenizeErr.details.invalidFieldKeys;
								if (invalidKeys)
								{
									message += ' (' + invalidKeys.join(', ') + ')';
								}

								XF.alert(message);
								return;
							}

							self.response(payload);
						});
					});
				});
			});
		},

		submit: function(e)
		{
			e.preventDefault();
			return false;
		},

		response: function(object)
		{
			if (this.xhr)
			{
				this.xhr.abort();
			}

			this.xhr = XF.ajax('post', this.$target.attr('action'), object, XF.proxy(this, 'complete'), { skipDefaultSuccess: true });
		},

		complete: function(data)
		{
			this.xhr = null;

			if (data.redirect)
			{
				XF.redirect(data.redirect);
			}
		}
	});

	XF.BraintreeApplePayForm = XF.Element.newHandler({

		options: {
			clientToken: null,
			currencyCode: '',
			boardTitle: '',
			title: '',
			amount: ''
		},

		xhr: null,

		init: function ()
		{
			var urls = [
				'https://js.braintreegateway.com/web/3.19.0/js/client.min.js',
				'https://js.braintreegateway.com/web/3.19.0/js/apple-pay.min.js'
			];
			XF.loadScripts(urls, XF.proxy(this, 'postInit'));
		},

		postInit: function()
		{
			if (!this.options.clientToken)
			{
				console.error('Form must contain a data-client-token attribute.');
				return;
			}

			var self = this,
				canMakePayments = false;
			if (window.ApplePaySession && ApplePaySession.canMakePayments())
			{
				canMakePayments = true;
			}

			if (!canMakePayments)
			{
				return;
			}

			braintree.client.create({ authorization: this.options.clientToken }, function(clientErr, clientInstance)
			{
				if (clientErr)
				{
					XF.alert(clientErr.message);
					return;
				}

				braintree.applePay.create({ client: clientInstance }, function(applePayErr, applePayInstance)
				{
					if (applePayErr)
					{
						XF.alert(applePayErr.message);
						return;
					}

					var promise = ApplePaySession.canMakePaymentsWithActiveCard(applePayInstance.merchantIdentifier);
					promise.then(function(canMakePaymentsWithActiveCard)
					{
						if (!canMakePaymentsWithActiveCard)
						{
							console.warn('No Apple Pay card available');
							return;
						}

						self.$target.removeClass('u-hidden');

						var $form = self.$target,
							$submit = $form.find('.js-applePayButton');

						$submit.on('click', function()
						{
							var paymentRequest = applePayInstance.createPaymentRequest({
								total: {
									label: self.options.title,
									amount: self.options.amount
								}
							});

							var session = new ApplePaySession(2, paymentRequest);

							session.onvalidatemerchant = function(e)
							{
								applePayInstance.performValidation({ validationURL: e.validationURL, displayName: self.options.boardTitle }, function (validationErr, merchantSession)
								{
									if (validationErr)
									{
										XF.alert(validationErr.message);
										session.abort();
										return;
									}
									session.completeMerchantValidation(merchantSession);
								});
							};

							session.onpaymentauthorized = function(e)
							{
								applePayInstance.tokenize({ token: e.payment.token }, function(tokenizeErr, payload)
								{
									if (tokenizeErr)
									{
										XF.alert(tokenizeErr.message);
										session.completePayment(ApplePaySession.STATUS_FAILURE);
										return;
									}
									session.completePayment(ApplePaySession.STATUS_SUCCESS);

									self.response(payload);
								});
							};

							session.begin();
						});
					});
				});
			});
		},

		response: function(object)
		{
			if (this.xhr)
			{
				this.xhr.abort();
			}

			this.xhr = XF.ajax('post', this.$target.attr('action'), object, XF.proxy(this, 'complete'), { skipDefaultSuccess: true });
		},

		complete: function(data)
		{
			this.xhr = null;

			if (data.redirect)
			{
				XF.redirect(data.redirect);
			}
		}
	});

	XF.BraintreePayPalForm = XF.Element.newHandler({

		options: {
			clientToken: null,
			paypalButton: '#paypal-button',
			testPayments: false
		},

		xhr: null,

		init: function()
		{
			var urls = [
				'https://www.paypalobjects.com/api/checkout.js',
				'https://js.braintreegateway.com/web/3.19.0/js/client.min.js',
				'https://js.braintreegateway.com/web/3.19.0/js/paypal-checkout.min.js',
				'https://js.braintreegateway.com/web/3.19.0/js/data-collector.min.js'
			];
			XF.loadScripts(urls, XF.proxy(this, 'postInit'));
		},

		postInit: function()
		{
			if (!this.options.clientToken)
			{
				console.error('Form must contain a data-client-token attribute.');
				return;
			}

			var self = this,
				options = {
					authorization: this.options.clientToken
				};

			braintree.client.create(options, function(clientErr, clientInstance)
			{
				if (clientErr)
				{
					XF.alert(clientErr.message);
					return;
				}

				braintree.paypalCheckout.create({ client: clientInstance }, function(paypalCheckoutErr, paypalCheckoutInstance)
				{
					if (paypalCheckoutErr)
					{
						XF.alert(paypalCheckoutErr.message);
						return;
					}

					paypal.Button.render({
						env: self.options.testPayments ? 'sandbox' : 'production',

						payment: function()
						{
							return paypalCheckoutInstance.createPayment({
								flow: 'vault',
								enableShippingAddress: false
							});
						},

						onAuthorize: function(data, actions)
						{
							return paypalCheckoutInstance.tokenizePayment(data).then(function(payload)
							{
								self.response(payload);
							});
						},

						onCancel: function (data)
						{
							console.log('checkout.js payment cancelled', JSON.stringify(data, 0, 2));
						},

						onError: function (err)
						{
							XF.alert(err.message);
						}
					}, self.options.paypalButton);
				});
			});
		},

		response: function(object)
		{
			if (this.xhr)
			{
				this.xhr.abort();
			}

			this.xhr = XF.ajax('post', this.$target.attr('action'), object, XF.proxy(this, 'complete'), { skipDefaultSuccess: true });
		},

		complete: function(data)
		{
			this.xhr = null;

			if (data.redirect)
			{
				XF.redirect(data.redirect);
			}
		}
	});

	XF.StripePaymentForm = XF.Element.newHandler({

		options: {
			publishableKey: null,
			formStyles: '.js-formStyles'
		},

		stripe: null,
		elements: null,
		elementsCache: {},

		processing: null,

		init: function ()
		{
			this.$target.on('submit', XF.proxy(this, 'submit'));
			XF.loadScript('https://js.stripe.com/v3/', XF.proxy(this, 'postInit'));
		},

		postInit: function()
		{
			if (!this.options.publishableKey)
			{
				console.error('Form must contain a data-publishable-key attribute.');
				return;
			}

			this.stripe = Stripe(this.options.publishableKey);
			this.elements = this.stripe.elements();

			this.initElements();

			var self = this;
			var overlay = this.$target.closest('.overlay-container').data('overlay');
			overlay.on('overlay:hidden', function()
			{
				overlay.destroy();
				delete XF.loadedScripts['https://js.stripe.com/v3/'];

				// remove any iframes created by Stripe to completely reset
				var $iframes = $('iframe');
				$iframes.each(function()
				{
					var $iframe = $(this);
					if ($iframe.attr('name').toLowerCase().indexOf('stripe') >= 0)
					{
						$iframe.remove();
					}
				});
			});
		},

		initElements: function()
		{
			var elements = this.elements,
				$styleData = this.$target.find(this.options.formStyles) || {},
				style = $styleData ? $.parseJSON($styleData.first().html()) : {};

			var cardNumber = elements.create('cardNumber', {
				style: style
			});
			cardNumber.mount('#card-number-element');
			this.elementsCache['cardNumber'] = cardNumber;

			cardNumber.on('change', function(e)
			{
				var brand = e.brand,
					brandClasses = {
						'visa': 'fa-cc-visa',
						'mastercard': 'fa-cc-mastercard',
						'amex': 'fa-cc-amex',
						'discover': 'fa-cc-discover',
						'diners': 'fa-cc-diners',
						'jcb': 'fa-cc-jcb',
						'unknown': 'fa-credit-card-alt'
					};

				var $brandIconElement = $('#brand-icon'),
					faClass = 'fa-credit-card',
					addClass, removeClass;

				$brandIconElement[0].className = '';

				if (brand && brand !== 'unknown')
				{
					if (brand in brandClasses)
					{
						faClass = brandClasses[brand];
						addClass = 'fab';
						removeClass = 'fa' + XF.config.fontAwesomeWeight;
					}
					else
					{
						addClass = 'fa' + XF.config.fontAwesomeWeight;
						removeClass = 'fab';
					}
				}
				else
				{
					addClass = 'fa' + XF.config.fontAwesomeWeight;
					removeClass = 'fab';
				}

				$brandIconElement.addClass(addClass);
				$brandIconElement.removeClass(removeClass);
				$brandIconElement.addClass('fa-lg');
				$brandIconElement.addClass(faClass);
			});

			var cardExpiry = elements.create('cardExpiry', {
				style: style
			});
			cardExpiry.mount('#card-expiry-element');
			this.elementsCache['cardExpiry'] = cardExpiry;

			var cardCvc = elements.create('cardCvc', {
				style: style
			});
			cardCvc.mount('#card-cvc-element');
			this.elementsCache['cardCvc'] = cardCvc;
		},

		submit: function(e)
		{
			e.preventDefault();

			if (this.processing)
			{
				return false;
			}

			this.processing = true;

			var self = this,
				$submit = $(e.target),
				stripe = this.stripe,
				cardNumber = this.elementsCache['cardNumber'],
				$errorContainer = $('#card-errors-container'),
				$error = $errorContainer.find('#card-errors');

			$submit.addClass('is-disabled')
				.prop('disabed', true);

			stripe.createToken(cardNumber).then(function(result)
			{
				if (result.error)
				{
					$error.text(result.error.message);

					$error.removeClass('u-hidden');
					$errorContainer.removeClass('u-hidden');

					self.processing = false;
				}
				else
				{
					$errorContainer.addClass('u-hidden');
					$error.addClass('u-hidden');

					$error.text('');

					self.stripeTokenHandler(result.token);
				}
			});
		},

		stripeTokenHandler: function(token)
		{
			var $form = this.$target,
				$input = $('<input type="hidden" />');

			$input.attr('name', 'response[id]');
			$input.attr('value', token.id);

			$form.append($input);

			this.response();
		},

		response: function()
		{
			var $form = this.$target,
				formData = XF.getDefaultFormData($form);

			XF.ajax('post', $form.attr('action'), formData, XF.proxy(this, 'complete'), { skipDefaultSuccess: true });
		},

		complete: function(data)
		{
			this.processing = false;

			if (data.redirect)
			{
				XF.redirect(data.redirect);
			}
		}
	});

	XF.StripeApplePayForm = XF.Element.newHandler({

		options: {
			publishableKey: null,
			currencyCode: '',
			title: '',
			amount: ''
		},

		xhr: null,

		init: function ()
		{
			var $form = this.$target,
				$submit = $form.find('.js-applePayButton');

			$submit.on('click', XF.proxy(this, 'click'));

			$form.on('submit', XF.proxy(this, 'submit'));
			XF.loadScript('https://js.stripe.com/v2/', XF.proxy(this, 'postInit'));
		},

		postInit: function()
		{
			if (!this.options.publishableKey)
			{
				console.error('Form must contain a data-publishable-key attribute.');
				return;
			}

			var self = this;

			Stripe.setPublishableKey(this.options.publishableKey);
			Stripe.applePay.checkAvailability(function(available)
			{
				if (available)
				{
					self.$target.removeClass('u-hidden');
				}
			});
		},

		click: function()
		{
			var locale = XF.getLocale(),
				countryCode = locale.split('_').pop(),
				self = this;

			var paymentRequest = {
				countryCode: countryCode,
				currencyCode: this.options.currencyCode,
				total: {
					label: this.options.title,
					amount: this.options.amount
				}
			};

			var session = Stripe.applePay.buildSession(paymentRequest, function(result, completion)
			{
				if (self.xhr)
				{
					self.xhr.abort();
				}

				self.xhr = XF.ajax('post', self.$target.attr('action'), { 'response[id]': result.token.id }, function(data)
				{
					completion(ApplePaySession.STATUS_SUCCESS);

					self.xhr = null;

					if (data.redirect)
					{
						XF.redirect(data.redirect);
					}
				}, { skipDefaultSuccess: true });

				self.xhr.fail(function()
				{
					completion(ApplePaySession.STATUS_FAILURE);
				});
			}, function(error)
			{
				XF.alert(error);
			});

			session.oncancel = function()
			{
				console.log("User hit the cancel button in the payment window");
			};

			session.begin();
		}
	});

	XF.Element.register('payment-provider-container', 'XF.PaymentProviderContainer');

	XF.Element.register('braintree-payment-form', 'XF.BraintreePaymentForm');
	XF.Element.register('braintree-apple-pay-form', 'XF.BraintreeApplePayForm');
	XF.Element.register('braintree-paypal-form', 'XF.BraintreePayPalForm');

	XF.Element.register('stripe-payment-form', 'XF.StripePaymentForm');
	XF.Element.register('stripe-apple-pay-form', 'XF.StripeApplePayForm');
}
(jQuery, window, document);