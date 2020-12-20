<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Karyawan extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('KaryawanModel', 'ambildata');
        $this->methods['index_get']['limit'] = 1000;
        $this->methods['index_delete']['limit'] = 1000;
        $this->methods['index_post']['limit'] = 1000;
        $this->methods['index_put']['limit'] = 1000;
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ($id == null) {
            $karyawan = $this->ambildata->getKaryawan();
        } else {
            $karyawan = $this->ambildata->getKaryawan($id);
        }


        if ($karyawan) {
            $this->set_response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->set_response([
                'status' => false,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        if ($id == null) {
            $this->set_response([
                'status' => false,
                'message' => 'provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->ambildata->deleteKaryawan($id) > 0) {
                //ok
                $this->set_response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                //id not found
                $this->set_response([
                    'status' => false,
                    'message' => 'id not found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'id' => $this->post('id'),
            'nama' => $this->post('nama'),
            'absen' => $this->post('absen'),
            'lembur' => $this->post('lembur'),
            'target' => $this->post('target'),
            'reward' => $this->post('reward')
        ];

        if ($this->ambildata->createKaryawan($data) > 0) {
            $this->set_response([
                'status' => true,
                'message' => 'new employee has been created'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->set_response([
                'status' => false,
                'message' => 'failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'id' => $this->post('id'),
            'nama' => $this->post('nama'),
            'absen' => $this->post('absen'),
            'lembur' => $this->post('lembur'),
            'target' => $this->post('target'),
            'reward' => $this->post('reward')
        ];

        if ($this->ambildata->updatekaryawan($data, $id) > 0) {
            $this->set_response([
                'status' => true,
                'message' => 'employe data has been updated'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else {
            $this->set_response([
                'status' => false,
                'message' => 'failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
