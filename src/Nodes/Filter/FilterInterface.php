<?php

namespace CodingAvenue\Proof\Nodes\Filter;

interface FilterInterface
{
    public function applyFilter(array $nodes): array;
}
