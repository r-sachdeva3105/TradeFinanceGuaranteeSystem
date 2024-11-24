<?php

namespace App\Http\Controllers;

use App\Models\Guarantee;
use Illuminate\Http\Request;

class GuaranteeController extends Controller
{
    // Show the Applicant's Guarantees (only their own guarantees)
    public function index()
    {
        $guarantees = Guarantee::where('user_id', auth()->id())->get(); // Only fetch guarantees for the logged-in user
        return view('guarantees.index', compact('guarantees'));
    }

    // Show form to create a new Guarantee
    public function create()
    {
        return view('guarantees.create');
    }

    // Store a newly created Guarantee
    public function store(Request $request)
    {
        $validated = $request->validate([
            'corporate_reference_number' => 'required|unique:guarantees',
            'expiry_date' => 'required|date|after:today',
            // More validation rules here...
        ]);

        // Save the guarantee with the logged-in user's ID
        $guarantee = new Guarantee($validated);
        $guarantee->user_id = auth()->id();  // Link guarantee to the logged-in user
        $guarantee->save();

        return redirect()->route('dashboard')->with('success', 'Guarantee created.');
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

    // Delete the specified Guarantee
    public function destroy($id)
    {
        $guarantee = Guarantee::findOrFail($id);

        // Ensure the logged-in user can only delete their own guarantee
        if ($guarantee->user_id != auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $guarantee->delete();

        return redirect()->route('dashboard')->with('success', 'Guarantee deleted.');
    }

    // Show all Guarantees for Admin (Admin can see all)
    public function adminIndex()
    {
        $guarantees = Guarantee::all(); // Admin sees all guarantees
        return view('admin.guarantees', compact('guarantees'));
    }
}
