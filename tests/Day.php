<?php /** @noinspection PhpUnusedPrivateFieldInspection */
	declare(strict_types=1);

	namespace com\femastudios\enums\tests;

	use com\femastudios\enums\ConstEnum;

    /**
	 *
	 * @method static Day MONDAY()
	 * @method static Day TUESDAY()
	 * @method static Day WEDNESDAY()
	 * @method static Day THURSDAY()
	 * @method static Day FRIDAY()
	 * @method static Day SATURDAY()
	 * @method static Day SUNDAY()
	 */
    final class Day extends ConstEnum {

		private const ENUM_MONDAY = ['Mon', true];
		private const ENUM_TUESDAY = ['Tue', true];
		private const ENUM_WEDNESDAY = ['Wen', true];
		private const ENUM_THURSDAY = ['Thu', true];
		private const ENUM_FRIDAY = ['Fri', true];
		private const ENUM_SATURDAY = ['Sat', false];
		private const ENUM_SUNDAY = ['Sun', false];

		private $abbreviation, $isWorkDay;

		private function __construct(string $abbreviation, bool $isWorkDay) {
			$this->abbreviation = $abbreviation;
			$this->isWorkDay = $isWorkDay;
		}

		public function getAbbreviation() : string {
			return $this->abbreviation;
		}

		public function isWorkDay() : bool {
			return $this->isWorkDay;
		}
	}