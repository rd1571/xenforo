<?php

namespace XF\Template\Compiler\Fn;

use XF\Template\Compiler\Syntax\Fn;
use XF\Template\Compiler;

class Vars extends AbstractFn
{
	public function compile(Fn $fn, Compiler $compiler, array $context)
	{
		return $compiler->variableContainer;
	}
}