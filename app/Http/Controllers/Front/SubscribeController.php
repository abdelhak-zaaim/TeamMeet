<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateSubscribeRequest;
use App\Models\Subscribe;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class SubscribeController extends AppBaseController
{
    /**
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        return view('subscribers.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSubscribeRequest $request): JsonResponse
    {
        $input = $request->all();
        $subscribe = Subscribe::create([
            'email' => setEmailLowerCase($input['email']),
            'subscribe' => Subscribe::SUBSCRIBE,
        ]);

        return $this->sendSuccess(__('messages.success_message.subscribed_successfully'));
    }

    public function destroy(Subscribe $subscribe): JsonResponse
    {
        $subscribe->delete();

        return $this->sendSuccess(__('messages.success_message.subscriber_deleted_successfully'));
    }
}
