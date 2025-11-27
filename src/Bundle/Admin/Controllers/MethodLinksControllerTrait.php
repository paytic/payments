<?php

namespace Paytic\Payments\Bundle\Admin\Controllers;

use Nip\Records\Collections\Collection;
use Nip\Records\Record;
use Paytic\Payments\MethodLinks\Actions\AddPaymentMethodLinksForTenant;
use Paytic\Payments\MethodLinks\Actions\FindPaymentMethodLinksForTenant;
use Paytic\Payments\MethodLinks\Models\PaymentMethodLink;
use Paytic\Payments\MethodLinks\Models\PaymentMethodLinks;
use Paytic\Payments\PaymentMethods\Actions\FindPaymentMethodsForTenant;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 * @method PaymentMethodLink getModelFromRequest
 * @method PaymentMethodLinks getModelManager
 *
 * @method string getAfterUrl(string $key)
 * @method string getAfterFlashName(string $key)
 * @method void setAfterUrlFlash(string $url, string $controller, array $keys)
 *
 * @method void flashRedirect(string $message, string $redirectUrl, string $type, string $flashName)
 * @method void redirect(string $url)
 * @method checkForeignModelFromRequest(string $modelName, array $keys)
 */
trait MethodLinksControllerTrait
{
    use AbstractControllerTrait;

    public function tenant(): void
    {
        $tenant = $this->getPaymentTenantFromRequest();

        $availableMethods = FindPaymentMethodsForTenant
            ::for($this->getPaymentTenant())
            ->fetch();

        $methodLinks = FindPaymentMethodLinksForTenant::for($tenant)->fetch();
        $this->eventCheckUpdateMethods($tenant, $methodLinks);

        $methodLinks = $methodLinks->keyBy('id_method');

        $this->payload()->with([
            'methodLinks' => $methodLinks,
            'availableMethods' => $availableMethods,
            'payment_link_tenant' => $tenant,
        ]);
    }

    /**
     * @return mixed
     */
    protected function getPaymentTenantFromRequest()
    {
        $tenantName = $this->getRequest()->get('tenant');
        return $this->checkForeignModelFromRequest($tenantName, ['tenant_id', 'id']);
    }

    abstract protected function getPaymentTenant();

    /**
     * @param Record $tenant
     * @param PaymentMethodLink[]|Collection $eventMethods
     */
    protected function eventCheckUpdateMethods($tenant, $methodLinks)
    {
        $methodsPost = $this->getRequest()->request->all()['methods'] ?? null;

        if (!is_array($methodsPost)) {
            return;
        }
        foreach ($methodsPost as $id => $data) {
            $method = $methodLinks->get($id);
            if ($method) {
                $field = 'notes';
                $value = $data[$field];
                $method->{$field} = $value;
            }
        }
        $methodLinks->save();

        $this->setAfterUrlFlashTenant($tenant);
        $this->flashRedirect(
            $this->getModelManager()->getMessage('notes.success'),
            $this->getAfterUrl('after-notes'),
            'success',
            $this->getAfterFlashName('after-notes')
        );
    }

    /**
     * @param Record $tenant
     * @return void
     */
    protected function setAfterUrlFlashTenant($tenant): void
    {
        $methodLinksRepo = PaymentsModels::methodLinks();
        $this->setAfterUrlFlash(
            $methodLinksRepo->compileURL(
                'tenant',
                ['tenant' => $tenant->getManager()->getMorphName(), 'tenant_id' => $tenant->id]
            ),
            $methodLinksRepo->getController(),
            ['after-delete', 'after-visibility', 'after-primary', 'after-notes']
        );
    }

    public function add()
    {
        $tenant = $this->getPaymentTenantFromRequest();

        $paymentMethod = PaymentsModels::methods()->findOne($this->getRequest()->get('id_payment_method'));

        AddPaymentMethodLinksForTenant::for($tenant)
            ->withPaymentMethod($paymentMethod)
            ->handle();

        $redirectUrl = $this->getRequest()->headers->get('referer');

        $this->redirect($redirectUrl);
    }

    public function activate(): void
    {
        $this->itemVisibility('yes');
    }

    /**
     * @param string $visible
     */
    protected function itemVisibility($visible = 'no')
    {
        /** @var PaymentMethodLink $item */
        $item = $this->getModelFromRequest();

        $item->visible = $visible;
        $messageSlug = 'visible.success.' . $visible;
        $item->save();

        $this->setAfterUrlFlashTenant($item->getTenant());
        $this->flashRedirect(
            $this->getModelManager()->getMessage($messageSlug),
            $this->getAfterUrl('after-visibility'),
            'success',
            $this->getAfterFlashName('after-visibility')
        );
    }

    public function deactivate(): void
    {
        $this->itemVisibility('no');
    }

    public function primary(): void
    {
        $item = $this->getModelFromRequest();
        $tenant = $item->getTenant();
        $methodLinks = FindPaymentMethodLinksForTenant::for($tenant)->fetch();

        foreach ($methodLinks as $methodLink) {
            $methodLink->primary = ($methodLink->id == $item->id) ? 'yes' : 'no';
        }
        $methodLinks->save();

        $this->setAfterUrlFlashTenant($item->getTenant());
        $this->flashRedirect(
            $this->getModelManager()->getMessage('primary.success'),
            $this->getAfterUrl('after-primary'),
            'success',
            $this->getAfterFlashName('after-primary')
        );
    }

    /**
     * @param PaymentMethodLink $item
     * @return void
     */
    protected function deleteRedirect($item): void
    {
        $this->setAfterUrlFlashTenant($item->getTenant());
        parent::deleteRedirect($item);
    }

    protected function generateModelName(): string
    {
        return get_class(PaymentsModels::methodLinks());
    }
}
