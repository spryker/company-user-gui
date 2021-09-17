<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyUserGui\Communication\Plugin\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\CustomerExtension\Dependency\Plugin\CustomerTableActionExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\CompanyUserGui\Communication\CompanyUserGuiCommunicationFactory getFactory()
 * @method \Spryker\Zed\CompanyUserGui\CompanyUserGuiConfig getConfig()
 */
class CompanyUserCustomerTableActionExpanderPlugin extends AbstractPlugin implements CustomerTableActionExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Adds "Attach to company" button in actions for customer table
     *
     * @api
     *
     * @param int $idCustomer
     * @param array<\Generated\Shared\Transfer\ButtonTransfer> $buttonTransfers
     *
     * @return array<\Generated\Shared\Transfer\ButtonTransfer>
     */
    public function execute(int $idCustomer, array $buttonTransfers): array
    {
        $countActiveCompanyUsersByIdCustomer = $this->getFactory()
            ->getCompanyUserFacade()
            ->countActiveCompanyUsersByIdCustomer((new CustomerTransfer())->setIdCustomer($idCustomer));

        if ($countActiveCompanyUsersByIdCustomer !== 0) {
            return $buttonTransfers;
        }

        return $this->getFactory()
            ->createCompanyUserGuiButtonCreator()
            ->addAttachCustomerButton($idCustomer, $buttonTransfers);
    }
}
