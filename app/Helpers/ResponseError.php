<?php

namespace App\Helpers;

class ResponseError
{
    public const NO_ERROR = 'OK'; // 'OK'
    public const ERROR_100 = 'ERROR_100'; // 'User is not logged in.'
    public const ERROR_101 = 'ERROR_101'; // 'User does not have the right roles.'
    public const ERROR_102 = 'ERROR_102'; // 'Bad credentials.'
    public const ERROR_103 = 'ERROR_103'; // 'User email address is not verified'
    public const ERROR_104 = 'ERROR_104'; // 'User phone number is not verified'
    public const ERROR_105 = 'ERROR_105'; // 'User account is not verified'

    public const ERROR_400 = 'ERROR_400'; // 'Bad request'
    public const ERROR_404 = 'ERROR_404'; // 'Item\'s not found.'
    public const ERROR_413 = 'ERROR_413'; // 'Undefined Type'

    public const ERROR_501 = 'ERROR_501'; // 'Error during created.'
    public const ERROR_502 = 'ERROR_502'; // 'Error during updated.'
    public const ERROR_503 = 'ERROR_503'; // 'Error during deleting.'
    public const ERROR_504 = 'ERROR_504'; // 'Can't delete record that has children.'
    public const ERROR_505 = 'ERROR_505'; // 'Can't delete default record.'
}
