<?php

namespace Paytic\Payments\Tests\Models\Currencies\Traits;

use Paytic\Payments\Tests\AbstractTest;
use Paytic\Payments\Tests\Fixtures\Records\Currencies\Currency;

/**
 * Class CurrencyTraitTest
 * @package Paytic\Payments\Tests\Models\Currencies\Traits
 */
class CurrencyTraitTest extends AbstractTest
{
    /**
     * @param $amount
     * @dataProvider dataMoneyHTMLFormat
     */
    public function testMoneyHTMLFormat($amount, $htmlExpected)
    {
        $currency = new Currency();
        $currency->code = 'RON';
        $currency->symbol = 'lei';

        self::assertSame($htmlExpected, $currency->moneyHTMLFormat($amount));
    }

    /**
     * @return array
     */
    public function dataMoneyHTMLFormat()
    {
        return [
            ['200.789','<span class="price" content="200.789"><span class="money-int">200</span><sup class="money-decimal">.79</sup> <span class="money-currency">lei</span></span>'],
            ['200.749','<span class="price" content="200.749"><span class="money-int">200</span><sup class="money-decimal">.75</sup> <span class="money-currency">lei</span></span>'],
            ['200.744','<span class="price" content="200.744"><span class="money-int">200</span><sup class="money-decimal">.74</sup> <span class="money-currency">lei</span></span>'],
            ['200','<span class="price" content="200"><span class="money-int">200</span><sup class="money-decimal">.00</sup> <span class="money-currency">lei</span></span>'],
        ];
    }
}
