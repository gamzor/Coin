<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Kirill\Coins\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Utility class for customer balance
 */
class Data extends AbstractHelper
{
    /**
     * XML configuration paths
     */
    const XML_PATH_ACTIVE = 'coins/general/active';

    const XML_PATH_PERCENT = 'coins/general/percent';


    /**
     * Check whether customer balance functionality should be enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ACTIVE, ScopeInterface::SCOPE_STORE) == 1;
    }

    /**
     * Get percent from configuration
     *
     * @return int
     */
    public function getPercent()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_PERCENT, ScopeInterface::SCOPE_STORE);
    }
}
