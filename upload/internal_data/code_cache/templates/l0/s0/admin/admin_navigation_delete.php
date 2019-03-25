<?php
// FROM HASH: a66e91bb1cfa0e71f09563352aa99082
return array('macros' => array(), 'code' => function($__templater, array $__vars)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['hasChildren']) {
		$__compilerTemp1 .= '
				' . $__templater->formInfoRow('
					<p class="block-rowMessage block-rowMessage--warning block-rowMessage--iconic">
						<strong>' . 'Note' . $__vars['xf']['language']['label_separator'] . '</strong>
						' . 'Deleting this item will also delete any and all of its child items. If you do not want this to happen, assign any child items a new parent item before continuing with this deletion.' . '
					</p>
				', array(
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'Please confirm that you want to delete the following' . $__vars['xf']['language']['label_separator'] . '
				<strong><a href="' . $__templater->fn('link', array('admin-navigation/edit', $__vars['navigation'], ), true) . '">' . $__templater->escape($__vars['navigation']['title']) . '</a></strong>
			', array(
		'rowtype' => 'confirm',
	)) . '

			' . $__compilerTemp1 . '
		</div>

		' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>

	' . $__templater->fn('redirect_input', array(null, null, true)) . '

', array(
		'action' => $__templater->fn('link', array('admin-navigation/delete', $__vars['navigation'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
});