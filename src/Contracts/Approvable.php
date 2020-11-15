<?php

namespace Prodevel\Laravel\Workflow\Contracts;

use Prodevel\Laravel\Workflow\Models\Approval;

interface Approvable {
    public function canSkip();
    public function needsApproval();
    public function currentApproval();
    public function approvals();
}
