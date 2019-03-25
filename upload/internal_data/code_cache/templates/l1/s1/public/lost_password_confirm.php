<?php
// FROM HASH: 015d9e14cfa0b7a4fc6a66dda0ea3ec6
return array('macros' => array(), 'code' => function($__templater, array $__vars)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Reset password');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow($__templater->escape($__vars['user']['username']), array(
		'label' => 'Your name',
	)) . '

			' . $__templater->formPasswordBoxRow(array(
		'name' => 'password',
		'checkstrength' => 'true',
	), array(
		'label' => 'New password',
	)) . '

			' . $__templater->formPasswordBoxRow(array(
		'name' => 'password_confirm',
	), array(
		'label' => 'Confirm new password',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->fn('link', array('lost-password/confirm', $__vars['user'], array('c' => $__vars['c'], ), ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
});