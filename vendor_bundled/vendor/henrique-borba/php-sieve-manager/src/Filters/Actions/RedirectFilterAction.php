<?php

namespace PhpSieveManager\Filters\Actions;

use PhpSieveManager\Exceptions\FilterActionParamException;

class RedirectFilterAction implements FilterAction
{
    private $params;

    /**
     * @param array $params
     * @throws FilterActionParamException
     */
    public function __construct(array $params = []) {
        if (count($params) != 1) {
            throw new FilterActionParamException("RedirectFilterAction expect one parameter");
        }
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function parse() {
        return 'redirect "'.$this->params[0].'";';
    }
}