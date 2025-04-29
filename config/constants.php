<?php
return [
    'LOGIN_SESSION_TIME_OUT'=> 1,

    'response_message' => [
      '500' => [
        'msg' => 'An error occured while processing your request. Please refresh the page and try again.',
        'msgType' => 'error',
        'msgTitle' => 'Error!'
      ],
      '401' => [
        'msg' => 'Session Expired, Please Login',
        'msgType' => 'error',
        'msgTitle' => 'Error!'
      ],
      '403' => [
        'msg' => 'You do not have access rights this resource.',
        'msgType' => 'error',
        'msgTitle' => 'Access Denied'
      ],
    ]
];
