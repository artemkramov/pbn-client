<?php


class Menu_model extends Base_model
{

    const STATUS_ENABLED = 1;
    const STATUS_NOT_ENABLED = 0;

    /**
     * @param $typeAlias
     * @return mixed
     */
    public function getMenuByType($typeAlias)
    {
        $this->queryBuildCurrentWebsite(DatabaseTableEnum::TABLE_MENU);
        $parentRecords = $this->db->select(DatabaseTableEnum::TABLE_MENU . '.*, ' . DatabaseTableEnum::TABLE_MENU_LANGUAGE . '.title')
            ->from(DatabaseTableEnum::TABLE_MENU)
            ->join(DatabaseTableEnum::TABLE_MENU_TYPE, DatabaseTableEnum::TABLE_MENU_TYPE . '.id = ' . DatabaseTableEnum::TABLE_MENU . '.menuTypeID')
            ->join(DatabaseTableEnum::TABLE_MENU_LANGUAGE, DatabaseTableEnum::TABLE_MENU_LANGUAGE . '.menuID = ' . DatabaseTableEnum::TABLE_MENU . '.id')
            ->where(array(
                DatabaseTableEnum::TABLE_MENU_TYPE . '.alias'     => $typeAlias,
                DatabaseTableEnum::TABLE_MENU_TYPE . '.isDeleted' => self::STATUS_NOT_DELETED,
                DatabaseTableEnum::TABLE_MENU . '.isDeleted'      => self::STATUS_NOT_DELETED,
                DatabaseTableEnum::TABLE_MENU . '.isEnabled'      => self::STATUS_ENABLED,
                DatabaseTableEnum::TABLE_MENU . '.parentID'       => null
            ))
            ->order_by('sort')
            ->get()
            ->result();
        foreach ($parentRecords as $parentRecord) {
            $parentRecord->children = $this->getMenuChildren($parentRecord);
            $this->formUrl($parentRecord);
        }
        return $parentRecords;
    }

    /**
     * @param $menu
     * @return mixed
     */
    public function getMenuChildren($menu)
    {
        $this->queryBuildCurrentWebsite(DatabaseTableEnum::TABLE_MENU);
        $childRecords = $this->db->select(DatabaseTableEnum::TABLE_MENU . '.*,' . DatabaseTableEnum::TABLE_MENU_LANGUAGE . '.title')
            ->from(DatabaseTableEnum::TABLE_MENU)
            ->join(DatabaseTableEnum::TABLE_MENU_LANGUAGE, DatabaseTableEnum::TABLE_MENU_LANGUAGE . '.menuID = ' . DatabaseTableEnum::TABLE_MENU . '.id')
            ->where(array(
                'parentID'  => $menu->id,
                'isDeleted' => self::STATUS_NOT_DELETED,
                'isEnabled' => self::STATUS_ENABLED
            ))
            ->get()
            ->result();
        foreach ($childRecords as $childRecord) {
            $childRecord->children = $this->getMenuChildren($childRecord);
            $this->formUrl($childRecord);
        }
        return $childRecords;
    }

    /**
     * @param $menu
     */
    private function loadMenuMultilingualFields($menu)
    {
        $this->loadMultilingualFields($menu, DatabaseTableEnum::TABLE_MENU_LANGUAGE, 'menuID');
    }

    /**
     * @param $menu
     */
    private function formUrl($menu)
    {
        $menu->siteUrl = '';
        if ($menu->isDirect) {
            $menu->siteUrl = site_url($menu->url);
        } else {
            $page = $this->getRecordByID(DatabaseTableEnum::TABLE_PAGE, $menu->pageID);
            if (isset($page)) {
                $menu->siteUrl = $this->page_model->getDefaultPageRoute($page);
            }
        }
    }

}