<?php

namespace Prodevel\Laravel\Workflow\Listeners;

use Illuminate\Contracts\Events\Dispatcher;
use Prodevel\Laravel\Workflow\Contracts\Approvable;
use Prodevel\Laravel\Workflow\Models\Approval;
use ZeroDaHero\LaravelWorkflow\Events\EnteredEvent;
use ZeroDaHero\LaravelWorkflow\Events\EnterEvent;
use ZeroDaHero\LaravelWorkflow\Events\GuardEvent;
use ZeroDaHero\LaravelWorkflow\Events\LeaveEvent;
use ZeroDaHero\LaravelWorkflow\Events\TransitionEvent;

class ApprovalWorkflowSubscriber
{
    /**
     * Handle workflow guard events.
     *
     * @param GuardEvent $event
     */
    public function onGuard(GuardEvent $event)
    {
        /** @var Approval $subject */
        $subject = $event->getSubject();

        /** @var Approvable $approvable */
        $approvable = $subject->approvable;
        if ($approvable->canSkip()) {
            $event->setBlocked(false);
            return;
        }

        if ($subject->outcome !== Approval::OUTCOME_PENDING) {
            $event->setBlocked(true);
            return;
        }
    }

    /**
     * Handle workflow leave event.
     * @param LeaveEvent $event
     */
    public function onLeave(LeaveEvent $event)
    {
    }

    /**
     * Handle workflow transition event.
     *
     * @param TransitionEvent $event TransitionEvent
     */
    public function onTransition(TransitionEvent $event)
    {
    }

    /**
     * Handle workflow enter event.
     *
     * @param EnterEvent $event
     */
    public function onEnter(EnterEvent $event)
    {
        $subject = $event->getSubject();
    }

    public function onEntered(EnteredEvent $event)
    {
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            'workflow.prodevel-simple-approval.guard',
            'Prodevel\Shapeup\Listeners\ApprovalWorkflowSubscriber@onGuard'
        );

        $events->listen(
            'workflow.prodevel-simple-approval.leave',
            'Prodevel\Laravel\Workflow\Listeners\ApprovalWorkflowSubscriber@onLeave'
        );

        $events->listen(
            'workflow.prodevel-simple-approval.transition',
            'Prodevel\Laravel\Workflow\Listeners\ApprovalWorkflowSubscriber@onTransition'
        );

        $events->listen(
            'workflow.prodevel-simple-approval.enter',
            'Prodevel\Laravel\Workflow\Listeners\ApprovalWorkflowSubscriber@onEnter'
        );

        $events->listen(
            'workflow.prodevel-simple-approval.entered',
            'Prodevel\Laravel\Workflow\Listeners\ApprovalWorkflowSubscriber@onEntered'
        );
    }
}
