<?php
    declare(strict_types=1);

    namespace com\femastudios\enums\tests;

    final class DocEnumTest extends AbstractEnumTest {

        protected static function enumClass() : string {
            return Color::class;
        }

        protected static function wrongEnumClass() : string {
            return WrongDocEnum::class;
        }

        protected static function expectedEnums() : array {
            return [
                Color::BLACK(),
                Color::WHITE(),
                Color::RED(),
                Color::GREEN(),
                Color::BLUE(),
            ];
        }
    }
