<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    public function index()
    {
        $customerModel = new CustomerModel();

        $customers = $customerModel->findAll();

        return view('customers', [
            'customers' => $customers
        ]);
    }

    public function newCustomer()
    {
        return view('customers_new');
    }

    public function create()
    {
        $rules = [
            'full_name' => 'required|min_length[2]|max_length[100]',
            'email'     => 'required|valid_email',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            return view('customers_new', [
                'validation' => $this->validator
            ]);
        }

        $customerModel = new CustomerModel();

        $customerModel->insert([
            'full_name'  => $this->request->getPost('full_name'),
            'email'      => $this->request->getPost('email'),
            'phone'      => $this->request->getPost('phone'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/customers');
    }

    public function edit($id)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if (!$customer) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('customers_edit', [
            'customer' => $customer
        ]);
    }

    public function update($id)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if (!$customer) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'full_name' => 'required|min_length[2]|max_length[100]',
            'email'     => 'required|valid_email',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            return view('customers_edit', [
                'customer'   => $customer,
                'validation' => $this->validator
            ]);
        }

        $customerModel->update($id, [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'phone'     => $this->request->getPost('phone'),
        ]);

        return redirect()->to('/customers');
    }
}