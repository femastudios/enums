<?php
	declare(strict_types=1);

	namespace com\femastudios\enums\tests;

	use com\femastudios\enums\ConstEnum;
    use com\femastudios\enums\EnumNotFoundException;
	use PHPUnit\Framework\TestCase;

	require_once 'Day.php';

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
