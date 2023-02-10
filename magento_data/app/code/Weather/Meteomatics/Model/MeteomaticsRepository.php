<?php

namespace Weather\Meteomatics\Model;

use Weather\Meteomatics\Api\Data\MeteomaticsInterface;
use Weather\Meteomatics\Api\MeteomaticsRepositoryInterface;
use Weather\Meteomatics\Api\MeteomaticsSearchResultInterface;
use Weather\Meteomatics\Model\ResourceModel\Meteomatics\CollectionFactory;
use Weather\Meteomatics\Model\ResourceModel\Meteomatics as MeteomaticsResource;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Weather\Meteomatics\Api\MeteomaticsSearchResultInterfaceFactory;
use Weather\Meteomatics\Model\MeteomaticsFactory;

class MeteomaticsRepository implements MeteomaticsRepositoryInterface
{
    private CollectionFactory $collectionFactory;
    private MeteomaticsResource $meteomaticsResource;
    private MeteomaticsFactory $meteomaticsFactory;
    private MeteomaticsSearchResultInterfaceFactory $searchResultInterfaceFactory;
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @param MeteomaticsFactory $MeteomaticsFactory
     * @param CollectionFactory $collectionFactory
     * @param MeteomaticsResource $MeteomaticsResource
     * @param MeteomaticsSearchResultInterfaceFactory $searchResultInterfaceFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        MeteomaticsFactory $meteomaticsFactory,
        CollectionFactory $collectionFactory,
        MeteomaticsResource  $meteomaticsResource,
        MeteomaticsSearchResultInterfaceFactory $searchResultInterfaceFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->meteomaticsFactory = $meteomaticsFactory;
        $this->collectionFactory = $collectionFactory;
        $this->meteomaticsResource = $meteomaticsResource;
        $this->searchResultFactory = $searchResultInterfaceFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param int $id
     * @return MeteomaticsInterface
     * @throws NoSuchEntityException
     */
    public function get(int $id): MeteomaticsInterface
    {
        $object = $this->meteomaticsFactory->create();
        $this->meteomaticsResource->load($object, $id);
        if (! $object->getId()) {
            throw new NoSuchEntityException(__('Unable to find entity with ID "%1"', $id));
        }
        return $object;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return MeteomaticsSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): MeteomaticsSearchResultInterface
    {
        $collection = $this->collectionFactory->create();
        $searchCriteria = $this->searchCriteriaBuilder->create();

        if (null === $searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
                foreach ($filterGroup->getFilters() as $filter) {
                    $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                    $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
                }
            }
        }

        $searchResult = $this->searchResultFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);
        return $searchResult;
    }

    /**
     * @param MeteomaticsInterface $meteomatics
     * @return MeteomaticsInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(MeteomaticsInterface $meteomatics): MeteomaticsInterface
    {
        $this->eteommaticsResource->save($meteomatics);
        return $meteomatics;
    }

    /**
     * @param MeteomaticsInterface $workingHours
     * @return bool
     */
    public function delete(MeteomaticsInterface $workingHours): bool
    {
        try {
            $this->meteomaticsResource->delete($workingHours);
        } catch (\Exception $e) {
            throw new StateException(__('Unable to remove entity #%1', $workingHours->getId()));
        }
        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->get($id));
    }

}
