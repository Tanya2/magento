<?php

namespace Weather\Meteomatics\Cron;

use Weather\Meteomatics\Helper\ApiMeteomatics;
use Weather\Meteomatics\Model\MeteomaticsFactory;
use Weather\Meteomatics\Model\StoreLocatorFactory;

class Add
{
    public function __construct(
        ApiMeteomatics $helper,
        StoreLocatorFactory $storeLocatorFactory,
        MeteomaticsFactory $meteomaticsFactory
    ) {
        $this->apiMeteomatics = $helper;
        $this->storeLocatorFactory = $storeLocatorFactory;
        $this->meteomaticsFactory = $meteomaticsFactory;
    }

    public function execute()
    {
        $storeLocator = $this->storeLocatorFactory->create();

        $stores = $storeLocator->getCollection();
        foreach ($stores as $store) {
            $this->addRow($store->getData());
        }
        return $this;
    }
    private function addRow($storeLocatorData)
    {
        $meteomaticsResponse = $this->apiMeteomatics->getData(
            [[
                'lat' => (float) $storeLocatorData['latitude'],
                'long' => (float) $storeLocatorData['longitude']
            ]]
        );
        $meteomaticsData = $this->mappingData($meteomaticsResponse);
        foreach ($meteomaticsData as $insertData) {
            $meteomatics = $this->meteomaticsFactory->create();
            $meteomatics->addData($insertData);
            $meteomatics->save();
        }
    }
    private function mappingData(array $dataFromResponse): array
    {
        if (empty($dataFromResponse['data'])) {
            return [];
        }
        $returnData = [];
        foreach ($dataFromResponse['data'] as $coordinatesData) {
            if (empty($coordinatesData['parameter']) || empty($coordinatesData['coordinates'])) {
                continue;
            }
            if (empty(ApiMeteomatics::API_PARAMETERS[$coordinatesData['parameter']])) {
                continue;
            }
            foreach ($coordinatesData['coordinates'] as $coordinate) {
                if (empty($coordinate['dates']) || empty($coordinate['lat']) || empty($coordinate['lat'])) {
                    continue;
                }
                foreach ($coordinate['dates'] as $date) {

                    if (empty($date['date']) || !isset($date['value'])) {
                        continue;
                    }
                    $key = $coordinate['lat'] . '_' . $coordinate['lon'] . '_' . $date['date'];
                    $returnData[$key]['latitude'] = $coordinate['lat'];
                    $returnData[$key]['longitude'] = $coordinate['lon'];
                    $dbKey = ApiMeteomatics::API_PARAMETERS[$coordinatesData['parameter']];
                    $returnData[$key][$dbKey] = $date['value'];
                    $returnData[$key]['created'] = date_format(date_create($date['date']), 'Y-m-d H:i:s');
                }
            }
        }
        return $returnData;
    }
}
