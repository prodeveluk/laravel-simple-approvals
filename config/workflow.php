<?php

use Prodevel\Laravel\Workflow\Models\Approval;

return [
    'prodevel-simple-approval'     => [
        'type'          => 'state_machine',
        'marking_store' => [
            'type'      => 'single_state',
            'arguments' => ['outcome']
        ],
        'supports'      => [Approval::class],
        'places'        => [
            Approval::OUTCOME_APPROVED,
            Approval::OUTCOME_PENDING,
            Approval::OUTCOME_REJECTED,
        ],
        'transitions'   => [
            Approval::ACTION_APPROVE  => [
                'from' => Approval::OUTCOME_PENDING,
                'to'   => Approval::OUTCOME_APPROVED
            ],
            Approval::ACTION_REJECT  => [
                'from' => Approval::OUTCOME_PENDING,
                'to'   => Approval::OUTCOME_REJECTED
            ]
        ]
    ],
];
