<?php

namespace Paytic\Payments\Subscriptions\Actions\Urls;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use Bytic\SignedUrl\Utility\UrlSigner;

class SubscriptionUrls extends Action
{
    use HasSubject;

    protected $module = null;
    protected const DEFAULT_EXPIRATION = 60 * 60 * 24 * 365;

    /**
     * @param null $module
     */
    public function withModule($module): self
    {
        $this->module = $module;
        return $this;
    }

    public function manageUrl()
    {
        return $this->signedUrl('manage');
    }


    public function editUrl()
    {
        return $this->signedUrl('edit');
    }

    public function cancelUrl()
    {
        return $this->signedUrl('cancel');
    }

    public function reactivateUrl()
    {
        return $this->signedUrl(' reactivate');
    }

    public function canceledUrl()
    {
        return $this->signedUrl('cancelled');
    }

    protected function signedUrl($action, $params = [], $module = null)
    {
        $url = $this->compileUrl($action, $params, $module);
        return $this->sign($url);
    }

    protected function sign($url): string
    {
        return UrlSigner::sign($url, self::DEFAULT_EXPIRATION);
    }

    protected function compileUrl($action, $params = [], $module = null)
    {
        $module = $module ?: $this->module;
        return $this->getSubject()->compileUrl($action, $params, $module);
    }
}