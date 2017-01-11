# Coding Aveue PHP Proof Library

## Usage

```php
use CodingAvenue\Proof\ParsedCode;
use function CodingAvenue\Proof\{ findVariable };

$c = new ParsedCode();
$tokens = $c->getStatements();

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
