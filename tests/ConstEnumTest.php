<?php
    declare(strict_types=1);

    namespace com\femastudios\enums\tests;

    final class ConstEnumTest extends AbstractEnumTest {

        public function testParams() : void {
            static::assertSame('Mon', Day::MONDAY()->getAbbreviation());
            static::assertSame('Sat', Day::SATURDAY()->getAbbreviation());

            static::assertTrue(Day::MONDAY()->isWorkDay());
            static::assertFalse(Day::SUNDAY()->isWorkDay());
        }

        protected static function enumClass() : string {
            return Day::class;
        }

        protected static function wrongEnumClass() : string {
            return WrongConstEnum::class;
        }

        protected static function expectedEnums() : array {
            return [
                Day::MONDAY(),
                Day::TUESDAY(),
                Day::WEDNESDAY(),
                Day::THURSDAY(),
                Day::FRIDAY(),
                Day::SATURDAY(),
                Day::SUNDAY(),
            ];
        }
    }
