<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyUserGui\Dependency\Facade;

use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

interface CompanyUserGuiToCompanyUserFacadeInterface
{
    public function getCompanyUserById(int $idCompanyUser): CompanyUserTransfer;

    public function create(CompanyUserTransfer $companyUserTransfer): CompanyUserResponseTransfer;

    public function update(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer;

    public function getCompanyUserCollection(
        CompanyUserCriteriaFilterTransfer $companyUserCriteriaFilterTransfer
    ): CompanyUserCollectionTransfer;

    public function delete(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer;

    public function enableCompanyUser(CompanyUserTransfer $companyUserTransfer): CompanyUserResponseTransfer;

    public function disableCompanyUser(CompanyUserTransfer $companyUserTransfer): CompanyUserResponseTransfer;

    public function countActiveCompanyUsersByIdCustomer(CustomerTransfer $customerTransfer): int;

    public function findCompanyUserById(int $idCompanyUser): ?CompanyUserTransfer;
}
