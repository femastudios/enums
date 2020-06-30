<?php
	declare(strict_types=1);

	namespace com\femastudios\enums\tests;

	use com\femastudios\enums\EnumNotFoundException;
	use PHPUnit\Framework\TestCase;

	class DocEnumTest extends TestCase {

		public function testAll() : void {
			static::assertSame(Color::BLACK(), Color::BLACK());

			static::assertNotSame(Color::RED(), Color::WHITE());

			static::assertSame(0, Color::BLACK()->ordinal());
			static::assertSame(2, Color::RED()->ordinal());


			static::assertSame('RED', Color::RED()->name());
			static::assertSame('GREEN', Color::GREEN()->name());

			static::assertSame(Color::GREEN(), Color::fromName('GREEN'));
			static::assertSame(Color::GREEN(), Color::fromOrdinal(3));
		}

		public function testEnumNotFound() : void {
			$this->expectException(EnumNotFoundException::class);
			/** @noinspection PhpUndefinedMethodInspection */
			Color::LIME();
		}
	}
