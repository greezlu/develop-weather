<?php

declare(strict_types=1);

namespace Develop\Weather\Model;

use Develop\Weather\Model\ResourceModel\WeatherInterpreter as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class WeatherInterpreter extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
