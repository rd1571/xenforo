<?php
// FROM HASH: 390981605f0e102e4849a2a86a28d4de
return array('macros' => array(), 'code' => function($__templater, array $__vars)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRadioRow(array(
		'name' => $__vars['inputName'] . '[type]',
	), array(array(
		'selected' => $__vars['option']['option_value']['type'] == '',
		'label' => 'No privacy policy',
		'_type' => 'option',
	),
	array(
		'value' => 'default',
		'selected' => $__vars['option']['option_value']['type'] == 'default',
		'label' => 'Default URL' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->fn('link_type', array('public', 'canonical:help/privacy-policy', ), true),
		'_type' => 'option',
	),
	array(
		'value' => 'custom',
		'selected' => $__vars['option']['option_value']['type'] == 'custom',
		'label' => 'Custom URL',
		'_dependent' => array($__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[custom]',
		'value' => $__vars['option']['option_value']['custom'],
	))),
		'_type' => 'option',
	)), array(
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
	));
	return $__finalCompiled;
});