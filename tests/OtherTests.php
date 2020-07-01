<?php
    declare(strict_types=1);

    namespace com\femastudios\enums\tests;

    use PHPUnit\Framework\TestCase;

    final class OtherTests extends TestCase {

        public function testInvalidCompare() {
            $this->expectException(\DomainException::class);
            Day::MONDAY()->compareTo(IntAlgorithm::SUM());
        }


    }