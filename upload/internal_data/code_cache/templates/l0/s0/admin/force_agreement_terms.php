<?php
// FROM HASH: 09a4c9747c41a18a32f80777d40113bc
return array('macros' => array(), 'code' => function($__templater, array $__vars)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Force terms and rules agreement');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['xf']['options']['termsLastUpdate']) {
		$__compilerTemp1 .= $__templater->fn('date_dynamic', array($__vars['xf']['options']['termsLastUpdate'], array(
		)));
	} else {
		$__compilerTemp1 .= 'Never';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'Please confirm that you want to force all current users to accept the following:' . '
				<strong><a href="' . $__templater->escape($__vars['xf']['tosUrl']) . '" target="_blank">' . 'Terms and rules' . ' &middot; ' . 'Last updated' . $__vars['xf']['language']['label_separator'] . ' ' . $__compilerTemp1 . '</a></strong>
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->fn('link', array('force-agreement/terms', ), false),
		'ajax' => 'true',
		'data-force-flash-message' => 'on',
		'class' => 'block',
	)) . '

';
	$__vars['header'] = $__templater->preEscaped('
	<div class="block-header">' . 'Options' . '</div>
');
	$__finalCompiled .= '
' . $__templater->callMacro('option_macros', 'option_form_block', array(
		'options' => $__vars['options'],
		'containerBeforeHtml' => $__vars['header'],
	), $__vars);
	return $__finalCompiled;
});