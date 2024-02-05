<?php

namespace Paytic\Payments\Subscriptions\Actions\Urls;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use Bytic\SignedUrl\Utility\UrlSigner;

class SubscriptionUrls extends Action
{
    use HasSubject;

    protected const DEFAULT_EXPIRATION = 60 * 60 * 24 * 365;

    public function manageUrl()
    {
        $url = $this->getSubject()->compileUrl('manage');
        return $this->sign($url);
    }

    protected function sign($url)
    {
        return UrlSigner::sign($url, self::DEFAULT_EXPIRATION);
    }

    public function editUrl()
    {
        $url = $this->getSubject()->compileUrl('edit');
        return $this->sign($url);
    }

    public function cancelUrl()
    {
        $url = $this->getSubject()->compileUrl('manage');
        return $this->sign($url);
    }
}