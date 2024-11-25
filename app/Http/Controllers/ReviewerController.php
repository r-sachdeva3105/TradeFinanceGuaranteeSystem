<?php

namespace App\Http\Controllers;

use App\Models\Guarantee;
use Illuminate\Http\Request;

class ReviewerController extends Controller
{
    // Display the pending guarantees in the reviewer dashboard
    public function reviewerDashboard()
    {
        // Get all guarantees that are 'pending' for review
        $guarantees = Guarantee::where('status', 'pending')->get();

        return view('dashboard.reviewer', compact('guarantees'));
    }

    // View all pending guarantees for review
    public function reviewerIndex()
    {
        // Get all guarantees that are 'pending'
        $guarantees = Guarantee::where('status', 'pending')->get();

        return view('reviewer.guarantees', compact('guarantees'));
    }

    // Approve or reject a guarantee
    public function updateGuarantee(Request $request, $id)
    {
        // Find the guarantee by ID
        $guarantee = Guarantee::findOrFail($id);

        // Handle the approval or rejection logic
        if ($request->has('approve')) {
            $guarantee->status = 'approved';
            $guarantee->save();
            return redirect()->route('reviewer.guarantees')->with('success', 'Guarantee approved.');
        }

        if ($request->has('reject')) {
            $guarantee->status = 'rejected';
            $guarantee->remarks = $request->input('remarks'); // Add remarks if rejected
            $guarantee->save();
            return redirect()->route('reviewer.guarantees')->with('success', 'Guarantee rejected.');
        }

        return redirect()->route('reviewer.guarantees')->with('error', 'Invalid action.');
    }
}

