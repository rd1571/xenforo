<?php
// FROM HASH: 9f5c8070856932cdbcddea9cfba74f02
return array('macros' => array(), 'code' => function($__templater, array $__vars)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['route'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add route');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit route' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['route']['unique_name']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['route'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->fn('link', array('routes/delete', $__vars['route'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'value' => '',
		'label' => '&nbsp;',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['routeTypes'])) {
		foreach ($__vars['routeTypes'] AS $__vars['routeTypeId'] => $__vars['routeType']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['routeTypeId'],
				'label' => $__templater->escape($__vars['routeType']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body">
			' . $__templater->formSelectRow(array(
		'name' => 'route_type',
		'value' => $__vars['route']['route_type'],
	), $__compilerTemp1, array(
		'label' => 'Route type',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'route_prefix',
		'value' => $__vars['route']['route_prefix'],
		'maxlength' => $__templater->fn('max_length', array($__vars['route'], 'route_prefix', ), false),
		'dir' => 'ltr',
	), array(
		'label' => 'Route prefix',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'sub_name',
		'value' => $__vars['route']['sub_name'],
		'maxlength' => $__templater->fn('max_length', array($__vars['route'], 'sub_name', ), false),
		'dir' => 'ltr',
	), array(
		'label' => 'Sub-name',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'format',
		'value' => $__vars['route']['format'],
		'maxlength' => $__templater->fn('max_length', array($__vars['route'], 'format', ), false),
		'dir' => 'ltr',
	), array(
		'label' => 'Route format',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'context',
		'value' => $__vars['route']['context'],
		'maxlength' => $__templater->fn('max_length', array($__vars['route'], 'context', ), false),
		'dir' => 'ltr',
	), array(
		'label' => 'Section context',
	)) . '

			' . $__templater->callMacro('helper_callback_fields', 'callback_row', array(
		'label' => 'Link building callback',
		'namePrefix' => 'build',
		'data' => $__vars['route'],
	), $__vars) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'controller',
		'value' => $__vars['route']['controller'],
		'maxlength' => $__templater->fn('max_length', array($__vars['route'], 'controller', ), false),
		'dir' => 'ltr',
	), array(
		'label' => 'Controller',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'action_prefix',
		'value' => $__vars['route']['action_prefix'],
		'maxlength' => $__templater->fn('max_length', array($__vars['route'], 'action_prefix', ), false),
		'dir' => 'ltr',
	), array(
		'label' => 'Action prefix',
	)) . '

			' . $__templater->callMacro('addon_macros', 'addon_edit', array(
		'addOnId' => $__vars['route']['addon_id'],
	), $__vars) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>

', array(
		'action' => $__templater->fn('link', array('routes/save', $__vars['route'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
});