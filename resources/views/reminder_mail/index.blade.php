<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
        .body-wrap {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            box-sizing: border-box;
            font-size: 16px;
            width: 100%;
            margin: 0;
        }

        .container {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            box-sizing: border-box;
            font-size: 16px;
            vertical-align: top;
            display: block !important;
            max-width: 600px !important;
            clear: both !important;
            margin: 0 auto;
        }

        .content-wrap {
            padding: 20px;
        }

        .content {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            box-sizing: border-box;
            font-size: 16px;
            max-width: 600px;
            display: block;
            margin: 0 auto;
            padding: 20px;
        }

        .main {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            box-sizing: border-box;
            font-size: 16px;
            border-radius: 3px;
            background-color: #fff;
            margin: 0;
            border: 1px solid #e9e9e9;
        }

        .content-block {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            box-sizing: border-box;
            font-size: 16px;
            vertical-align: top;
            margin: 0;
            padding: 0 0 20px;
        }
        b{
            color:black;
        }
    </style>
</head>
<body style="height:100vh; background-color:#f6f6f6 !important">
    <div class="d-flex align-items-center h-100">
        <table class="body-wrap">
            <tr>
                <td></td>
                <td class="container">
                    <div class="content">
                        <table class="main" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="content-wrap">
                                    {{-- <h4>{{ getSettingData()['application_name'] }}</h4> --}}
                                    <div class="d-flex justify-content-center">
                                        <img src="{{ getSettingData()['logo'] }}" class="img-fluid" height="55px"
                                            width="55px" alt="{{getSettingData()['application_name']}}">
                                    </div>
                                    <p class="text-primary">{{__('messages.reminder_mail.hello')}} {{ $name ?? ''}}</p>
                                    <p class="text-secondary">{{ __('messages.reminder_mail.friendly_reminder')}} <b>{{ getSettingData()['application_name'] }}</b> {{__('messages.reminder_mail.coming_up_shortly')}}</p>
                                    <h6 class="text-secondary">{{__('messages.reminder_mail.event_details'). ':'}}</h6>
                                    <ul >
                                        <li>{{__('messages.reminder_mail.event_name'). ':'}} <b>{{ $eventName ?? ''}}</b></li>
                                        <li>{{__('messages.reminder_mail.date'). ':'}} <b>{{ $scheduleDate ?? '' }}</b></li>
                                        <li>{{__('messages.reminder_mail.schedule_time'). ':'}}  <b>{{ $scheduleTime ?? '' }}</b></li>
                                    </ul>
                                    <p class="text-secondary">{{ __('messages.reminder_mail.looking_forward')}}</p>
                                    <p class="text-secondary"{{__('messages.reminder_mail.any_questions_or_need_assistance')}}</p>
                                    <p class="text-secondary">
                                        <span>{{__('messages.reminder_mail.best_regards')}}</span><br>
                                        {{ getSettingData()['application_name'].' '. __('messages.reminder_mail.team')}}
                                    </p>
                                    <div class="d-flex justify-content-center">
                                        <p class="text-primary">© {{ date('Y') }}
                                            {{ getSettingData()['application_name'] }}. All rights reserved.</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td></td>
            </tr>
        </table>
    </div>
</body>
</html>
