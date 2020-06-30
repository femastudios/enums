<?php
	declare(strict_types=1);

	namespace com\femastudios\enums\tests;

	use com\femastudios\enums\EnumNotFoundException;
	use PHPUnit\Framework\TestCase;

	require_once 'BasicColor.php';
	require_once 'Color.php';

	class DocEnumTest extends TestCase {

		public function testAll() : void {
			static::assertSame(Color::RED(), BasicColor::RED());
			static::assertSame(Color::RED(), Color::RED());

			static::assertNotSame(Color::RED(), Color::WHITE());

			static::assertSame(0, Color::BLACK()->ordinal());
			static::assertSame(8, Color::ORANGE()->ordinal());


			static::assertSame('YELLOW', Color::YELLOW()->name());
			static::assertSame('GREEN', BasicColor::GREEN()->name());
		}

		public function testEnumNotFound() : void {
			$this->expectException(EnumNotFoundException::class);
			/** @noinspection PhpUndefinedMethodInspection */
			Color::SHOULDNT_EXIST();
		}
	}
