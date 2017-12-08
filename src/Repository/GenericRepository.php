<?php

namespace Framework\CrudApi\Repository;

use Framework\Base\Database\DatabaseQueryInterface;
use Framework\Base\Model\BrunoInterface;
use Framework\Base\Repository\BrunoRepository;

/**
 * Class GenericRepository
 * @package Framework\CrudApi\Repository
 */
class GenericRepository extends BrunoRepository
{
    /**
     * @return array
     */
    public function getModelAttributesDefinition(): array
    {
        return $this->getRepositoryManager()
                    ->getRegisteredModelFields($this->getResourceName());
    }

    public function getResourceName()
    {
        return $this->getCollection();
    }

    /**
     * @param BrunoInterface $bruno
     *
     * @return DatabaseQueryInterface
     */
    public function createNewQueryForModel(BrunoInterface $bruno): DatabaseQueryInterface
    {
        $bruno->setCollection($this->getResourceName());

        $query = parent::createNewQueryForModel($bruno);

        return $query;
    }
}
