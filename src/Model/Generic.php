<?php

namespace Framework\CrudApi\Model;

use Framework\Base\Model\Bruno;
use Framework\Base\Model\BrunoInterface;

/**
 * Class Generic
 * @package Framework\CrudApi\Model
 */
class Generic extends Bruno
{
    /**
     * Sets `$resourceName` as the document collection
     *
     * @param string $resourceName
     *
     * @return BrunoInterface
     */
    public function setResourceName(string $resourceName)
    {
        $this->setCollection($resourceName);

        return $this;
    }
}
