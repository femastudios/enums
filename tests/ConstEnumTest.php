<?php
	declare(strict_types=1);

	namespace com\femastudios\enums\tests;

	use com\femastudios\enums\EnumNotFoundException;
	use PHPUnit\Framework\TestCase;

	require_once 'Day.php';

	class ConstEnumTest extends TestCase {

		public function testAll() : void {
			static::assertSame(Day::MONDAY(), Day::MONDAY());

			static::assertNotSame(Day::TUESDAY(), Day::SUNDAY());

			static::assertSame(0, Day::MONDAY()->ordinal());
			static::assertSame(5, Day::SATURDAY()->ordinal());

			static::assertSame('MONDAY', Day::MONDAY()->name());
			static::assertSame('SATURDAY', Day::SATURDAY()->name());

			static::assertSame('Mon', Day::MONDAY()->getAbbreviation());
			static::assertSame('Sat', Day::SATURDAY()->getAbbreviation());

			static::assertTrue(Day::MONDAY()->isWorkDay());
			static::assertFalse(Day::SUNDAY()->isWorkDay());

		}

		public function testEnumNotFound() : void {
			$this->expectException(EnumNotFoundException::class);
			/** @noinspection PhpUndefinedMethodInspection */
			Day::LAZYDAY();
		}
	}
