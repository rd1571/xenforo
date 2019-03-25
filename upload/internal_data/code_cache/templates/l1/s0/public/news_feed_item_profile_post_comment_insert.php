<?php
// FROM HASH: a29cd4f58ad4c8a497f558f9bef292f2
return array('macros' => array(), 'code' => function($__templater, array $__vars)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="contentRow-title">
	' . '' . $__templater->fn('username_link', array($__vars['user'], false, array('defaultname' => $__vars['newsFeed']['username'], ), ), true) . ' commented on ' . (((('<a href="' . $__templater->fn('link', array('profile-posts/comments', $__vars['content'], ), true)) . '">') . $__templater->escape($__vars['content']['ProfilePost']['username'])) . '</a>') . '\'s profile post.' . '
</div>

<div class="contentRow-snippet">' . $__templater->fn('snippet', array($__vars['content']['message'], $__vars['xf']['options']['newsFeedMessageSnippetLength'], array('stripQuote' => true, ), ), true) . '</div>

<div class="contentRow-minor">' . $__templater->fn('date_dynamic', array($__vars['newsFeed']['event_date'], array(
	))) . '</div>';
	return $__finalCompiled;
});