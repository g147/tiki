<?php

namespace WikiSuite\ILP;

trait PointerTrait
{
    public function resolvePointer(string $pointer, bool $ssl = true): string
    {
        return substr($pointer, 0, 1) == '$' ? ($ssl ? 'https' : 'http').'://'.substr($pointer, 1) : $pointer;
    }
}