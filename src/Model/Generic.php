<?php

namespace Framework\CrudApi\Model;

use Framework\Base\Model\Bruno;

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
     * @return $this
     */
    public function setResourceName(string $resourceName)
    {
        $this->setCollection($resourceName);

        return $this;
    }
}
