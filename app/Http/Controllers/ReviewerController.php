<?php

namespace App\Http\Controllers;

use App\Models\Guarantee;
use Illuminate\Http\Request;

class ReviewerController extends Controller
{
    public function reviewerDashboard()
    {
        $guarantees = Guarantee::where('status', 'pending')->get();
        return view('dashboard.reviewer', compact('guarantees'));
    }

    public function show($id)
    {
        $guarantee = Guarantee::findOrFail($id);
        return view('reviewer.guarantees', compact('guarantee'));
    }

    public function updateGuarantee(Request $request, $id)
    {
        $guarantee = Guarantee::findOrFail($id);

        // Handle approval
        if ($request->has('approve')) {
            $guarantee->status = 'approved';
            $guarantee->remarks = null; // No remarks for approved guarantees
        }

        // Handle rejection
        if ($request->has('reject')) {
            $guarantee->status = 'rejected';
            $guarantee->remarks = $request->input('remarks', 'No remarks provided.');
        }

        $guarantee->save();

        return redirect()->route('dashboard.reviewer')->with('success', 'Guarantee updated successfully.');
    }
}
