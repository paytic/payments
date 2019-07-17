<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\Mobilpay\FileLoader;

use ByTIC\Payments\Gateways\Providers\Mobilpay\Gateway;
use ByTIC\Payments\Models\Methods\Types\CreditCards;
use ByTIC\Payments\Tests\AbstractTest;
use ByTIC\Payments\Tests\Fixtures\Records\Gateways\Providers\Mobilpay\MobilpayData;
use ByTIC\Payments\Tests\Fixtures\Records\PaymentMethods\PaymentMethod;

/**
 * Class HasFileLoaderTest
 * @package ByTIC\Payments\Tests\Gateways\Providers\Mobilpay\FileLoader
 */
class HasFileLoaderTest extends AbstractTest
{
    public function testSaveToModelOptions()
    {
        /** @var PaymentMethod $paymentMethod */
        $paymentMethod = \Mockery::mock(PaymentMethod::class)->makePartial();
        $paymentMethod->shouldReceive('save');

        $paymentMethod->type = 'mobilpay';
        $options = unserialize(MobilpayData::getMethodOptions());
        $options['mobilpay']['file'] = 'public.cer';
        $options['mobilpay']['private-key'] = 'private.key';
        $paymentMethod->options = serialize($options);

        $type = new CreditCards();
        $type->setItem($paymentMethod);
        $paymentMethod->setType($type);

        $directoryPath = $paymentMethod->getFilesDirectory();
        MobilpayData::buildCertificates();
        self::assertDirectoryExists($directoryPath);

        /** @var Gateway $gateway */
        $gateway = $paymentMethod->getType()->getGateway();

        self::assertGreaterThan(5, strlen($gateway->getCertificate()));
        self::assertGreaterThan(5, strlen($gateway->getPrivateKey()));

        $options = $paymentMethod->getPaymentGatewayOptions();

        self::assertArrayNotHasKey('file', $options);
        self::assertArrayNotHasKey('private-key', $options);

        self::assertGreaterThan(50, strlen($options['certificate']));
        self::assertGreaterThan(50, strlen($options['privateKey']));
        self::assertDirectoryNotExists($directoryPath);
    }
}
