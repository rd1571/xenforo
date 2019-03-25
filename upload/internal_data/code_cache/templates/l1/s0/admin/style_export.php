<?php
// FROM HASH: 71a60e280668bc350c92298d98da9da8
return array('macros' => array(), 'code' => function($__templater, array $__vars)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Export style' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['style']['title']));
	$__finalCompiled .= '

';
	$__vars['styleRepo'] = $__templater->method($__vars['xf']['app']['em'], 'getRepository', array('XF:AddOn', ));
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'All' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	$__compilerTemp2 = $__templater->method($__templater->method($__vars['styleRepo'], 'findAddOnsForList', array()), 'fetch', array());
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['addOn']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['addOn']['addon_id'],
				'label' => $__templater->escape($__vars['addOn']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow($__templater->escape($__vars['style']['title']), array(
		'label' => 'Style',
	)) . '

			' . $__templater->formSelectRow(array(
		'name' => 'addon_id',
	), $__compilerTemp1, array(
		'label' => 'Export from add-on',
	)) . '

			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'independent',
		'label' => 'Export as independent style',
		'hint' => 'If selected, any customizations in parent styles will be included as if they were made in this style.',
		'_type' => 'option',
	)), array(
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'export',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->fn('link', array('styles/export', $__vars['style'], ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
});