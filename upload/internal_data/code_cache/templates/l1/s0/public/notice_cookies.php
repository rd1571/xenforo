<?php
// FROM HASH: 5de8134d4d577e8684330952749b86ea
return array('macros' => array(), 'code' => function($__templater, array $__vars)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="u-alignCenter">
	' . 'This site uses cookies to help personalise content, tailor your experience and to keep you logged in if you register.<br />
By continuing to use this site, you are consenting to our use of cookies.' . '
</div>

<div class="u-inputSpacer u-alignCenter">
	' . $__templater->button('Accept', array(
		'icon' => 'confirm',
		'href' => $__templater->fn('link', array('account/dismiss-notice', null, array('notice_id' => $__vars['notice']['notice_id'], ), ), false),
		'class' => 'js-noticeDismiss button--notice',
		'data-xf-init' => 'tooltip',
		'title' => 'Dismiss notice',
	), '', array(
	)) . '
	' . $__templater->button('Learn more' . $__vars['xf']['language']['ellipsis'], array(
		'href' => $__templater->fn('link', array('help/cookies', ), false),
		'class' => 'button--notice',
	), '', array(
	)) . '
</div>';
	return $__finalCompiled;
});