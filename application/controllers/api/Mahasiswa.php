<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends RestController {

    public function __construct(){
        parent::__construct();
        $this->load->model('Mahasiswa_model');

        $this->methods['index_get']['limit'] = 10;
    }

    public function index_get(){
        $id = $this->get('id');

        if($id === NULL){
            $mahasiswa = $this->Mahasiswa_model->getMahasiswa();
        } else {
            $mahasiswa = $this->Mahasiswa_model->getMahasiswa($id);
        }
        
        if($mahasiswa){
            $this->response([
                'status' => true,
                'data' => $mahasiswa
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'data' => 'Data Not Found'
            ], RestController::HTTP_NOT_FOUND);
        }
    }

    public function index_delete(){
        $id = $this->delete('id');

        if($id === NULL){
            $this->response([
                'status' => false,
                'data' => 'Provide an ID!'
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            if($this->Mahasiswa_model->deleteMahasiswa($id) > 0){
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted',
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'data' => 'ID Not Found!'
                ], RestController::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post(){
        $data = [
            'nrp' => $this->post('nrp'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan'),
        ];

        if($this->Mahasiswa_model->createMahasiswa($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'New Mahasiswa Has Been Created',
            ], RestController::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Fail to create new data!'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    public function index_put(){

        $id = $this->put('id');

        $data = [
            'nrp' => $this->put('nrp'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan'),
        ];

        if($this->Mahasiswa_model->updateMahasiswa($data, $id) > 0){
            $this->response([
                'status' => true,
                'message' => 'New Mahasiswa Has Been Modify',
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Fail to create modify data!'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}