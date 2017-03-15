# Coding Aveue PHP Proof Library

## Usage

### findVariable

```php
use CodingAvenue\Proof\Code;
use function CodingAvenue\Proof\{ findVariable };

$code = new Code();
$tokens = $code->getStatements();

$vars = findVariable($tokens, 'name');
print_r($vars);
```

**Result:**
```
Array
(
    [0] => Array
        (
            [variable] => name
            [value] => Jesse
        )

)

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
    [isCompliant] => 0
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
    [messDetected] => 1
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
