<?php

namespace App\Models;
use CodeIgniter\Model;

class SettingModel extends Model {

    function get_setting_byName($name)
    {
        $sql = 'SELECT * FROM `MasterSetting` WHERE `Name`=?';
        $query = $this->db->query($sql,array($name));
        return $query->getFirstRow();
    }

    function get_all_setting()
    {
        $sql = 'SELECT * FROM `MasterSetting`';
        $query = $this->db->query($sql);
        return $query->getresultArray();
    }
}