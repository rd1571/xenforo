<?php

namespace XF\Template\Compiler\Fn;

use XF\Template\Compiler\Syntax\Fn;
use XF\Template\Compiler;

class IncludeFn extends AbstractFn
{
	public function compile(Fn $fn, Compiler $compiler, array $context)
	{
		$fn->assertArgumentCount(1);

		$context['escape'] = false;
		$template = $fn->arguments[0]->compile($compiler, $context, true);
		$varContainer = $compiler->variableContainer;

		return "{$compiler->templaterVariable}->includeTemplate({$template}, {$varContainer})";
	}
}