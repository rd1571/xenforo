<?php

namespace XF\Template\Compiler\Fn;

use XF\Template\Compiler\Syntax\Fn;
use XF\Template\Compiler;

abstract class AbstractFn
{
	public $name;

	public function __construct($name)
	{
		$this->name = $name;
	}

	abstract public function compile(Fn $fn, Compiler $compiler, array $context);

	public function reset()
	{

	}
}