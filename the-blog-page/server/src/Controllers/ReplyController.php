<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Models\Reply;
use App\DTOs\Reply\CreateReplyData;
use ErrorException;

class ReplyController
{
    private Reply $reply;

    public function __construct()
    {
        $this->reply = new Reply();
    }

    public function createReply(Request $request) 
    {
        $body = $request->getBody();

        $userId = $body['userId'];
        $commentId = $body['commentId'];
        $content = $body['content'];

        $replyData = new CreateReplyData($userId, $commentId, $content);

        try {
            $result = $this->reply->create($replyData);

            if ($result) {
                $reply = $this->reply->getReplyById($result);

                return [
                    'success' => 1,
                    'message' => 'Successfully created a reply',
                    'data' => [
                        'id' => $reply['reply_id'],
                        'content' => $reply['content'],
                        'user' => [
                            'firstName' => $reply['first_name'],
                            'lastName' => $reply['last_name']
                        ],
                        'createdAt' => $reply['created_at'],
                        'updatedAt' => $reply['updated_at']
                    ]
                ];
            }

            return [
                'success' => 0,
                'message' => 'Cannot create reply'
            ];
        } catch (ErrorException $err) {
            return [
                'body' => [
                    'message' => 'Internal server error',
                    'success' => 0
                ],
                'code' => 500
            ];
        }
    }
}