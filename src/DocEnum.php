<?php
    declare(strict_types=1);

    namespace com\femastudios\enums;

    /**
     * Class that parses the inheritor's documentation and creates enums based on the static methods declared.
     *
     * @package com\femastudios\enums
     */
    abstract class DocEnum extends Enum {

        protected static final function loadAll(string $class) : array {
            try {
                $cls = new \ReflectionClass($class);
            } catch (\ReflectionException $e) {
                throw new EnumLoadingException($e->getMessage(), $e->getCode(), $e);
            }
            $constructor = $cls->getConstructor();
            $constructor->setAccessible(true);

            $doc = $cls->getDocComment();
            $enums = [];
            if ($doc !== false) {
                $matches = [];
                if (preg_match_all('/^\\s*\\*\\s*@method\\s+static\\s+(?:' . preg_quote($class, '/') . '|' . preg_quote($cls->getShortName(), '/') . ')\\s+([A-Z_0-9]+)\\(\\s*\\)\\s*$/m', $doc, $matches) > 0) {
                    foreach ($matches[1] as $name) {
                        $enum = $cls->newInstanceWithoutConstructor();
                        try {
                            $constructor->invoke($enum);
                        } catch (\Exception $e) {
                            throw new EnumLoadingException('Error instantiating enum class of name ' . $name, 0, $e);
                        }
                        $enum->name = $name;
                        $enums[] = $enum;
                    }
                }
            }
            return $enums;
        }
    }