<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Guarantee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    // Display files upload page
    public function adminIndex()
    {
        // Retrieve all files from the database
        $files = File::all();
        return view('admin.files', compact('files'));
    }

    // File upload method
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,pdf|max:2048', // Validate file types and sizes
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->storeAs('uploads', $file->getClientOriginalName());

            // Save file details into database (optional)
            File::create([
                'name' => $file->getClientOriginalName(),
                'type' => $file->getClientMimeType(),
                'content' => file_get_contents($file), // Save file content as blob
            ]);

            return redirect()->route('admin.files')->with('success', 'File uploaded successfully!');
        }

        return redirect()->route('admin.files')->with('error', 'No file selected or an error occurred.');
    }

    // Parse the uploaded file
    public function parse($id)
    {
        $file = File::findOrFail($id);
        $path = storage_path('app/uploads/' . $file->name);

        // Parse CSV file
        if ($file->type == 'application/vnd.ms-excel' || $file->type == 'text/csv') {
            $csvData = array_map('str_getcsv', file($path));

            foreach ($csvData as $row) {
                if ($row[0] == 'corporate_reference_number') continue; // Skip header row

                // Insert data into guarantees table
                Guarantee::create([
                    'corporate_reference_number' => $row[0],
                    'guarantee_type' => $row[1],
                    'nominal_amount' => (float) $row[2], // Ensure valid decimal
                    'nominal_amount_currency' => $row[3],
                    'expiry_date' => $row[4],
                    'applicant_name' => $row[5],
                    'applicant_address' => $row[6],
                    'beneficiary_name' => $row[7],
                    'beneficiary_address' => $row[8],
                    'user_id' => $row[9],
                    'status' => 'pending', // Default status
                ]);
            }

            return redirect()->route('admin.files')->with('success', 'File parsed and data inserted successfully.');
        }

        return redirect()->route('admin.files')->with('error', 'Invalid file type for parsing.');
    }

    // Delete the uploaded file
    public function destroy($id)
    {
        $file = File::findOrFail($id);
        Storage::delete('uploads/' . $file->name);
        $file->delete();

        return redirect()->route('admin.files')->with('success', 'File deleted successfully.');
    }

    // Method to download the file
    public function download($id)
    {
        $file = File::findOrFail($id);
        return response()->download(storage_path('app/uploads/' . $file->name));
    }
}
