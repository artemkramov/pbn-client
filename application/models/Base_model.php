<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 3/10/2018
 * Time: 3:51 PM
 */
class Base_model extends CI_Model
{

    const STATUS_DELETED = 1;
    const STATUS_NOT_DELETED = 0;

    /**
     * @param $tableName
     * @return mixed
     */
    public function getRecords($tableName)
    {
        $this->queryBuildExistedItems();
        return $this->db->get($tableName)->result();
    }

    /**
     * @param $tableName
     * @param $id
     * @return mixed
     */
    public function getRecordByID($tableName, $id)
    {
        $this->queryBuildExistedItems();
        $this->db->where('id', $id);
        return $this->db->get($tableName)->row();
    }

    protected function queryBuildExistedItems()
    {
        $this->db->where(array(
            'isDeleted' => self::STATUS_NOT_DELETED
        ));
    }

}

/**
 * Class DatabaseTableEnum
 */
abstract class DatabaseTableEnum
{

    const TABLE_LANGUAGE = 'language';
    const TABLE_PAGE = 'page';
    const TABLE_PAGE_EXTRA = 'page-extra';
    const TABLE_PAGE_LANGUAGE = 'page-language';
    const TABLE_PAGE_PAGE = 'page-page';
    const TABLE_PAGE_ROUTE = 'page-route';
    const TABLE_PAGINATION = 'pagination';
    const TABLE_ROUTE = 'route';
    const TABLE_TEMPLATE = 'template';
    const TABLE_PAGE_TYPE = 'page-type';

}

/**
 * Class NotFoundException
 */
class NotFoundException extends Exception
{}
