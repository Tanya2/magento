<?php

namespace Weather\Meteomatics\Model;

use Weather\Meteomatics\Api\Data\MeteomaticsInterface;
use Magento\Framework\Model\AbstractModel;

class Meteomatics extends AbstractModel implements MeteomaticsInterface
{

    protected function _construct()
    {
        parent::_init('Weather\Meteomatics\Model\ResourceModel\Meteomatics');
    }

    /**
     * @return string
     */
    public function getTemperature(): string
    {
        return $this->getData(MeteomaticsInterface::T_2);
    }

    /**
     * @param string $temperature
     * @return void
     */
    public function setTemperature(string $temperature): void
    {
        $this->setData(MeteomaticsInterface::T_2, $temperature);
    }

    /**
     * @return mixed|null
     */
    public function getId()
    {
        return $this->_getData('weather_meteomatics_id');
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setId($value)
    {
        $this->setData('weather_meteomatics_id', $value);
        return $this;
    }
    /**
     * @return string
     */
    public function getWindSpeed(): string
    {
        return $this->getData(MeteomaticsInterface::WIND_SPEED_10);
    }

    /**
     * @param string $windSpeed
     * @return void
     */
    public function setWindSpeed(string $windSpeed): void
    {
        $this->setData(MeteomaticsInterface::WIND_SPEED_10, $windSpeed);
    }


}
