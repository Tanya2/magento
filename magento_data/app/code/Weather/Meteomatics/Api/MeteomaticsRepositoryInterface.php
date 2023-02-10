<?php

namespace Weather\Meteomatics\Api;

use Weather\Meteomatics\Api\Data\MeteomaticsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface MeteomaticsRepositoryInterface
{
    /**
     * @param int $id
     * @return MeteomaticsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get(int $id): MeteomaticsInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return MeteomaticsSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): MeteomaticsSearchResultInterface;

    /**
     * @param MeteomaticsInterface $productTypes
     * @return MeteomaticsInterface
     */
    public function save(MeteomaticsInterface $productTypes): MeteomaticsInterface;

    /**
     * @param MeteomaticsInterface $workingHours
     * @return bool
     */
    public function delete(MeteomaticsInterface $workingHours): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}
