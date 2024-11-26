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

    // Store a new guarantee
    public function store(Request $request)
    {
        $request->validate([
            'corporate_reference_number' => 'required|string',
            'guarantee_type' => 'required|string',
            'nominal_amount' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);

        // Store the new guarantee
        $guarantee = new Guarantee();
        $guarantee->corporate_reference_number = $request->corporate_reference_number;
        $guarantee->guarantee_type = $request->guarantee_type;
        $guarantee->nominal_amount = $request->nominal_amount;
        $guarantee->nominal_amount_currency = $request->nominal_amount_currency;
        $guarantee->expiry_date = $request->expiry_date;
        $guarantee->applicant_name = $request->applicant_name;
        $guarantee->applicant_address = $request->applicant_address;
        $guarantee->beneficiary_name = $request->beneficiary_name;
        $guarantee->beneficiary_address = $request->beneficiary_address;
        $guarantee->user_id = auth()->id(); // Assign the current user as the applicant
        $guarantee->status = 'pending'; // Default status
        $guarantee->save();

        return redirect()->route('guarantees.index')->with('success', 'Guarantee created successfully.');
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

    // Show the form to edit a guarantee
    public function edit($id)
    {
        $guarantee = Guarantee::findOrFail($id);

        // Check if the logged-in user is the owner of the guarantee
        if ($guarantee->user_id !== auth()->id()) {
            return redirect()->route('guarantees.index')->with('error', 'Unauthorized action.');
        }

        return view('guarantees.edit', compact('guarantee'));
    }

    // Update the guarantee
    public function update(Request $request, $id)
    {
        $request->validate([
            'corporate_reference_number' => 'required|string',
            'guarantee_type' => 'required|string',
            'nominal_amount' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);

        $guarantee = Guarantee::findOrFail($id);

        // Check if the logged-in user is the owner of the guarantee
        if ($guarantee->user_id !== auth()->id()) {
            return redirect()->route('guarantees.index')->with('error', 'Unauthorized action.');
        }

        // Update the guarantee
        $guarantee->update($request->all());

        return redirect()->route('guarantees.index')->with('success', 'Guarantee updated successfully.');
    }

    // Delete a guarantee
    public function destroy($id)
    {
        $guarantee = Guarantee::findOrFail($id);

        // Check if the logged-in user is the owner of the guarantee
        if ($guarantee->user_id !== auth()->id()) {
            return redirect()->route('guarantees.index')->with('error', 'Unauthorized action.');
        }

        $guarantee->delete();

        return redirect()->route('guarantees.index')->with('success', 'Guarantee deleted successfully.');
    }

    public function adminIndex()
    {
        $guarantees = Guarantee::all();
        $applicants = User::where('user_type', 'applicant')->get();
        return view('admin.guarantees', compact('guarantees', 'applicants'));
    }
}
