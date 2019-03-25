<?php
// FROM HASH: 1723b8152e0b526e2c556495e00e3a7a
return array('macros' => array(), 'code' => function($__templater, array $__vars)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>
	' . '' . ($__templater->fn('prefix', array('thread', $__vars['thread'], 'escaped', ), true) . $__templater->escape($__vars['thread']['title'])) . ' - New thread in watched forum' . '
</mail:subject>

' . '<p>' . $__templater->fn('username_link_email', array($__vars['post']['User'], $__vars['post']['username'], ), true) . ' posted a new thread to a forum you are watching at ' . (((('<a href="' . $__templater->fn('link', array('canonical:index', ), true)) . '">') . $__templater->escape($__vars['xf']['options']['boardTitle'])) . '</a>') . '.</p>' . '

<h2><a href="' . $__templater->fn('link', array('canonical:posts', $__vars['post'], ), true) . '">' . $__templater->fn('prefix', array('thread', $__vars['thread'], 'escaped', ), true) . $__templater->escape($__vars['thread']['title']) . '</a></h2>

';
	if ($__vars['xf']['options']['emailWatchedThreadIncludeMessage']) {
		$__finalCompiled .= '
	<div class="message">' . $__templater->fn('bb_code_type', array('emailHtml', $__vars['post']['message'], 'post', $__vars['post'], ), true) . '</div>
';
	}
	$__finalCompiled .= '

' . $__templater->callMacro('thread_forum_macros', 'go_thread_bar', array(
		'thread' => $__vars['thread'],
		'watchType' => 'forums',
	), $__vars) . '

' . $__templater->callMacro('thread_forum_macros', 'watched_forum_footer', array(
		'thread' => $__vars['thread'],
		'forum' => $__vars['forum'],
	), $__vars);
	return $__finalCompiled;
});