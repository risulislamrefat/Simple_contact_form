<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\support\Facades\Redirect;

use DB;
use Session;
session_start();



class AdminController extends Controller
{
    public function add_contact()
    {
    	return view('addcontact');
    }

    public function dashboard()
    {
    	return view('welcome');
    }

    public function all_contact()
    {
       $allcontact_info= DB::table('users')
                    ->get();
        $manage_contact=view('allcontact') 
                        ->with('all_contact_info',$allcontact_info);
    	return view('layout')
                ->with('allcontact',$manage_contact);
    }
//contact added db part
    	public function save_contact(Request $request)
    {
    	$data = array();
    	$data['contact_name'] =$request->contact_name;
    	$data['contact_number'] =$request->contact_number;

    	DB::table('users')->insert($data);
        Session::put('message','Contact Added Succesfully');
    	return Redirect::to('/addcontact');

    }

//delete contact

    public function delete_contact($id)
    {
        DB::table('users')
                -> where('id',$id)
                ->delete();
        Session::put('message', 'Delete contact Succesfully');
        return Redirect::to('/allcontact');
    }

    //edit contact

    public function edit_contact($id)
    {
       $contact_info= DB::table('users')
                -> where('id',$id)
                ->first();
                

               // echo "</pre>";
               // print_r($contact_info);
        //Session::put('message', 'Delete contact Succesfully');
        //return Redirect::to('/allcontact');

                $mang_contact=view('contact_edit')
                        ->with('all_contact',$contact_info);

                return view('layout')
                ->with('contact_edit',$mang_contact);
    }
//contact update


    public function contact_update(Request $request,$id)
    {
        $data = array();
        $data['contact_name'] =$request->contact_name;
        $data['contact_number'] =$request->contact_number;

        DB::table('users')
        ->where('id',$id)
        ->update($data);

          //echo "</pre>";
                //print_r($data);
                //echo "</pre>";
        Session::put('message','Contact Updated Succesfully');
        return Redirect::to('/allcontact');
    }


}
