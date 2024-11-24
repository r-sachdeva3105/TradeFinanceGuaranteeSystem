<?php

namespace App\Http\Controllers;

use App\Models\Guarantee;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    // Show the Applicant's Dashboard
    public function applicantDashboard()
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            // Get guarantees for the logged-in user (Applicant)
            $guarantees = Guarantee::where('user_id', auth()->id())->get(); // Get guarantees for the logged-in user

            // Check if there are no guarantees
            $message = $guarantees->isEmpty() ? "You haven't created any guarantees yet." : null;

            return view('dashboard.applicant', compact('guarantees', 'message'));
        }

        // If the user is not authenticated, redirect them to login page
        return redirect()->route('login');
    }

    // Show the Admin's Dashboard
    public function adminDashboard()
    {
        $users = User::count();
        $guarantees = Guarantee::count();
        return view('dashboard.admin', compact('users', 'guarantees'));
    }
}
