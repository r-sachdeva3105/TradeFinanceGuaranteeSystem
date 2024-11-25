<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{
    use HasFactory;

    // Add the necessary fields for mass assignment
    protected $fillable = [
        'corporate_reference_number',
        'guarantee_type',
        'nominal_amount',
        'nominal_amount_currency',
        'expiry_date',
        'applicant_name',
        'applicant_address',
        'beneficiary_name',
        'beneficiary_address',
        'user_id', // ID of the applicant
        'status', // Status of the guarantee: pending, approved, rejected
        'reviewer_id', // ID of the reviewer handling this guarantee
        'remarks', // Optional remarks from the reviewer
    ];

    /**
     * Relationship with the User model (applicant).
     */
    public function applicant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship with the User model (reviewer).
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * Check if the guarantee is pending review.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Approve the guarantee.
     */
    public function approve()
    {
        $this->update([
            'status' => 'approved',
            'remarks' => 'Approved by reviewer.',
        ]);
    }

    /**
     * Reject the guarantee with a custom remark.
     */
    public function reject(string $remarks)
    {
        $this->update([
            'status' => 'rejected',
            'remarks' => $remarks,
        ]);
    }
}
