<?php
// FROM HASH: bab2afc03f7a942bcb292cd3ea0a85b8
return array('macros' => array('reaction_snippet' => function($__templater, array $__arguments, array $__vars)
{
	$__vars = $__templater->setupBaseParamsForMacro($__vars, false);
	$__finalCompiled = '';
	$__vars = $__templater->mergeMacroArguments(array(
		'reactionUser' => '!',
		'reactionId' => '!',
		'post' => '!',
		'date' => '!',
		'fallbackName' => 'Unknown member',
	), $__arguments, $__vars);
	$__finalCompiled .= '
	<div class="contentRow-title">
		';
	if ($__vars['post']['user_id'] == $__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
			' . '' . $__templater->fn('username_link', array($__vars['reactionUser'], false, array('defaultname' => $__vars['fallbackName'], ), ), true) . ' reacted to your post in the thread ' . ((((('<a href="' . $__templater->fn('link', array('posts', $__vars['post'], ), true)) . '">') . $__templater->fn('prefix', array('thread', $__vars['post']['Thread'], ), true)) . $__templater->escape($__vars['post']['Thread']['title'])) . '</a>') . ' with ' . $__templater->filter($__templater->fn('alert_reaction', array($__vars['reactionId'], 'medium', ), false), array(array('preescaped', array()),), true) . '.' . '
		';
	} else {
		$__finalCompiled .= '
			' . '' . $__templater->fn('username_link', array($__vars['reactionUser'], false, array('defaultname' => $__vars['fallbackName'], ), ), true) . ' reacted to <a ' . (('href="' . $__templater->fn('link', array('posts', $__vars['post'], ), true)) . '"') . '>' . $__templater->escape($__vars['post']['username']) . '\'s post</a> in the thread ' . ((((('<a href="' . $__templater->fn('link', array('posts', $__vars['post'], ), true)) . '">') . $__templater->fn('prefix', array('thread', $__vars['post']['Thread'], ), true)) . $__templater->escape($__vars['post']['Thread']['title'])) . '</a>') . ' with ' . $__templater->filter($__templater->fn('alert_reaction', array($__vars['reactionId'], 'medium', ), false), array(array('preescaped', array()),), true) . '.' . '
		';
	}
	$__finalCompiled .= '
	</div>

	<div class="contentRow-snippet">' . $__templater->fn('snippet', array($__vars['post']['message'], $__vars['xf']['options']['newsFeedMessageSnippetLength'], array('stripQuote' => true, ), ), true) . '</div>

	<div class="contentRow-minor">' . $__templater->fn('date_dynamic', array($__vars['date'], array(
	))) . '</div>
';
	return $__finalCompiled;
},), 'code' => function($__templater, array $__vars)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . $__templater->callMacro(null, 'reaction_snippet', array(
		'reactionUser' => $__vars['reaction']['ReactionUser'],
		'reactionId' => $__vars['reaction']['reaction_id'],
		'post' => $__vars['content'],
		'date' => $__vars['reaction']['reaction_date'],
	), $__vars);
	return $__finalCompiled;
});