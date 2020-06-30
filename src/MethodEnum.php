<?php
	declare(strict_types=1);

	namespace com\femastudios\enums;

    /**
     * Class that checks its declared private static functions starting with <code>ENUM_</code> to create its enums.
     * Each of these functions must return a different enum instance.
     *
     * @package com\femastudios\enums
     */
	abstract class MethodEnum extends Enum {

		private const PREFIX = 'ENUM_';

		protected static function loadAll(string $class, int $startOrdinal) : array {
			try {
				$cls = new \ReflectionClass($class);
			} catch (\ReflectionException $e) {
				throw new EnumLoadingException($e->getMessage(), $e->getCode(), $e);
			}

			$ret = [];
			foreach ($cls->getMethods() as $method) {
				if ($method->isStatic() && $method->isPrivate()) {
					$name = $method->getName();
					if (mb_strpos($name, self::PREFIX) === 0) {
						$name = mb_substr($name, mb_strlen(self::PREFIX));
						$method->setAccessible(true);
						$enum = $method->invoke(null);
						if (!($enum instanceof $class)) {
							throw new EnumLoadingException("The value returned by the method $class::$name must be a $class, " . (is_object($enum) ? get_class($enum) : gettype($enum)) . ' returned');
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