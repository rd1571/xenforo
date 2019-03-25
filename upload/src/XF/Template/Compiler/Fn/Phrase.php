<?php

namespace XF\Template\Compiler\Fn;

use XF\Template\Compiler\Syntax\Fn;
use XF\Template\Compiler;

class Phrase extends AbstractFn
{
	protected static $modifierMap = [
		':' => 'label_separator',
		',' => 'comma_separator',
		'...' => 'ellipsis',
		'(' => 'parenthesis_open',
		')' => 'parenthesis_close'
	];

	public function compile(Fn $fn, Compiler $compiler, array $context)
	{
		$fn->assertArgumentCount(1, 2);

		$name = $fn->arguments[0];
		if (!($name instanceof Compiler\Syntax\Str))
		{
			throw $fn->exception(\XF::phrase('phrase_name_must_be_literal'));
		}
		$phraseName = $name->content;
		if (!strlen($phraseName))
		{
			throw $fn->exception(\XF::phrase('phrase_name_must_be_literal'));
		}
		$originalPhraseName = $phraseName;

		$paramMap = [];
		$params = isset($fn->arguments[1]) ? $fn->arguments[1] : null;
		if ($params)
		{
			if (!($params instanceof Compiler\Syntax\Hash))
			{
				throw $fn->exception(\XF::phrase('phrase_parameters_must_be_provided_with_literal_names_inside_hash'));
			}

			foreach ($params->parts AS $part)
			{
				$paramName = $part[0];

				/** @var Compiler\Syntax\AbstractSyntax $paramValue */
				$paramValue = $part[1];

				if (!($paramName instanceof Compiler\Syntax\Str))
				{
					throw $fn->exception(\XF::phrase('phrase_parameters_must_be_provided_with_literal_names_inside_hash'));
				}

				$compiledValue = $paramValue->compile($compiler, $context, true);
				if (!$paramValue->isSimpleValue())
				{
					$compiledValue = "($compiledValue)";
				}

				$paramMap[$paramName->content] = $compiledValue;
			}
		}

		$language = $compiler->getLanguage();
		if (!$language)
		{
			return $compiler->getStringCode($originalPhraseName);
		}

		// Note that there is very similar code in \XF\Language. It should correspond.
		$prefixes = [];
		$suffixes = [];
		$languageVarReference = $compiler->variableContainer . "['xf']['language']";

		if ($phraseName[0] == '(')
		{
			$prefixes[] = $languageVarReference . "['parenthesis_open']";
			$phraseName = substr($phraseName, 1);
		}

		do
		{
			$matchedSuffix = false;

			if (substr($phraseName, -3) == '...')
			{
				$suffixes[] = $languageVarReference . "['ellipsis']";
				$phraseName = substr($phraseName, 0, -3);
				$matchedSuffix = true;
			}
			else
			{
				$lastChar = substr($phraseName, -1);
				switch ($lastChar)
				{
					case ':':
					case ',':
					case ')':
					case '(':
						if (isset(self::$modifierMap[$lastChar]))
						{
							$suffixes[] = $languageVarReference . "['" . self::$modifierMap[$lastChar] . "']";
						}
						$matchedSuffix = true;
						$phraseName = substr($phraseName, 0, -1);
						break;
				}
			}
		}
		while ($matchedSuffix);

		$text = $language->getPhraseText($phraseName);
		if ($text === false)
		{
			return $compiler->getStringCode($originalPhraseName);
		}

		$text = addcslashes($text, "\\'");
		$text = preg_replace_callback('/\{([a-z0-9_-]+)\}/i', function($match) use ($paramMap)
		{
			$paramName = $match[1];

			if (!isset($paramMap[$paramName]))
			{
				return $match[0];
			}

			$code = (string)$paramMap[$paramName];
			if ($code === '')
			{
				return '';
			}

			return "' . $code . '";
		}, $text);

		$code = "'$text'";
		if ($prefixes)
		{
			$code = implode(' . ', $prefixes) . ' . ' . $code;
		}
		if ($suffixes)
		{
			// we process these right to left so invert them
			$suffixes = array_reverse($suffixes);
			$code .= ' . ' . implode(' . ', $suffixes);
		}

		return $compiler->simplifyInlineCode($code);
	}
}