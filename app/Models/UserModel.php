<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'user';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['Nama', 'Email','Telp','Password'];

    function check_user_exist($email, $password)
    {
        $builder = $this->db->table('User');
        $builder->where('Email',$email);
        $builder->where('Password',md5($password));
        $query = $builder->get();
        return $query->getFirstRow();
    }

    function check_email($email)
    {
        $builder = $this->db->table('User');
        $builder->where('Email',$email);
        $query = $builder->get();
        return $query->getFirstRow();
    }
}