<?php

namespace App\Models;
use CodeIgniter\Model;

class JenisKendModel extends Model {

    function get_allJenisKend()
    {
        $sql = 'SELECT * FROM `MasterJenisKend`';
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

 
}