<?php
    declare(strict_types=1);

    namespace com\femastudios\enums\tests;

    use com\femastudios\enums\Enum;
    use com\femastudios\enums\EnumLoadingException;
    use com\femastudios\enums\EnumNotFoundException;
    use PHPUnit\Framework\TestCase;

    abstract class AbstractEnumTest extends TestCase {

        protected abstract static function enumClass() : string;

        protected abstract static function wrongEnumClass() : string;

        /**
         * @return Enum[]
         */
        protected abstract static function expectedEnums() : array;

        private static function enumPairs(callable $callback) : void {
            /** @var Enum $cls */
            $cls = static::enumClass();
            $enums = $cls::getAll();

            $i = 0;
            foreach ($enums as $enum1) {
                $j = 0;
                foreach ($enums as $enum2) {
                    $callback($enum1, $enum2, $i, $j);
                    $j++;
                }
                $i++;
            }
        }

        public function testBase() : void {
            $expected = array_values(static::expectedEnums());

            /** @var Enum $cls */
            $cls = static::enumClass();
            $i = 0;
            $enums = $cls::getAll();
            foreach ($enums as $key => $enum) {
                self::assertSame($key, $enum->name());
                self::assertSame($i, $enum->ordinal());
                self::assertSame($expected[$i], $enum);
                self::assertSame($enum, $cls::fromName($enum->name()));
                self::assertSame($enum, $cls::fromOrdinal($i));
                $i++;
            }

            static::enumPairs(function (Enum $enum1, Enum $enum2, int $i, int $j) {
                if ($i === $j) {
                    self::assertSame($enum1, $enum2);
                } else {
                    self::assertNotSame($enum1, $enum2);
                }
            });
        }

        public function testCompareTo() {
            static::enumPairs(function (Enum $enum1, Enum $enum2, int $i, int $j) {
                if ($i < $j) {
                    self::assertLessThan(0, $enum1->compareTo($enum2));
                    self::assertGreaterThan(0, $enum2->compareTo($enum1));
                } elseif ($i > $j) {
                    self::assertGreaterThan(0, $enum1->compareTo($enum2));
                    self::assertLessThan(0, $enum2->compareTo($enum1));
                } else {
                    self::assertSame(0, $enum1->compareTo($enum2));
                    self::assertSame(0, $enum2->compareTo($enum1));
                }
            });
        }

        public function testEnumNotFoundMethod() : void {
            $this->expectException(EnumNotFoundException::class);
            $cls = static::enumClass();
            /** @noinspection PhpUndefinedMethodInspection */
            $cls::ENUM_THAT_DOES_NOT_EXIST();
        }

        public function testEnumWithParams() : void {
            $this->expectException(\BadMethodCallException::class);
            $cls = static::enumClass();
            /** @noinspection PhpUndefinedMethodInspection */
            $cls::ENUM(123);
        }

        public function testEnumNotFoundName() : void {
            $this->expectException(EnumNotFoundException::class);
            /** @var Enum $cls */
            $cls = static::enumClass();
            $cls::fromName('ENUM_THAT_DOES_NOT_EXIST');
        }

        public function testEnumNotFoundOrdinal() : void {
            $this->expectException(EnumNotFoundException::class);
            /** @var Enum $cls */
            $cls = static::enumClass();
            $cls::fromOrdinal(1000);
        }

        public function testWrongImpl() : void {
            $this->expectException(EnumLoadingException::class);
            /** @var Enum $cls */
            $cls = static::wrongEnumClass();
            $cls::getAll();
        }
    }