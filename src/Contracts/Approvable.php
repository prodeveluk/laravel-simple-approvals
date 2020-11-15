<?php

namespace Prodevel\Laravel\Workflow\Contracts;

use Prodevel\Laravel\Workflow\Models\Approval;

interface Approvable {
    public function canSkip() : bool;
    public function needsApproval() : bool;
    public function currentApproval() : Approval;
    public function approvals();
}
