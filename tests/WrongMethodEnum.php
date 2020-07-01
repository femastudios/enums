<?php
    declare(strict_types=1);

    namespace com\femastudios\enums\tests;


    use com\femastudios\enums\MethodEnum;

    final class WrongMethodEnum extends MethodEnum {
        /**
         * @noinspection PhpUnusedPrivateMethodInspection
         * @noinspection PhpMethodNamingConventionInspection
         */
        private static function ENUM_HELLO() {
            return [];
        }
    }