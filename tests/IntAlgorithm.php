<?php /** @noinspection PhpUnusedPrivateMethodInspection */
	/** @noinspection PhpMethodNamingConventionInspection */
	declare(strict_types=1);

	namespace com\femastudios\enums\tests;

	use com\femastudios\enums\MethodEnum;

	/**
	 * @method static IntAlgorithm SUM()
	 * @method static IntAlgorithm DIFF()
	 * @method static IntAlgorithm MULT()
	 * @method static IntAlgorithm DIV()
	 */
	final class IntAlgorithm extends MethodEnum {

		private $alg;

		private function __construct(callable $alg) {
			$this->alg = $alg;
		}

		public function getAlg() : callable {
			return $this->alg;
		}

		public function invokeAlg(int $a, int $b) : int {
			return ($this->alg)($a, $b);
		}

		private static function ENUM_SUM() : IntAlgorithm {
			return new IntAlgorithm(function (int $a, int $b) {
				return $a + $b;
			});
		}

		private static function ENUM_DIFF() : IntAlgorithm {
			return new IntAlgorithm(function (int $a, int $b) {
				return $a - $b;
			});
		}

		private static function ENUM_MULT() : IntAlgorithm {
			return new IntAlgorithm(function (int $a, int $b) {
				return $a * $b;
			});
		}

		private static function ENUM_DIV() : IntAlgorithm {
			return new IntAlgorithm(function (int $a, int $b) {
				return intdiv($a, $b);
			});
		}
	}