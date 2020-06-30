<?php
	declare(strict_types=1);

	namespace com\femastudios\enums;

    /**
     * Class that checks its declared private constants starting with <code>ENUM_</code> to create its enums.
     * Each of this constants must be an array containing the arguments to pass to the enum constructor.
     *
     * @package com\femastudios\enums
     */
	abstract class ConstEnum extends Enum {

		private const PREFIX = 'ENUM_';

		protected static function loadAll(string $class, int $startOrdinal) : array {
			try {
				$cls = new \ReflectionClass($class);
			} catch (\ReflectionException $e) {
				throw new EnumLoadingException($e->getMessage(), $e->getCode(), $e);
			}

			$constructor = $cls->getConstructor();
			$constructor->setAccessible(true);

			$ret = [];
			foreach ($cls->getReflectionConstants() as $constant) {
				if ($constant->isPrivate()) {
					$name = $constant->getName();
					if (mb_strpos($name, self::PREFIX) === 0) {
						$name = mb_substr($name, mb_strlen(self::PREFIX));
						$value = $constant->getValue();
						if (!is_array($value)) {
							throw new EnumLoadingException('The value of each constant must be an array of parameters to call the constructor with, found ' . gettype($value));
						}
						$enum = $cls->newInstanceWithoutConstructor();
						try {
							$constructor->invokeArgs($enum, $value);
						} catch (\Exception $e) {
							throw new EnumLoadingException('Error instantiating enum class of name ' . $name, 0, $e);
						}
						$enum->name = $name;
						$enum->ordinal = $startOrdinal++;
						$ret[] = $enum;
					}
				}
			}
			return $ret;
		}

	}