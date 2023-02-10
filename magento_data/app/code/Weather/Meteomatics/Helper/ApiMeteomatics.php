<?php

namespace Weather\Meteomatics\Helper;

use Magento\Framework\App\DeploymentConfig;
use \Magento\Framework\App\Helper\AbstractHelper;
use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;

class ApiMeteomatics extends AbstractHelper
{
    /**
     * API request URL
     */
    const API_REQUEST_URI = 'https://api.meteomatics.com/';

    /**
     * API request endpoint
     */
    const API_REQUEST_ENDPOINT = '';

    /**
     * API request endpoint
     */
    const API_PARAMETERS = [
        'precip_1h:mm' => 'precip_1h',
        'wind_speed_10m:ms' => 'wind_speed_10m',
        'wind_dir_10m:d' => 'wind_dir_10m',
        't_2m:C' => 't_2m',
        't_max_2m_24h:C' => 't_max_2m_24h',
        't_min_2m_24h:C' => 't_min_2m_24h',
        'msl_pressure:hPa' => 'msl_pressure',
        'precip_1h:mm' => 'precip_1h',
        'sunrise:sql' => 'sunrise',
        'sunset:sql' => 'sunset',
    ];



    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * @var DeploymentConfig
     */
    private $deploymentConfig;

    /**
     * GitApiService constructor
     *
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     */
    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory,
        DeploymentConfig $deploymentConfig
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
        $this->deploymentConfig = $deploymentConfig;
    }

    /**
     * Fetch data from API
     * @param float $lat
     * @param float $long
     */
    public function getData(array $locations): array
    {
        $locations = [
            ['lat' => 52.520551, 'long' => 13.461804],
            ['lat' => 47.51, 'long' => 8.78],
            ['lat' => 47.39, 'long' => 8.57]
        ];

//        $repositoryName = implode(",", array_keys(self::API_PARAMETERS)) . '/' . $this->locationsToString($locations) . '/json';
        $repositoryName =  't_2m:C,precip_1h:mm,wind_speed_10m:ms/' . $this->locationsToString($locations) . '/json';
        $response = $this->doRequest(trim($repositoryName));

        $status = $response->getStatusCode();
        if ($status != 200) {
            return array();
        }
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents();
        file_put_contents('/bitnami/magento/body.txt', print_r($responseContent, true));
        $responseContentArray = json_decode($responseContent, true);
        return empty($responseContentArray) ? array() : $responseContentArray;
    }

    /**
     * Do API request with provided params
     *
     * @param string $uriEndpoint
     * @param array $params
     * @param string $requestMethod
     *
     * @return Response
     */
    private function doRequest(
        string $uriEndpoint,
        array $params = [],
        string $requestMethod = Request::HTTP_METHOD_GET
    ): Response {
        $currentDate = date("Y-m-d") . 'T' . date("H:i:s") . '+00:00';
//        $currentDate = date("c");
        $headers = [
            "Authorization" => 'Basic ' . $this->deploymentConfig->get('meteomatics/authorization'),
            "Content-Type" => "application/json"
        ];
        /** @var Client $client */
        $client = $this->clientFactory->create(['config' => [
            'base_uri' => self::API_REQUEST_URI . $currentDate . '/'
        ]]);
        $params['headers'] = $headers;

        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                $params
            );
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
    }
    private function locationsToString(array $locations): string
    {
        $locationsArray = [];
        foreach ($locations as $location) {
            $locationsArray[] = $location['lat'] . ',' . $location['long'];
        }
        return implode('+', $locationsArray);
    }
}
