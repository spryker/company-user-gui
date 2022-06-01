<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyUserGui\Communication\Form\DataProvider;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCompanyFacadeInterface;
use Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCompanyUserFacadeInterface;
use Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCustomerFacadeInterface;

class CustomerCompanyAttachFormDataProvider
{
    /**
     * @var \Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCompanyUserFacadeInterface
     */
    protected $companyUserFacade;

    /**
     * @var \Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCompanyFacadeInterface
     */
    protected $companyFacade;

    /**
     * @var \Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @param \Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCompanyUserFacadeInterface $companyUserFacade
     * @param \Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCompanyFacadeInterface $companyFacade
     * @param \Spryker\Zed\CompanyUserGui\Dependency\Facade\CompanyUserGuiToCustomerFacadeInterface $customerFacade
     */
    public function __construct(
        CompanyUserGuiToCompanyUserFacadeInterface $companyUserFacade,
        CompanyUserGuiToCompanyFacadeInterface $companyFacade,
        CompanyUserGuiToCustomerFacadeInterface $customerFacade
    ) {
        $this->companyUserFacade = $companyUserFacade;
        $this->companyFacade = $companyFacade;
        $this->customerFacade = $customerFacade;
    }

    /**
     * @param int $idCustomer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function getData(int $idCustomer): CompanyUserTransfer
    {
        $customerTransfer = (new CustomerTransfer())
            ->setIdCustomer($idCustomer);

        $customerTransfer = $this->customerFacade->findCustomerById($customerTransfer);
        $companyUserTransfer = new CompanyUserTransfer();

        if ($customerTransfer === null) {
            return $companyUserTransfer;
        }

        return $companyUserTransfer
            ->setCustomer($customerTransfer)
            ->setFkCustomer($customerTransfer->getIdCustomer());
    }

    /**
     * @return array<mixed>
     */
    public function getOptions(): array
    {
        return [
            'data_class' => CompanyUserTransfer::class,
        ];
    }

    /**
     * @return array<int> [company name => company id]
     */
    public function createCompanyList(): array
    {
        $companies = [];

        foreach ($this->companyFacade->getCompanies()->getCompanies() as $companyTransfer) {
            $key = sprintf(
                '%s (ID: %d)',
                $companyTransfer->getName(),
                $companyTransfer->getIdCompany(),
            );
            $companies[$key] = $companyTransfer->getIdCompany();
        }

        return $companies;
    }
}
