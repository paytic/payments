<?php

namespace Paytic\Payments\Utility;

use Paytic\Payments\Application\Library\View\View;
use Paytic\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;

/**
 * Class PaymentsAssets
 * @package Paytic\Payments\Utility
 */
class PaymentsAssets
{
    /**
     * @param $path
     *
     * @return null|string
     */
    public static function loadAssetContent($path): ?string
    {
        $fullPath = self::basePath()
            . DIRECTORY_SEPARATOR . 'resources'
            . DIRECTORY_SEPARATOR . 'assets'
            . $path;
        if (file_exists($fullPath)) {
            return file_get_contents($fullPath);
        }

        return '';
    }

    /**
     * @return string
     */
    public static function basePath(): string
    {
        return dirname(dirname(__DIR__));
    }

    /**
     * @param IsPurchasableModelTrait $item
     *
     * @return null|string
     */
    public static function adminPurchasesSessionsList($item)
    {
        $sessions = $item->getPurchasesSessions();

        return self::loadView(
            '/admin/purchases_sessions/lists/list-purchase',
            ['sessions' => $sessions]
        );
    }

    /**
     * @param $path
     * @param array $variables
     *
     * @return null|string
     */
    public static function loadView($path, $variables = [])
    {
        return View::instance()->load($path, $variables, true);
    }
}
