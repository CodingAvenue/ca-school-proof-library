# Coding Avenue PHP Proof Library

## Installation

Add the following to your `composer.json` file

```
{
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/CodingAvenue/ca-school-proof-library"
        }
    ],
    "require": {
        "codingavenue/php-proof": "0.0.6"
    }
}
```

Then do `composer update`

## Usage

### Node Finder

**Input**
```
$firstName = 'Jerome';
$lastName = 'Suarez';
```

```php
use CodingAvenue\Proof\Code;

$code = new Code();
$nodes = $code->find('variable[name="firstname"]');
echo $nodes->count(); // should return 1 since variable firstName was only used once.

$nodes = $code->find('assignment[variable="lastName"]');
echo $nodes->count(); // Should return 1 since the variable lastName was assigned only once.
```

### Analyzer

```php
use CodingAvenue\Proof\Code;

$code = new Code();
$analyzer = $code->analyzer();

$output = $analyzer->codingConvention();
print_r($output)
```

**Result:**
```
Array
(
    [hasViolations] => 1
    [violations] => Array
        (
            [0] => Array
                (
                    [message] => This is message 1
                    [line] => 10
                    [column] => 4
                )

            [1] => Array
                (
                    [message] => This is message 2
                    [line] => 11
                    [column] => 2
                )

            [2] => Array
                (
                    [message] => This is message 3
                    [line] => 14
                    [column] => 7
                )

        )

)
```

```php
use CodingAvenue\Proof\Code;

$code = new Code();
$analyzer = $code->analyzer();

$output = $analyzer->messDetection();
print_r($output)
```

**Result:**
```
Array
(
    [hasViolations] => 1
    [violations] => Array
        (
            [0] => Array
                (
                    [message] => This is message 1
                    [beginLine] => 10
                    [endLine] => 10
                )

            [1] => Array
                (
                    [message] => This is message 2
                    [beginLine] => 11
                    [endLine] => 11
                )

            [2] => Array
                (
                    [message] => This is message 3
                    [beginLine] => 14
                    [endLine] => 20
                )

        )

)
```

### Evaluator

```php
use CodingAvenue\Proof\Code;

$code = new Code();
$evaluator = $code->evaluator();

$evaled = $evaluator->evaluate();
```

**Result**
```
Array
(
    [result] => return value of the evaluated code,
    [output] => output of the evaluated code,
    [error] => The error message if the evaluated code throws an error.
)
```

## Local Testing

To test your proof file locally, this package comes with a proof-runner script that you can use to do the heavy lifting.
You will need to create a configuration file `proof.json` on your project root directory. The supported settings are the following

 - **codeFilepath** - The path where the Code() class will look for your test code that will be used against your proof file.
 - **answerDir**    - The base directory where all of your test answers code are located.
 - **proofDir**     - The base directory where all of your proof files are located.

proof-runner relies on a naming convention to be able to find your test code file that will be used against a proof file.

 * Your answer file must have the same name as your
 * It must have the same path part of the proof file from the proofDir. E.g. if you have the following `proof.json` file
    ```
    {
        "codeFilePath": "./code",
        "answerDir": "answers",
        "proofDir": "tests"
    }
    ```
    Then your proof file is at `tests/chapter1/test1.php`, you should have your test answer code at `answers/chapter1/test1.php`

To run the example above you will do `./vendor/bin/proof-runner tests/chapter1/test1.php` and it will use the `answers/chapter1/test1.php` content as the code.
Behind the scene it will copy the content of `answers/chapter1/test1.php` to the value of `codeFilepath` before executing `phpunit`.
