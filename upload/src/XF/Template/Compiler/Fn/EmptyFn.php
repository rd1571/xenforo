<?php

namespace XF\Template\Compiler\Fn;

use XF\Template\Compiler\Syntax\Fn;
use XF\Template\Compiler;

class EmptyFn extends AbstractFn
{
	public function compile(Fn $fn, Compiler $compiler, array $context)
	{
		$fn->assertArgumentCount(1);

		$context['escape'] = false;

		$value = $fn->arguments[0]->compile($compiler, $context, true);
		return "{$compiler->templaterVariable}->fn('empty', array($value))";
	}
}