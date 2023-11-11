<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class PegawaiController extends ResourceController
{
    protected $modelName = 'App\Models\Pegawai';
    protected $format = 'json';
    protected $useTimestamps = true;

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $data = [
            'message' => 'success',
            'data_pegawai' => $this->model->orderBy('id', 'DESC')->findAll(),
        ];

        return $this->respond($data, 200);;
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $data = [
            'message' => 'success',
            'pegawai_by_id' => $this->model->find($id),
        ];

        if ($data['pegawai_by_id'] == null) {
            return $this->failNotFound('Data pegawai tidak ditemukan');
        }

        return $this->respond($data, 200);;
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $rules = $this->validate([
            'nama'      => 'required',
            'jabatan'   => 'required',
            'bidang'    => 'required',
            'email'    => 'required',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];

            return $this->failValidationErrors($response);
        }

        $this->model->insert([
            'nama'      => esc($this->request->getVar('nama')),
            'jabatan'   => esc($this->request->getVar('jabatan')),
            'bidang'    => esc($this->request->getVar('bidang')),
            'email'     => esc($this->request->getVar('email')),
        ]);

        $response = [
            'message' => 'Data berhasil ditambahkan!'
        ];

        return $this->respondCreated($response);
    }


    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $rules = $this->validate([
            'nama'      => 'required',
            'jabatan'   => 'required',
            'bidang'    => 'required',
            'email'    => 'required',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];

            return $this->failValidationErrors($response);
        }

        $this->model->update($id, [
            'nama'      => esc($this->request->getVar('nama')),
            'jabatan'   => esc($this->request->getVar('jabatan')),
            'bidang'    => esc($this->request->getVar('bidang')),
            'email'     => esc($this->request->getVar('email')),
        ]);

        $response = [
            'message' => 'Data berhasil diubah!'
        ];

        return $this->respond($response, 200);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->model->delete($id);

        $response = [
            'message' => 'Data berhasil dihapus!'
        ];

        return $this->respondDeleted($response);
    }
}
