<?php
    declare(strict_types=1);

    namespace com\femastudios\enums;

    /**
     * Abstract common class to all enums.
     *
     * @package com\femastudios\enums
     */
    abstract class Enum {

        /** @var Enum[][] storage for already loaded enums. Key is the enum class, value is a map of enum name => Enum instance */
        private static $enums = [];

        /** @var string The name of this enum */
        protected $name;
        /** @var int the ordinal of this enums */
        protected $ordinal;

        protected function __construct() {
        }

        /**
         * @return string the name of the enum
         */
        public final function name() : string {
            return $this->name;
        }

        /**
         * @return int a number representing this enum. Starts at 0.
         */
        public final function ordinal() : int {
            return $this->ordinal;
        }

        /**
         * The default __toString() implementation returns the enum name
         * @return string the name of the enum
         */
        public function __toString() : string {
            return $this->name;
        }

        /**
         * Compares this enum to another one by using their ordinals
         * @param Enum $other an enum object of the same class as this one
         * @return int this ordinal <=> other ordinal
         * @throws \DomainException if the given enum is of a different type
         */
        public function compareTo(Enum $other) : int {
            if (get_class($this) !== get_class($other)) {
                throw new \DomainException('Expected enum of type ' . get_class($this) . ', ' . get_class($other) . ' given!');
            } else {
                return $this->ordinal <=> $other->ordinal;
            }
        }

        /**
         * @return Enum[] associative array of {@link Enum} instances, where the key is the enum name
         */
        public static final function getAll() : array {
            $className = static::class;
            if (!isset(self::$enums[$className])) {
                try {
                    $cls = new \ReflectionClass($className);
                } catch (\ReflectionException $e) {
                    throw new EnumLoadingException($e->getMessage(), $e->getCode(), $e);
                }
                if (!$cls->isFinal()) {
                    throw new EnumLoadingException("Enum class $className must be final");
                } elseif ($cls->getConstructor()->getDeclaringClass()->getName() !== Enum::class && !$cls->getConstructor()->isPrivate()) {
                    throw new EnumLoadingException("Enum class $className constructor must be private");
                }
                $enums = [];
                $loaded = static::loadAll($className);
                if($loaded === []) {
                    throw new EnumLoadingException("An enum must have at least one item, none returned for class $className");
                }
                $ordinal = 0;
                foreach ($loaded as $enum) {
                    if ($enum->name === null || $enum->name === '') {
                        throw new EnumLoadingException("A $className enum name is not initialized or empty");
                    } elseif (isset($enums[$enum->name])) {
                        throw new EnumLoadingException("$className enum name conflict with name: " . $enum->name);
                    }
                    $enums[$enum->name] = $enum;
                    $enum->ordinal = $ordinal++;
                }
                self::$enums[$className] = $enums;
            }
            return self::$enums[$className];
        }

        /**
         * Loads the enums for the given class. Make sure to initialize the $name property.
         * The $ordinal property will be automatically initialized based on the order of the returned array.
         * @param string $class the fully-qualified class name
         * @return Enum[] the enums
         * @throws EnumLoadingException if something goes wrong while loading enums
         */
        protected abstract static function loadAll(string $class) : array;


        /**
         * Return a specific enum given its name
         * @param string $name the name of the enum
         * @return Enum the enum that corresponds to the passed name
         * @throws EnumNotFoundException if an enum with the passed name is not found
         */
        public static final function fromName(string $name) : Enum {
            $all = static::getAll();
            if (isset($all[$name])) {
                return $all[$name];
            } else {
                throw new EnumNotFoundException('The enum ' . static::class . " with name '$name' wasn't found!");
            }
        }

        /**
         * Return a specific enum given its ordinal
         * @param int $ordinal the ordinal of the enum
         * @return Enum the enum that corresponds to the passed ordinal
         * @throws EnumNotFoundException if an enum with the passed ordinal is not found
         */
        public static final function fromOrdinal(int $ordinal) : Enum {
            foreach (static::getAll() as $item) {
                if ($item->ordinal() === $ordinal) {
                    return $item;
                }
            }
            throw new EnumNotFoundException('The enum ' . static::class . " with ordinal '$ordinal' wasn't found!");
        }

        public static final function __callStatic(string $name, array $arguments) {
            if (count($arguments) !== 0) {
                throw new \BadMethodCallException("Cannot pass arguments when requesting an enum!");
            }
            return static::fromName($name);
        }
    }