<?php

namespace Paytic\Payments\Models\Currencies\Traits;

/**
 * Trait CurrencyTrait
 * @package Paytic\Payments\Models\Currencies\Traits
 *
 * @property string $code
 * @property string $symbol
 * @property string $position
 */
trait CurrencyTrait
{
    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param $amount
     * @return string
     */
    public function moneyHTMLFormat($amount)
    {
        $integerValue = floor($amount);
        $decimalValue = round(($amount - $integerValue)*100, 0);
        $intHTML = '<span class="money-int">'.number_format($integerValue).'</span>';

        $decimalHTML = '<sup class="money-decimal">.'
            .str_pad($decimalValue, 2, '0', STR_PAD_LEFT)
            .'</sup>';

        $return = $intHTML.$decimalHTML;

        $symbolHTML = '<span class="money-currency">'.$this->symbol.'</span>';
        if ($this->position == 'before') {
            $return = $symbolHTML.' '.$amount;
        } else {
            $return .= ' '.$symbolHTML;
        }

        return '<span class="price" content="'.$amount.'">'.$return.'</span>';
    }
}
