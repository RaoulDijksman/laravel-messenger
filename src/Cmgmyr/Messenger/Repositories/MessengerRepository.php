<?php

namespace Cmgmyr\Messenger\Repositories;

use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Tread;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;

class MessengerRepository
{

    function __construct()
    {
      # code...
    }

    public function getThread($threadId)
    {
        return Thread::find($threadId)->first();
    }

    public function getAllThreads()
    {
        return Thread::getAllLatest()->get();
    }

    public function getAllTreadsForUser($userId)
    {
        return Thread::forUser($userId)->get();
    }

    public function getUpdatedTreadsForUser($userId)
    {
        return Thread::ForUserWithNewMessages($userId)->get();
    }

    public function getThreadsBetweenUsers($participants)
    {
        return Thread::between($participants)->get();
    }

    public function createThread($userId, $recipients, $subject = null)
    {
        $thread = Thread::create([
            'subject' => $subject,
        ]);

        // Sender
        Participant::create([
            'thread_id' => $thread->id,
            'user_id'   => $userId,
            'last_read' => new Carbon,
        ]);

        // Recipients
        if (count($recipients)) {
            $thread->addParticipants($recipients);
        }
    }

}
