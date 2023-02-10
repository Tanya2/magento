<?php

namespace Weather\Meteomatics\Api\Data;

interface MeteomaticsInterface
{
    const ID = 'weather_meteomatics_id';
    const WIND_SPEED_10 = 'wind_speed_10m';
    const WIND_DIR_10 = 'wind_dir_10m';
    const T_2 = 't_2m';
    const T_MAX_24 = 't_max_2m_24h';
    const T_MIN_24 = 't_min_2m_24h';
    const MSL_PRESSURE = 'msl_pressure';
    const PRECIP_1 = 'precip_1h';
    const SUNRISE = 'sunrise';
    const SUNSET = 'sunset';
    const Date = 'created';

    /**
     * @return string
     */
    public function getTemperature(): string;

    /**
     * @param string $type
     * @return void
     */
    public function setTemperature(string $type): void;

    /**
     * @return mixed|null
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id);
}
