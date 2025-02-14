<?php
/**
 * Created by PhpStorm.
 * User: dyangalih
 * Date: 2019-02-10
 * Time: 12:33
 */

namespace WebAppId\Content\Responses;


use WebAppId\DDD\Responses\AbstractResponse;

class AbstractDataTableResponse extends AbstractResponse
{
    public $recordsFiltered;
    public $recordsTotal;

    /**
     * @return mixed
     */
    public function getRecordsFiltered(): int
    {
        return $this->recordsFiltered;
    }

    /**
     * @param mixed $recordsFiltered
     */
    public function setRecordsFiltered(int $recordsFiltered): void
    {
        $this->recordsFiltered = $recordsFiltered;
    }

    /**
     * @return mixed
     */
    public function getRecordsTotal(): int
    {
        return $this->recordsTotal;
    }

    /**
     * @param mixed $recordsTotal
     */
    public function setRecordsTotal(int $recordsTotal): void
    {
        $this->recordsTotal = $recordsTotal;
    }
}