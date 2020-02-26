<?php

namespace App\Http\Controllers\API;


use App\Http\Requests\API\CreateMemberAPIRequest;
use App\Http\Requests\API\UpdateMemberAPIRequest;
use App\Models\Member;
use App\Repositories\MemberRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class MemberController
 * @package App\Http\Controllers\API
 */
class MemberAPIController extends AppBaseController
{
    /** @var  MemberRepository */
    private $memberRepository;

    public function __construct(MemberRepository $memberRepo)
    {
        $this->memberRepository = $memberRepo;
    }

    /**
     * Display a listing of the Member.
     * GET|HEAD /members
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $members = $this->memberRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($members->toArray(), 'Members retrieved successfully');
    }

    public function rabbitMQ_Send(){
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('hello', false, false, false, false);
        $msg = new AMQPMessage('Hello World!');
        $channel->basic_publish($msg, '', 'hello');
        $channel->close();
        $connection->close();
        return  " [x] Sent 'Hello World!'\n";

    }

    public function rabbitMQ_receive(){
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };

        $channel->basic_consume('hello', '', false, true, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

    public function callBackRMQ($msg){
        echo ' [x] Received ', $msg->body, "\n";
    }

    /**
     * Store a newly created Member in storage.
     * POST /members
     *
     * @param CreateMemberAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateMemberAPIRequest $request)
    {
        $input = $request->all();

        $member = $this->memberRepository->create($input);

        return $this->sendResponse($member->toArray(), 'Member saved successfully');
    }

    /**
     * Display the specified Member.
     * GET|HEAD /members/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Member $member */
        $member = $this->memberRepository->find($id);

        if (empty($member)) {
            return $this->sendError('Member not found');
        }

        return $this->sendResponse($member->toArray(), 'Member retrieved successfully');
    }

    /**
     * Update the specified Member in storage.
     * PUT/PATCH /members/{id}
     *
     * @param int $id
     * @param UpdateMemberAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMemberAPIRequest $request)
    {
        $input = $request->all();

        /** @var Member $member */
        $member = $this->memberRepository->find($id);

        if (empty($member)) {
            return $this->sendError('Member not found');
        }

        $member = $this->memberRepository->update($input, $id);

        return $this->sendResponse($member->toArray(), 'Member updated successfully');
    }

    /**
     * Remove the specified Member from storage.
     * DELETE /members/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var Member $member */
        $member = $this->memberRepository->find($id);

        if (empty($member)) {
            return $this->sendError('Member not found');
        }

        $member->delete();

        return $this->sendSuccess('Member deleted successfully');
    }
}
