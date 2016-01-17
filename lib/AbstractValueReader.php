<?php

namespace ICanBoogie\Validate;

abstract class AbstractValueReader implements ValueReader
{
	/**
	 * @var mixed
	 */
	protected $source;

	/**
	 * @param mixed $source
	 */
	public function __construct($source)
	{
		$this->source = $source;
	}

	public function read($name)
	{
		$value = $this->raw_read($name);

		if ((is_string($value) && trim($value) === '')
		|| (is_array($value) && !count($value)))
		{
			return null;
		}

		return $value;
	}

	abstract protected function raw_read($name);
}
