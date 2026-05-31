<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->paginate(15);
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $data = $request->all();
        $data['slug'] = Str::slug($request->name) . '-' . time();
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('companies', 'public');
        }
        Company::create($data);
        return redirect()->route('admin.companies.index')->with('success', 'Company created successfully.');
    }

    public function show(Company $company)
    {
        $company->load('products');
        return view('admin.companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $data = $request->all();
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('companies', 'public');
        }
        $company->update($data);
        return redirect()->route('admin.companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('admin.companies.index')->with('success', 'Company deleted successfully.');
    }
}
