<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    // Display a listing of the companies
    public function index(Request $request)
    {
        // Check user permissions for edit, delete, and create actions
        $editBtn = Auth::user()->hasUserAccess(1.1, 'edit');
        $deleteBtn = Auth::user()->hasUserAccess(1.1, 'delete');
        $createBtn = Auth::user()->hasUserAccess(1.1, 'create');

        // Get the search term from the request
        $search = $request->input('search');

        // Query companies, applying search filter if provided, and paginate the results
        $companies = Company::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%");
            })
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(6);

        // Return the company index view with the companies and user permissions
        return view('/contact/company/company_index', compact('companies', 'editBtn', 'deleteBtn', 'createBtn'));
    }

    // Show the form for creating a new company
    public function create()
    {
        return view('/contact/company/company_create');
    }

    // Store a newly created company in the database
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

        // Redirect to the companies index page
        return redirect()->route('companies.index')->with('success', 'Company created successfully!');
    }

    // Show the form for editing the specified company
    public function edit(Company $company)
    {
        return view('/contact/company/company_edit', compact('company'));
    }

    // Update the specified company in the database
    public function update(Request $request, Company $company)
    {
        // Fill the company with the request data and save it
        $company->fill($request->all());
        $company->user_id = Auth::user()->id;
        $company->save();

        // Redirect to the companies index page
        return redirect()->route('companies.index');
    }

    // Remove the specified company from the database
    public function destroy(Company $company)
    {
        // Delete the company
        $company->delete();

        // Redirect to the companies index page
        return redirect()->route('companies.index');
    }
}
