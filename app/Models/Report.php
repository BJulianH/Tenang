<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reporter_id',
        'reportable_id',
        'reportable_type',
        'reason',
        'additional_info',
        'status',
        'admin_notes',
        'resolved_by',
        'resolved_at',
        'severity',
        'evidence'
    ];

    protected $casts = [
        'evidence' => 'array',
        'resolved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke user yang melaporkan
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    // Relasi polymorphic ke model yang dilaporkan (Post, Comment, User, dll)
    public function reportable()
    {
        return $this->morphTo();
    }

    // Relasi ke admin yang menyelesaikan laporan
    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    // Scope untuk laporan pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope untuk laporan resolved
    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    // Scope untuk laporan berdasarkan severity
    public function scopeSeverity($query, $severity)
    {
        return $query->where('severity', $severity);
    }

    // Scope untuk laporan hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Scope untuk laporan dalam 7 hari terakhir
    public function scopeLast7Days($query)
    {
        return $query->where('created_at', '>=', now()->subDays(7));
    }

    // Method untuk resolve laporan
    public function markAsResolved($adminId, $notes = null)
    {
        $this->update([
            'status' => 'resolved',
            'resolved_by' => $adminId,
            'resolved_at' => now(),
            'admin_notes' => $notes
        ]);
    }

    // Method untuk dismiss laporan
    public function markAsDismissed($adminId, $notes = null)
    {
        $this->update([
            'status' => 'dismissed',
            'resolved_by' => $adminId,
            'resolved_at' => now(),
            'admin_notes' => $notes
        ]);
    }

    // Method untuk reopen laporan
    public function reopen()
    {
        $this->update([
            'status' => 'pending',
            'resolved_by' => null,
            'resolved_at' => null,
            'admin_notes' => null
        ]);
    }

    // Cek apakah laporan masih pending
    public function isPending()
    {
        return $this->status === 'pending';
    }

    // Cek apakah laporan sudah resolved
    public function isResolved()
    {
        return $this->status === 'resolved';
    }

    // Cek apakah laporan sudah dismissed
    public function isDismissed()
    {
        return $this->status === 'dismissed';
    }

    // Accessor untuk type yang dilaporkan
    public function getReportableTypeNameAttribute()
    {
        $types = [
            'App\Models\Post' => 'Post',
            'App\Models\Comment' => 'Comment',
            'App\Models\User' => 'User',
            'App\Models\Community' => 'Community',
        ];

        return $types[$this->reportable_type] ?? class_basename($this->reportable_type);
    }

    // Accessor untuk severity color
    public function getSeverityColorAttribute()
    {
        $colors = [
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'critical' => 'red'
        ];

        return $colors[$this->severity] ?? 'gray';
    }

    // Accessor untuk status color
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'yellow',
            'resolved' => 'green',
            'dismissed' => 'gray'
        ];

        return $colors[$this->status] ?? 'gray';
    }

    // Method untuk membuat laporan baru
    public static function createReport($reporterId, $reportable, $reason, $additionalInfo = null, $severity = 'medium')
    {
        return self::create([
            'reporter_id' => $reporterId,
            'reportable_id' => $reportable->id,
            'reportable_type' => get_class($reportable),
            'reason' => $reason,
            'additional_info' => $additionalInfo,
            'severity' => $severity,
            'status' => 'pending'
        ]);
    }
}