<?php

namespace App\Models;
use CodeIgniter\Model;

class PageModel extends Model {

    function get_pageHome()
    {
        $sql = 'SELECT * FROM `Page_Home`';
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

 
}