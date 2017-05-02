<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule;

class RuleFactory
{
    public static function createRule(string $name, array $parts = array(), array $filters, bool $traverse)
    {
        $ruleClass = implode("", array_map("ucfirst", explode("-", $name)));

        $fullClasses = array();;
        if (count($parts) >= 1) {
            foreach ($parts as $part) {
                $fullClasses[] = __NAMESPACE__ . "\\$part\\" . $ruleClass;
                $fullClasses[] = __NAMESPACE__ . "\\$part\\" . "{$ruleClass}_";      
            }
        }
        else {
            $fullClasses[] = __NAMESPACE__ . "\\$ruleClass";
            $fullClasses[] = __NAMESPACE__ . "\\" . "{$ruleClass}_";
        }

        $classes = array_values(
            array_filter($fullClasses, function($val) {
                return class_exists($val);
            })
        );

        if (count($classes) > 1) {
            throw new \Exception("To many Rule Class to match the name., cannot determine which one to use");
        }
        elseif (count($classes) == 0) {
            throw new \Exception("Unknown rule {$name}");
        }

        return new $classes[0]($filters, $traverse);
    }
}
