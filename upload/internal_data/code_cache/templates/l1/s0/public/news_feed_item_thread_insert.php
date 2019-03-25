<?php
// FROM HASH: ce437ba5fd383428c7bdd1f101a871e8
return array('macros' => array(), 'code' => function($__templater, array $__vars)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="contentRow-title">
	' . '' . $__templater->fn('username_link', array($__vars['user'], false, array('defaultname' => $__vars['newsFeed']['username'], ), ), true) . ' posted the thread ' . ((((('<a href="' . $__templater->fn('link', array('threads', $__vars['content'], ), true)) . '">') . $__templater->fn('prefix', array('thread', $__vars['content'], ), true)) . $__templater->escape($__vars['content']['title'])) . '</a>') . ' in ' . (((('<a href="' . $__templater->fn('link', array('forums', $__vars['content']['Forum'], ), true)) . '">') . $__templater->escape($__vars['content']['Forum']['title'])) . '</a>') . '.' . '
</div>

<div class="contentRow-snippet">' . $__templater->fn('snippet', array($__vars['content']['FirstPost']['message'], $__vars['xf']['options']['newsFeedMessageSnippetLength'], array('stripQuote' => true, ), ), true) . '</div>
';
	if ($__vars['content']['FirstPost']['attach_count']) {
		$__finalCompiled .= '
	' . $__templater->callMacro('news_feed_attached_images', 'attached_images', array(
			'attachments' => $__vars['content']['FirstPost']['Attachments'],
			'link' => $__templater->fn('link', array('threads', $__vars['content'], ), false),
		), $__vars) . '
';
	}
	$__finalCompiled .= '

<div class="contentRow-minor">' . $__templater->fn('date_dynamic', array($__vars['newsFeed']['event_date'], array(
	))) . '</div>';
	return $__finalCompiled;
});