<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::where('status', 'active');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->country) {
            $query->where('country', $request->country);
        }

        $companies = $query->latest()->paginate(12);
        $countries = Company::where('status', 'active')->distinct()->pluck('country')->filter()->sort()->values();

        return view('frontend.companies.index', compact('companies', 'countries'));
    }

    public function show(Company $company)
    {
        if ($company->status !== 'active') {
            abort(404);
        }
        $products = $company->products()->published()->take(6)->get();

        return view('frontend.companies.show', compact('company', 'products'));
    }
}
