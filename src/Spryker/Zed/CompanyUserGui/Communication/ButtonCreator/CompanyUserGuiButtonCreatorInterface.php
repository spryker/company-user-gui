<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyUserGui\Communication\ButtonCreator;

interface CompanyUserGuiButtonCreatorInterface
{
    public function addAttachCustomerButton(int $idCustomer, array $buttons): array;
}
