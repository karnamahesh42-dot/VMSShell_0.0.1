<?php

namespace App\Controllers;

class MasterDataController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $data['companies'] = $db->table('companies')->get()->getResultArray();
        $data['departments'] = $db->table('departments')->get()->getResultArray();
        $data['purposes'] = $db->table('purposes')->get()->getResultArray();

        return view('dashboard/masterDataManagement', $data);
    }


    public function save()
        {
            $db = \Config\Database::connect();

            $type = $this->request->getPost('type');
            $name = trim($this->request->getPost('name'));

            if ($name == '') {
                return redirect()->back()->with('error', 'Value required');
            }

            switch ($type) {
                case 'company':
                    $db->table('companies')->insert([
                        'company_name' => $name,
                      
                    ]);
                    break;

                case 'department':
                    $db->table('departments')->insert([
                        'department_name' => $name,
                       
                    ]);
                    break;

                case 'purpose':
                    $db->table('purposes')->insert([
                        'purpose_name' => $name,
                      
                    ]);
                    break;
            }

        return redirect()->back()->with('success', 'Saved successfully');
    }


    
    public function toggleStatus($type, $id)
    {
        $db = \Config\Database::connect();

        $tableMap = [
            'company'    => 'company_master',
            'department' => 'department_master',
            'purpose'    => 'purpose_master'
        ];

        $table = $tableMap[$type];

        $row = $db->table($table)->where('id', $id)->get()->getRowArray();

        if ($row) {
            $db->table($table)
               ->where('id', $id)
               ->update(['status' => $row['status'] == 1 ? 0 : 1]);
        }

        return redirect()->back();
    }

}
