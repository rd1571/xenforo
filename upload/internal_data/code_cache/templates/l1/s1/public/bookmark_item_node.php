<?php
// FROM HASH: 8b110cf57c2ef246c3a10b6e57007009
return array('macros' => array(), 'code' => function($__templater, array $__vars)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->fn('snippet', array($__vars['content']['description'], $__templater->fn('max_length', array($__vars['bookmark'], 'message', ), false), array('stripQuote' => true, ), ), true);
	return $__finalCompiled;
});