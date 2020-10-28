<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Datatables;

class CompanyCRUDController extends Controller
{
    public function index(){
        if(request()->ajax()) {
        return datatables()->of(Company::select('*'))
        ->addColumn('action', 'companies.action')
        ->rawColumns(['action'])
        ->addIndexColumn()
        ->make(true);
        }
        return view('companies.index');
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required',
        'email' => 'required',
        'address' => 'required'
        ]);
        $company = new Company;
        $company->name = $request->name;
        $company->email = $request->email;
        $company->address = $request->address;
        $company->save();
        return redirect()->route('companies.index')
        ->with('success','Company has been created successfully.');
    }

    public function show(Company $company)
    {
    return view('companies.show',compact('company'));
    } 
    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Company  $company
    * @return \Illuminate\Http\Response
    */
    public function edit(Company $company)
    {
    return view('companies.edit',compact('company'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'name' => 'required',
        'email' => 'required',
        'address' => 'required'
        ]);
        $company = Company::find($id);
        $company->name = $request->name;
        $company->email = $request->email;
        $company->address = $request->address;
        $company->save();
        return redirect()->route('companies.index')
        ->with('success','Company Has Been updated successfully');
    }

    public function destroy(Request $request)
    {
        $com = Company::where('id',$request->id)->delete();
        return Response()->json($com);
    }
}
