<?php

namespace Prodevel\Laravel\Workflow\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prodevel\Laravel\Workflow\Contracts\CanApprove;
use Prodevel\Laravel\Workflow\Models\Approval;

/**
 * Trait ApproverTrait
 * @package Prodevel\Laravel\Workflow\Traits
 */
trait ApprovableTrait {

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
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
    public function currentApproval()
    {
        return $this->approvals()->where('outcome', 'pending')
        ->orderBy('created_at')
        ->first();
    }

    /**
     * Determine if workflows can be skipped for this model. Used internally for blocking workflow.
     * @return bool
     */
    public function canSkip()
    {
        return config('approvals.can_skip', false);
    }

    /**
     * Raise a new approval for this model.
     * @param CanApprove|Collection $approver The model that needs to approve.
     * @return Approval|Collection
     */
    public function raiseApproval($approver)
    {
        if($approver instanceof Model) {
            return $this->raiseApprovalForApprover($approver);
        }

        if($approver instanceof Collection) {
            $approvals = $approver->map(function ($approvingUser) {
                return $this->raiseApprovalForApprover($approvingUser);
            });

            return $approvals;
        }

    }

    /**
     * Internal function to create approval instance.
     *
     * @param CanApprove $approver
     * @return Approval
     */
    private function raiseApprovalForApprover($approver)
    {
        $approval = new Approval(['outcome' => Approval::OUTCOME_PENDING]);
        $approval->approvable()->associate($this);
        $approval->approver()->associate($approver);
        $approval->save();
        return $approval;
    }
}
