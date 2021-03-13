<?php

use Prodevel\Laravel\Workflow\Models\Approval;

return [
    'prodevel-simple-approval'     => [
        'type'          => 'state_machine',
        'marking_store' => [
            'type'     => 'single_state', // or 'single_state', can be omitted to default to workflow type's default
            'property' => 'outcome', // this is the property on the model, defaults to 'marking'
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
