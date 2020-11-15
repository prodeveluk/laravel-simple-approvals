<?php

namespace Prodevel\Laravel\Workflow\Traits;

use Prodevel\Laravel\Workflow\Models\Approval;

/**
 * Trait ApprovableTrait
 * @package Prodevel\Laravel\Workflow\Traits
 */
trait ApproverTrait {

    public function approvals()
    {
        return $this->morphMany(Approval::class);
    }

}
