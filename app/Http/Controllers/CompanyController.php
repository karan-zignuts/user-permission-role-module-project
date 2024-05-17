<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $editBtn = Auth::user()->hasUserAccess(1.1, 'edit');
        $deleteBtn = Auth::user()->hasUserAccess(1.1, 'delete');
        $createBtn = Auth::user()->hasUserAccess(1.1, 'create');

        $search = $request->input('search');
        $companies = Company::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%");
            })->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(6);

        return view('/contact/company/company_index', compact('companies', 'editBtn', 'deleteBtn', 'createBtn'));
    }

    public function create()
    {
        return view('/contact/company/company_create');
    }
    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
        ]);

        // Create new company
        Company::create([
            'name' => $request->name,
            'owner_name' => $request->owner_name,
            'address' => $request->address,
            'industry' => $request->industry,
            'user_id' => Auth::User()->id,
        ]);

        return redirect()->route('companies.index')->with('success', 'Company created successfully!');
    }

    public function edit(Company $company)
    {
        return view('/contact/company/company_edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $company->fill($request->all());
        $company->user_id = Auth::user()->id;
        $company->save();
        return redirect()->route('companies.index');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index');
    }
}
