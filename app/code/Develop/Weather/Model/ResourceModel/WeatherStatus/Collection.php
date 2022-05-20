<?php

namespace Develop\Weather\Model\ResourceModel\WeatherStatus;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Develop\Weather\Model\ResourceModel\WeatherStatus as ResourceModel;
use Develop\Weather\Model\WeatherStatus as Model;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            Model::class,
            ResourceModel::class
        );
    }
}
