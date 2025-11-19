<?php

namespace App\Services;

use App\Exceptions\BusinessRuleException;
use App\Models\Lending;
use Illuminate\Support\Carbon;

class LendingService
{
    /**
     * Lend a book to a friend.
     *
     * Business rules:
     * - Can't lend a book that's already lent out (unreturned)
     * - Due date must be in the future (also checked in FormRequest)
     */
    public function lend(array $data): Lending
    {
        // 1. Check if this book is already lent out (return_at is still null)
        $alreadyLent = Lending::where('book_id', $data['book_id'])
            ->whereNull('return_at')
            ->exists();

        if ($alreadyLent) {
            throw new BusinessRuleException('This book is already lent out.');
        }

        // 2. Extra date safety checks
        $lentAt = Carbon::parse($data['lent_at']);
        $dueAt  = Carbon::parse($data['due_at']);

        if ($dueAt->lt($lentAt)) {
            throw new BusinessRuleException('Due date must be after or equal to lent date.');
        }

        if ($dueAt->lte(Carbon::today())) {
            throw new BusinessRuleException('Due date must be in the future.');
        }

        // 3. Create lending record
        return Lending::create([
            'book_id'   => $data['book_id'],
            'friend_id' => $data['friend_id'],
            'lent_at'   => $lentAt->format('Y-m-d'),
            'due_at'    => $dueAt->format('Y-m-d'),
            'return_at' => null,
        ]);
    }

    /**
     * Mark a lending as returned.
     *
     * Business rule:
     * - Can't mark as returned if return date is before lent date
     */
    public function markReturned(Lending $lending, ?string $returnAt = null): Lending
    {
        // Prevent double-return
        if ($lending->return_at !== null) {
            throw new BusinessRuleException('This lending is already marked as returned.');
        }

        $lentAt   = Carbon::parse($lending->lent_at);
        $returnAt = $returnAt ? Carbon::parse($returnAt) : Carbon::today();

        // Rule: return date cannot be before lent date
        if ($returnAt->lt($lentAt)) {
            throw new BusinessRuleException('Return date cannot be before lent date.');
        }

        // Save return date
        $lending->return_at = $returnAt->format('Y-m-d');
        $lending->save();

        return $lending;
    }
}
