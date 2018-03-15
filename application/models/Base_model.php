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
     * Current language
     * @var string
     */
    protected $currentLanguage = 'en';

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

    /**
     * Set the filter
     */
    protected function queryBuildExistedItems()
    {
        $this->db->where(array(
            'isDeleted' => self::STATUS_NOT_DELETED
        ));
    }

    /**
     * @param $bean
     * @param $table
     * @param $foreignKey
     */
    protected function loadMultilingualFields($bean, $table, $foreignKey)
    {
        $row = $this->db->where(array(
            'language'  => $this->currentLanguage,
            $foreignKey => $bean->id
        ))->get($table)->row();
        $excludeFields = array('id', 'language', $foreignKey);
        if (!empty($row)) {
            $fields = get_object_vars($row);
            foreach ($fields as $fieldName => $value) {
                if (!in_array($fieldName, $excludeFields)) {
                    $bean->{$fieldName} = $row->{$fieldName};
                }
            }
        }
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
    const TABLE_MENU = 'menu';
    const TABLE_MENU_LANGUAGE = 'menu-language';
    const TABLE_MENU_TYPE = 'menu-type';

}

/**
 * Class NotFoundException
 */
class NotFoundException extends Exception
{
}
