<?php
    declare(strict_types=1);

    namespace com\femastudios\enums\tests;

    use com\femastudios\enums\EnumNotFoundException;

    require_once 'IntAlgorithm.php';

    final class MethodEnumTest extends AbstractEnumTest {

        public function testParams() : void {
            static::assertSame(3, IntAlgorithm::SUM()->invokeAlg(1, 2));
            static::assertSame(6, IntAlgorithm::DIFF()->invokeAlg(10, 4));
            static::assertSame(42, IntAlgorithm::MULT()->invokeAlg(6, 7));
            static::assertSame(3, IntAlgorithm::DIV()->invokeAlg(20, 6));
        }

        protected static function enumClass() : string {
            return IntAlgorithm::class;
        }

        protected static function expectedEnums() : array {
            return [
                IntAlgorithm::SUM(),
                IntAlgorithm::DIFF(),
                IntAlgorithm::MULT(),
                IntAlgorithm::DIV(),
            ];
        }
    }
