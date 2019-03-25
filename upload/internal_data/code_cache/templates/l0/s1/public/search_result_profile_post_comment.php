<?php
// FROM HASH: db1e99d9da170914524aff0b216f15cc
return array('macros' => array(), 'code' => function($__templater, array $__vars)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<li class="block-row block-row--separated ' . ($__templater->method($__vars['comment'], 'isIgnored', array()) ? 'is-ignored' : '') . '" data-author="' . ($__templater->escape($__vars['comment']['User']['username']) ?: $__templater->escape($__vars['comment']['username'])) . '">
	<div class="contentRow ' . ((!$__templater->method($__vars['comment'], 'isVisible', array())) ? 'is-deleted' : '') . '">
		<span class="contentRow-figure">
			' . $__templater->fn('avatar', array($__vars['comment']['User'], 's', false, array(
		'defaultname' => $__vars['comment']['username'],
	))) . '
		</span>
		<div class="contentRow-main">
			<h3 class="contentRow-title">
				<a href="' . $__templater->fn('link', array('profile-posts/comments', $__vars['comment'], ), true) . '">' . $__templater->fn('snippet', array($__vars['comment']['message'], 100, array('term' => $__vars['options']['term'], 'stripQuote' => true, 'fromStart' => true, ), ), true) . '</a>
			</h3>

			<div class="contentRow-snippet">' . $__templater->fn('snippet', array($__vars['comment']['message'], 300, array('term' => $__vars['options']['term'], 'stripQuote' => true, ), ), true) . '</div>

			<div class="contentRow-minor contentRow-minor--hideLinks">
				<ul class="listInline listInline--bullet">
					<li>' . $__templater->fn('username_link', array($__vars['comment']['User'], false, array(
		'defaultname' => $__vars['comment']['username'],
	))) . '</li>
					<li>' . 'Profile post comment' . '</li>
					<li>' . $__templater->fn('date_dynamic', array($__vars['comment']['comment_date'], array(
	))) . '</li>
				</ul>
			</div>
		</div>
	</div>
</li>';
	return $__finalCompiled;
});