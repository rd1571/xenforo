<?php
// FROM HASH: 0dd7c63f65298b6ea0e1ded9aba58d74
return array('macros' => array(), 'code' => function($__templater, array $__vars)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Invite members to conversation');
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped('Conversations'), $__templater->fn('link', array('conversations', ), false), array(
	));
	$__finalCompiled .= '
';
	$__templater->breadcrumb($__templater->preEscaped($__templater->escape($__vars['conversation']['title'])), $__templater->fn('link', array('conversations', $__vars['conversation'], ), false), array(
	));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['conversation'], 'getRemainingRecipientsCount', array()) > 0) {
		$__compilerTemp1 .= 'You may invite up to ' . $__templater->filter($__templater->method($__vars['conversation'], 'getRemainingRecipientsCount', array()), array(array('number', array()),), true) . ' member(s).';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTokenInputRow(array(
		'name' => 'recipients',
		'href' => $__templater->fn('link', array('members/find', ), false),
	), array(
		'label' => 'Invite members',
		'explain' => '
					' . 'Separate names with a comma.' . ' ' . 'Invited members will be able to see the entire conversation from the beginning.' . '
					' . $__compilerTemp1 . '
				',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Invite',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->fn('link', array('conversations/invite', $__vars['conversation'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
});