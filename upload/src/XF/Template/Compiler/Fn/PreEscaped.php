<?php

namespace XF\Template\Compiler\Fn;

use XF\Template\Compiler\Syntax\Fn;
use XF\Template\Compiler;

class PreEscaped extends AbstractFn
{
	public function compile(Fn $fn, Compiler $compiler, array $context)
	{
		return $fn->compileFunctionPreEscaped($compiler, $context);
	}
}