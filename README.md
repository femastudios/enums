# enums
A highly flexible and customizable enum library for PHP.

It provides a Java-flavored enumeration in PHP. 

## Installation
Available as composer package `femastudios/enums`. PHP 7.3 or greater required.

## Introduction

### Basic usage
```php
/**
 * @method static Greeting HELLO()
 * @method static Greeting GOOD_MORNING()
 * @method static Greeting GOOD_EVENING()
 */
final class Greeting extends \com\femastudios\enums\DocEnum {}

Greeting::HELLO(); // Will return a Greeting instance
```

Remember that enums are **single-instance**, so `Greeting::HELLO() === Greeting::HELLO()` will always be true.

### Main classes
* `Enum`: base class for enums. You should extend it only if you want to provide you own implementation of enums.
* `DocEnum`: Easiest way to declare enum through documentation, no parameters to constructor.
* `ConstEnum`: More flexible way of declaring enum through private consts that allows to pass constant values to the constructor.
* `MethodEnum`: Leaves to the user the task to instantiate the enum, removing the const limit of the above implementation.
* `EnumNotFoundException`: exception thrown when you request an enum that does not exist.
* `EnumLoadingException`: exception thrown when there is a problem with enum instantiation.


### Available methods on enums
* `name()`: will return the name of the enum
* `ordinal()`: will return an `int` starting from zero, representing the position of the enum
* `::getAll()`: will return an `array` of `Enum`, containing all the declared enums
* `::fromName(string $name)`: will return the `Enum` with the given name, or throw a `EnumNotFoundException`
* `::fromOrdinal(int $ordinal)`: will return the `Enum` with the given ordinal, or throw a `EnumNotFoundException`

## Declaring enums
There are multiple ways to declare enums, depending on the level of flexibility required. 

Note that your enum classes must always be `final` and their constructor, if present, must be private.

### DocEnum
```php
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
final class Day extends \com\femastudios\enums\DocEnum {}
```
This is all you have to do in order to declare your enum. The documentation will be automatically parsed and your enums instantiated accordingly.

This is the only implementation that parses the documentation. In all the other examples, this doc is present only to help the IDE, but it can safely be omitted.

### ConstEnum
While the previous method is very easy, it doesn't provide a lot of flexibility. Let's say we want to add some parameters to our enum. We can do so like this:
```php
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
final class Day extends \com\femastudios\enums\ConstEnum {
    
    private const ENUM_MONDAY = ['Mon', true];
    private const ENUM_TUESDAY = ['Tue', true];
    private const ENUM_WEDNESDAY = ['Wen', true];
    private const ENUM_THURSDAY = ['Thu', true];
    private const ENUM_FRIDAY = ['Fri', true];
    private const ENUM_SATURDAY = ['Sat', false];
    private const ENUM_SUNDAY = ['Sun', false];
    
    private $abbreviation, $isWorkDay;
    
    private function __construct(string $abbreviation, bool $isWorkDay) {
        parent::__construct();
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
```
As you can see from the code, it's very easy to pass parameters to the constructor of your enum. In this particular implementation though, you can only pass constant parameters. 

To be considered, each const must be `private` and start with `ENUM_`: its value must be an array containing the parameters to pass to the constructor.

### MethodEnum
Lastly, this implementation allows full control of the creation of your enums.
```php
/**
 * @method static IntAlgorithm SUM()
 * @method static IntAlgorithm DIFF()
 * @method static IntAlgorithm MULT()
 * @method static IntAlgorithm DIV()
 */
final class IntAlgorithm extends \com\femastudios\enums\MethodEnum {

    private $alg;

    private function __construct(callable $alg) {
        parent::__construct();
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
```

As you can see, the task of instantiating the enum is completely handed off to the programmer, thus allowing any kind of complex logic.

Similarly to the const implementation, the methods to be considered must be `private`, `static` and start with `ENUM_`. 

### Your own enum implementation
If you want to implement a custom logic for your enum creation, all you have to do is extend the `Enum` class and provide a `loadAll(string $class)` method that returns an array of your enums. 
Make sure to initialize the `name` attribute on your instances and to avoid name collisions!
The `ordinal` attribute will be initialized automatically based on the order of the returned array.

Also, keep in mind that the created enums will be kept in a static cache, so the method will only be called once per enum class.