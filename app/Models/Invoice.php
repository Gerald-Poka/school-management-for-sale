<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    // Add these constants to define valid statuses
    const STATUS_PENDING = 'pending';
    const STATUS_PARTIAL = 'partial';
    const STATUS_PAID = 'paid';

    protected $fillable = [
        'student_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'status',
        'note',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class)->withDefault([
            'name' => 'Unknown Student',
            'registration_number' => 'N/A'
        ]);
    }

    public function getStudentNameAttribute(): string
    {
        return $this->student->name ?? 'Unknown Student';
    }

    public function getStudentRegAttribute(): string
    {
        return $this->student->registration_number ?? 'N/A';
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function getTotalAmountAttribute(): float
    {
        return $this->items->sum('amount');
    }

    public function getPaidAmountAttribute(): float
    {
        return $this->payments()->sum('amount') ?? 0.00;
    }

    public function getBalanceAttribute(): float
    {
        return $this->total_amount - $this->paid_amount;
    }

    public function getTotalPaidAttribute(): float
    {
        return $this->payments()
            ->where('status', 'approved')
            ->sum('amount');
    }

    public function getRemainingBalanceAttribute(): float
    {
        return max(0, $this->total_amount - $this->total_paid);
    }
}