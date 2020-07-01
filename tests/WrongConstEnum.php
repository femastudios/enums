<?php /** @noinspection PhpUnusedPrivateFieldInspection */
    declare(strict_types=1);

    namespace com\femastudios\enums\tests;


    use com\femastudios\enums\ConstEnum;

    final class WrongConstEnum extends ConstEnum {
        private const ENUM_HELLO = 123;
    }