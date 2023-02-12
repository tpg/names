<?php

namespace TPG\Names\Client;

enum ResponseCode: int
{
    case Successful = 200;
    case BadRequest = 400;
    case Unauthorized = 401;
    case Forbidden = 403;
    case NotFound = 404;
    case MethodNotAllowed = 405;
    case NotAcceptable = 406;
    case Gone = 410;
    case TooManyRequests = 429;
    case InternalServerError = 500;
    case ServiceUnavailable = 503;
}
