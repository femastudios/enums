<?php
	declare(strict_types=1);

	namespace com\femastudios\enums\tests;

	use com\femastudios\enums\EnumNotFoundException;
	use PHPUnit\Framework\TestCase;

	require_once 'IntAlgorithm.php';

	class MethodEnumTest extends TestCase {

		public function testAll() : void {
			static::assertSame(IntAlgorithm::SUM(), IntAlgorithm::SUM());

			static::assertNotSame(IntAlgorithm::DIFF(), IntAlgorithm::DIV());

			static::assertSame(0, IntAlgorithm::SUM()->ordinal());
			static::assertSame(2, IntAlgorithm::MULT()->ordinal());

			static::assertSame('DIFF', IntAlgorithm::DIFF()->name());
			static::assertSame('DIV', IntAlgorithm::DIV()->name());

			static::assertSame(3, IntAlgorithm::SUM()->invokeAlg(1, 2));
			static::assertSame(6, IntAlgorithm::DIFF()->invokeAlg(10, 4));
			static::assertSame(42, IntAlgorithm::MULT()->invokeAlg(6, 7));
			static::assertSame(3, IntAlgorithm::DIV()->invokeAlg(20, 6));

		}

		public function testEnumNotFound() : void {
			$this->expectException(EnumNotFoundException::class);
			/** @noinspection PhpUndefinedMethodInspection */
			IntAlgorithm::NON_EXISTANT();
		}
	}
