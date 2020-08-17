<?php

class stAllegroOrderImportTask extends stTask
{
    /**
     * Pasek postępu Allegro 
     *
     * @var stAllegroOrderBar
     */
    protected $allegroOrderBar;

    public function count(): int
    {        
        $count = 0;

        if (!stConfig::getInstance('stAllegroBackend')->get('access_token'))
        {
            return 0;
        }

        try
        {
            $api = stAllegroApi::getInstance();

            $forms = $api->getOrderCheckoutForms();

            $count = $forms->totalCount;
        }
        catch (stAllegroException $e)
        {
            $errors = stAllegroApi::getLastErrors();

            if ($errors)
            {
                foreach ($errors as $error)
                {
                    $this->getLogger()->error($error->message);
                }
            }
            else
            {
                $this->getLogger()->exception($e);
            }
        }

        return $count;

    }

    public function started()
    {
        $this->getAllegroOrderBar()->init();
    }

    public function execute(int $offset): int
    {
        sfLoader::loadHelpers(array('Helper', 'stUrl', 'stOrder', 'stDate'));
        try
        {
            $offset = $this->getAllegroOrderBar()->importOrder($offset);
        }
        catch (Throwable $e)
        {
            $this->logImportedOrders();
            throw $e;
        }

        $this->logImportedOrders();

        return $offset;
    }

    public function finished()
    {
        $this->clearCache();
    }

    protected function logImportedOrders()
    {
        $imported = $this->getAllegroOrderBar()->getImported();

        if ($imported)
        {
            $currency = stCurrency::getInstance(sfContext::getInstance());

            $currencyId = $currency->get()->getId();

            foreach ($imported as $order)
            {
                $currency->setByIso($order['currency']);

                $this->getLogger()->info('Nowe zamówienie %order% (oferty: %offers%) złożone %created_at% na kwotę %amount%', array(
                    '%order%' => sprintf('<a href="%s">%s</a>', st_url_for('@stOrder?action=edit&id=' . $order['id']), $order['number']),
                    '%offers%' => implode(', ', $order['offers']), 
                    '%created_at%' => st_format_date($order['created_at']),
                    '%amount%' => st_order_price($order['total_amount'], $currency),
                ));
            }

            $currency->set($currencyId);

            $this->allegroOrderBar->clearImported();
        }
    }

    /**
     * Zwraca instancję paska postępu importu zamowień Allegro
     *
     * @return stAllegroOrderBar
     */
    protected function getAllegroOrderBar()
    {
        if (null === $this->allegroOrderBar)
        {
            $this->allegroOrderBar = new stAllegroOrderBar();
        }

        return $this->allegroOrderBar;
    }
}