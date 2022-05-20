<?php

namespace Develop\Weather\Model;

use Develop\Weather\Model\ResourceModel\WeatherCityCoordinates as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class WeatherCityCoordinates extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
