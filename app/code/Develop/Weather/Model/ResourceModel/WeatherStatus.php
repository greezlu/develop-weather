<?php

declare(strict_types=1);

namespace Develop\Weather\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class WeatherStatus extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('weather_status', 'id');
    }
}
