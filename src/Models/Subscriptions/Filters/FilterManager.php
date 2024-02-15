<?php

namespace Paytic\Payments\Models\Subscriptions\Filters;


/**
 * Class FilterManager
 * @package Paytic\Payments\Models\Subscriptions\Filters
 */
class FilterManager extends \Nip\Records\Filters\FilterManager
{

    public function init()
    {
        parent::init();

        $fields = [
            'status'
        ];
        foreach ($fields as $field) {
            $this->addFilter($this->newFilter('Column\BasicFilter')->setField($field));
        }
    }
}
