<?php

namespace Prodevel\Laravel\Workflow\Models;

use Illuminate\Database\Eloquent\Builder;
use ZeroDaHero\LaravelWorkflow\Traits\WorkflowTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Approval class
 *
 * @property string $outcome
 * @property string $decision_date
 * @property mixed $approvable
 * @property mixed $approver
 */
class Approval extends Model
{
    use WorkflowTrait;

    const OUTCOME_APPROVED = 'approved';
    const OUTCOME_REJECTED = 'rejected';
    const OUTCOME_PENDING = 'pending';

    const ACTION_APPROVE = 'approve';
    const ACTION_REJECT = 'reject';

    protected $fillable = ['outcome'];

    public function pristine()
    {
        return empty($this->decision_date);
    }

    /**
     * Get an instance of the model to be approved.
     *
     * @return MorphTo|null
     */
    public function approvable()
    {
        return $this->morphTo();
    }

    /**
     * Get an instance of the model that is approving.
     *
     * @return MorphTo|null;
     */
    public function approver()
    {
        return $this->morphTo();
    }

    /**
     * Approve this approval
     *
     * @param $approver
     * @return void
     */
    public function approve($approver)
    {
        if($approver) {
            $this->approver()->associate($approver);
        }
        $this->workflow_apply(self::ACTION_APPROVE);
        $this->save();
    }

    /**
     * Reject this approval
     *
     * @param $approver
     * @return void
     */
    public function reject($approver = null)
    {
        if($approver) {
            $this->approver()->associate($approver);
        }
        $this->workflow_apply(self::ACTION_REJECT);
        $this->save();
    }

    /**
     * Get pending approovals
     * @param Builder $builder
     * @return Builder
     */
    public function scopePending(Builder $builder)
    {
        return $builder->where('outcome', self::OUTCOME_PENDING);
    }

    /**
     * Get rejected approvals
     * @param Builder $builder
     * @return Builder
     */
    public function scopeRejected(Builder $builder)
    {
        return $builder->where('outcome', self::OUTCOME_REJECTED);
    }

    /**
     * Get approved approvalss
     * @param Builder $builder
     * @return Builder
     */
    public function scopeApproved(Builder $builder)
    {
        return $builder->where('outcome', self::OUTCOME_APPROVED);
    }
}
