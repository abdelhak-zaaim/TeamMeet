<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class GoogleCalendarController
 */
class GoogleWebhookController extends AppBaseController
{
    public function webhook(Request $request)
    {
        $headers = $request->header();
        $resourceID = $request->header('x-goog-resource-id');
        $channelID = $request->header('x-goog-channel-id');

    }
}
