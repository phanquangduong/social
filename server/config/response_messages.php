<?php

return [
    'errors' => [
        'USER_ALREADY_EXISTS' => [
            'code'    => 50001,
            'message' => 'User has already registered',
            'status'  => 409,
        ],
        'USER_NOT_FOUND' => [
            'code'    => 50002,
            'message' => 'User not found',
            'status'  => 404,
        ],
        'EMAIL_INVALID' => [
            'code'    => 20003,
            'message' => 'Email is invalid',
            'status'  => 422,
        ],
        'INVALID_TOKEN' => [
            'code'    => 30001,
            'message' => 'Token is invalid',
            'status'  => 401,
        ],
        'OTP_NOT_EXISTS' => [
            'code'    => 30002,
            'message' => 'OTP does not exist or has expired',
            'status'  => 404,
        ],
        'INVALID_OTP' => [
            'code'    => 30003,
            'message' => 'OTP is invalid',
            'status'  => 400,
        ],
        'OTP_ALREADY_SENT' => [
            'code'    => 30004,
            'message' => 'OTP has already been sent. Please wait before requesting again.',
            'status'  => 429,
        ],
        'USER_OTP_NOT_EXISTS' => [
            'code'    => 60008,
            'message' => 'User OTP not exists',
            'status'  => 404,
        ],
        'OTP_NOT_VERIFIED' => [
            'code'    => 50003,
            'message' => 'User OTP not verified',
            'status'  => 400,
        ],
        'LOGIN_FAILED' => [
            'code'    => 40005,
            'message' => 'Wrong email or password',
            'status'  => 422,
        ],
        'OTP_VERIFIED_BUT_ACCOUNT_NOT_CREATED' => [
            'code'    => 60001,
            'message' => 'OTP has been verified, but the account has not been created.',
            'status'  => 409,
        ],
        'UNAUTHENTICATED' => [
            'code'    => 40001,
            'message' => 'Unauthenticated',
            'status'  => 401
        ],
        'UNAUTHORIZED' => [
            'code'    => 40003,
            'message' => 'You are not authorized to perform this action',
            'status'  => 403,
        ],
        'INCORRECT_PASSWORD' => [
            'code'    => 50004,
            'message' => 'The password is incorrect',
            'status'  => 400,
        ],
        'CANNOT_SEND_REQUEST_TO_SELF' => [
            'code'    => 40002,
            'message' => 'You cannot send a friend request to yourself',
            'status'  => 400,
        ],
        'ALREADY_FRIENDS' => [
            'code'    => 30005,
            'message' => 'The users are already friends',
            'status'  => 400,
        ],
        'REQUEST_ALREADY_SENT' => [
            'code'    => 30006,
            'message' => 'A friend request has already been sent',
            'status'  => 400,
        ],
        'FRIEND_REQUEST_NOT_FOUND' => [
            'code'    => 30007,
            'message' => 'Friend request not found or already handled',
            'status'  => 404,
        ],
        'NOT_FRIENDS' => [
            'code'    => 30008,
            'message' => 'You are not friends with this user',
            'status'  => 400,
        ],

        'CANNOT_UNFRIEND_SELF' => [
            'code'    => 30009,
            'message' => 'You cannot unfriend yourself',
            'status'  => 400,
        ],
    ],

    'success' => [
        'REGISTER_SUCCESS' => [
            'code'    => 20001,
            'message' => 'Success',
            'status'  => 200,
        ],
    ],
];
