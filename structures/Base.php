<?php

namespace Structures;

abstract class Base
{
	/**
	 * @param string $name
	 * @param array $args
	 * @exceptions BadMethodCallException
	 */
	public function __call($name, $args)
	{
		throw new BadMethodCallException;
	}
	
	/**
	 * @param string $name
	 * @exceptions UnexpectedValueException
	 */
	public function __get($name)
	{
		throw new UnexpectedValueException;
	}
}