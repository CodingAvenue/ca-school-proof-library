# Coding Aveue PHP Proof Library

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