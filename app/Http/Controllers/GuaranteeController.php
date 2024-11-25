<?php

namespace App\Http\Controllers;

use App\Models\Guarantee;
use App\Models\User;
use Illuminate\Http\Request;

class GuaranteeController extends Controller
{
    public function index()
    {
        $guarantees = Guarantee::where('user_id', auth()->id())->get();
        return view('guarantees.index', compact('guarantees'));
    }

    public function create()
    {
        return view('guarantees.create');
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'corporate_reference_number' => 'required|string|max:255',
            'guarantee_type' => 'required|string|max:255',
            'nominal_amount' => 'required|numeric|min:0',
            'nominal_amount_currency' => 'required|string|max:255',
            'expiry_date' => 'required|date',
            'applicant_name' => 'required|string|max:255',
            'applicant_address' => 'required|string|max:255',
            'beneficiary_name' => 'required|string|max:255',
            'beneficiary_address' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        Guarantee::create($request->all());

        return redirect()->route('admin.guarantees')->with('message', 'Guarantee created successfully.');
    }

    // Show the form to edit a Guarantee
    public function edit($id)
    {
        $guarantee = Guarantee::findOrFail($id);
        // Ensure the logged-in user can only edit their own guarantee
        if ($guarantee->user_id != auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('guarantees.edit', compact('guarantee'));
    }

    // Update the specified Guarantee
    public function update(Request $request, $id)
    {
        $guarantee = Guarantee::findOrFail($id);

        // Ensure the logged-in user can only update their own guarantee
        if ($guarantee->user_id != auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'expiry_date' => 'required|date|after:today',
            // More validation rules here...
        ]);

        $guarantee->update($validated);

        return redirect()->route('dashboard')->with('success', 'Guarantee updated.');
    }

    public function destroy($id)
    {
        $guarantee = Guarantee::findOrFail($id);

        if ($guarantee->user_id != auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $guarantee->delete();

        return redirect()->route('dashboard')->with('success', 'Guarantee deleted.');
    }

    public function adminIndex()
    {
        $guarantees = Guarantee::all();
        $applicants = User::where('user_type', 'applicant')->get();
        return view('admin.guarantees', compact('guarantees', 'applicants'));
    }
}