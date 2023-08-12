<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\OldDatabase\sis_tblpelajar;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class TestController extends Controller
{
    public function index()
    {
        $user = User::find(4);
        $user->assignRole('alumni');

        return view('pages.empty');
    }

    public function base2()
    {
        return view('pages.empty');
    }

    public function index2()
    {
        return view('auth.login2');
    }

    public function testform()
    {
        // Alert::success('Success Title', 'Success Message');
        // Alert::toast('Toast Message', 'success');
        // Alert::html('Html Title', 'Html Code', 'Type');

        return view('test.testform');
    }

    public function testpemohon()
    {
        return view('test.testpemohon');
    }

    public function testformwizard()
    {
        return view('test.testformwizard');
    }

    public function table(UsersDataTable $dataTable)
    {
        return $dataTable->render('test.table');
    }

    public function getBasicData()
    {
        $users = User::select(['id', 'name', 'username', 'created_at', 'updated_at']);

        return Datatables::of($users)->make();
    }

    public function testDatatable(UsersDataTable $dataTable)
    {
        return $dataTable->render('users.index');
    }

    public function testConnection()
    {
        $data = sis_tblpelajar::all();

        dd($data);
    }
}
