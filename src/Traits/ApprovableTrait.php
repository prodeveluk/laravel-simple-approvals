<?php

namespace Prodevel\Laravel\Workflow\Traits;

use Prodevel\Laravel\Workflow\Models\Approval;

/**
 * Trait ApprovableTrait
 * @package Prodevel\Laravel\Workflow\Traits
 */
trait ApprovableTrait {

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }

    /**
     * Check if this model needs an approval.
     * @return mixed
     */
    public function needsApproval()
    {
        return $this->approvals()->where('outcome', 'pending')->exists();
    }

    /**
     * Get the current approval
     * @return null|Approval
     */
    public function currentApproval() : bool
    {
        return $this->approvals()->where('outcome', 'pending')
        ->orderBy('created_at')
        ->first();
    }

    /**
     * Determine if workflows can be skipped for this model. Used internally for blocking workflow.
     * @return false
     */
    public function canSkip() : bool
    {
        return false;
    }

    /**
     * Raise a new approval for this model.
     * @param mixed $approver The model that needs to approve.
     * @return Approval
     */
    public function raiseApproval($approver)
    {
        $approval = new Approval(['outcome' => Approval::OUTCOME_PENDING]);
        $approval->approvable()->associate($this);
        $approval->approver()->associate($approver);
        $approval->save();
        return $approval;
    }
}
