<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $settingModel;
    protected $pageModel;
    protected $jenisKendModel;
    protected $userModel;
    protected $db;

    protected $googleAPIkey = "AIzaSyD6K0PWT7z1d6vXB-2-j777H9cG-2mjOcY";
    public function __construct()
    {
        $this->settingModel = new \App\Models\SettingModel();
        $this->pageModel = new \App\Models\PageModel();
        $this->jenisKendModel = new \App\Models\JenisKendModel();
        $this->userModel = new \App\Models\UserModel();
        $this->db = \Config\Database::connect();
    }



    public function index()
    {
        $data['company_name'] = $this->settingModel->get_setting_byName("Nama Perusahaan")->value;
        $data['slogan'] = $this->settingModel->get_setting_byName("Slogan Perusahaan")->value;
        $data['homepage_section'] = $this->settingModel->get_setting_byName("Homepage Section")->value;
        $data['url_video'] = $this->settingModel->get_setting_byName("URL Video")->value;
        $data['whoarewe'] = $this->settingModel->get_setting_byName("Who Are We")->value;

        $data['homepage_title'] = $this->settingModel->get_setting_byName("Title Homepage Section")->value;
        $data['homepage_subtitle'] = $this->settingModel->get_setting_byName("Subtitle Homepage Section")->value;


        $data['homepage_content'] = $this->pageModel->get_pageHome();

        $data['jenis_kendaraan'] = $this->jenisKendModel->get_allJenisKend();

        echo view('template/css');
        echo view('template/header', $data);
        echo view('home/home', $data);
    }

    public function contact()
    {
        $data['company_name'] = $this->settingModel->get_setting_byName("Nama Perusahaan")->value;
        $data['company_map'] = $this->settingModel->get_setting_byName("Map Perusahaan")->value;
        $data['company_telp'] = $this->settingModel->get_setting_byName("Telp Perusahaan")->value;
        $data['company_email'] = $this->settingModel->get_setting_byName("Email Perusahaan")->value;
        $data['company_address'] = $this->settingModel->get_setting_byName("Alamat Perusahaan")->value;

        echo view('template/css');
        echo view('template/header', $data);
        echo view('home/contact', $data);
    }

    public function location()
    {
        $data['company_name'] = $this->settingModel->get_setting_byName("Nama Perusahaan")->value;

        $data['location_title'] = $this->settingModel->get_setting_byName("Title Location Section")->value;
        $data['location_subtitle'] = $this->settingModel->get_setting_byName("Subtitle Location Section")->value;

        $builder = $this->db->table('MasterWilayah');
        $builder->where('Aktif', 1);
        $query = $builder->get();

        $result = [];
        foreach ($query->getResultArray() as $row) {
            $result[$row['Wilayah']][] = $row['Daerah'];
        }

        uasort($result, function ($a, $b) {
            return count($a) - count($b);
        });

        $data['locations'] = $result;


        echo view('template/css');
        echo view('template/header', $data);
        echo view('home/location', $data);
    }

    public function getAutoCompleteLocation()
    {
        $key = $this->request->getVar('key');
        $builder = $this->db->table('MasterAlamat');
        $builder->select('Address');
        $builder->like('Address', '%' . $key . '%');
        $builder->limit(5);
        $query = $builder->get();
        $result = $query->getResultArray();

        return $this->response->setJSON($result);
    }

    public function getAutoCompleteLocationByGoogle()
    {
        $key = $this->googleAPIkey;
        $input = $this->request->getGet('input');
        $components = "country:ID";

        $url = "https://maps.googleapis.com/maps/api/place/autocomplete/json?input=" . urlencode($input) . "&key=" . $key . "&components=" . $components;

        $client = \Config\Services::curlrequest();
        $response = $client->get($url);

        return $this->response->setJSON(json_decode($response->getBody()));

    }

    public function savePlaces()
    {
        $postData = $this->request->getPost();

        $query = $this->db->query("SELECT COUNT(*) as total FROM `MasterAlamat` WHERE `Name` = ?", [$postData['name']]);
        $result = $query->getRow();

        if ($result->total < 1) {
            $sql = "INSERT INTO `MasterAlamat` (`Name`,`Address`) VALUES (?, ?)";
            $this->db->query($sql, [$postData['name'], $postData['address']]);
        }
    }

    public function login()
    {
        if (session()->has('user')) {
            return redirect()->back();
        }

        if (session()->has('url_lama')) {
            session()->remove('url_lama');
        }

        session()->set('url_lama', previous_url());

        echo view('template/css');
        echo view('login');
    }

    public function toLogin()
    {
        $postData = $this->request->getPost();


        $user = $this->userModel->check_user_exist($postData['lgn_email'], $postData['lgn_password']);


        if ($user) {
            $session = session();
            $session->set('user', $user);
            if (session()->has('url_lama')) {
                return redirect()->to(session()->get('url_lama'));
            } else {
                return redirect()->to(base_url());
            }
        } else {
            session()->setFlashdata('error', 'Invalid Email/Password!');
            return redirect()->to(base_url("/login"));
        }
    }

    public function logout()
    {
        if (session()->has('user')) {
            session()->remove('user');
        }

        return redirect()->back();
    }

    public function toRegist()
    {
        $postData = $this->request->getPost();

        if (!$postData['rgs_nama'] || !$postData['rgs_email'] || !$postData['rgs_password'] || !$postData['rgs_confirmation']) {
            session()->setFlashdata('error', 'Field Tidak Boleh Kosong!');
            return redirect()->back();
        }

        if ($postData['rgs_password'] != $postData['rgs_confirmation']) {
            session()->setFlashdata('error', 'Password Tidak Sama!');
            return redirect()->back();
        }

        $user = $this->userModel->check_email($postData['rgs_email']);
        if ($user) {
            session()->setFlashdata('error', 'Email Sudah Terdaftar');
            return redirect()->back();
        }

        $data = [
            'Nama' => $postData['rgs_nama'],
            'Email' => $postData['rgs_email'],
            'Password' => md5($postData['rgs_password']),
            'Telp' => $postData['rgs_telp']
        ];

        try {
            $this->userModel->insert($data);
            $insertedId = $this->userModel->insertID();

            $user = $this->userModel->find($insertedId);
            $user = json_decode(json_encode($user));
            $session = session();
            $session->set('user', $user);
            return redirect()->to(base_url());
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());

            return redirect()->back();
        }
    }

    public function toMap()
    {
        $data['company_name'] = $this->settingModel->get_setting_byName("Nama Perusahaan")->value;

        $data['jenis_kendaraan'] = $this->jenisKendModel->get_allJenisKend();

        $getData = $this->request->getGet();
        $data["asal"] = $getData['map_asal'];
        $data["tujuan"] = $getData['map_tujuan'];
        $data["kendaraan"] = $getData['map_kendaraan'];
        $data["api_key"] = $this->googleAPIkey;

        echo view('template/css');
        echo view('template/header', $data);
        echo view('map', $data);
    }

    public function getPrice()
    {
        $param1 = $this->request->getVar('distance'); // Misalnya untuk harga
        $param2 = $this->request->getVar('vehicleId');

        $query = $this->db->query("SELECT getHarga(?, ?) AS Biaya", [$param1, $param2]);
        $result = $query->getRow();

        $responseData = [
            'message' => 'Total cost calculated successfully!',
            'value' => $result->Biaya,
        ];

        echo json_encode($responseData);
    }
}
