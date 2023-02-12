<?php

namespace TPG\Names;

enum ReturnCode: int
{
    case NotAvailable = 0;
    case Success = 1;
    case PendingActionSuccessful = 2;
    case ItemNotPendingAction = 4;
    case InvalidLoginCredentials = 6;
    case AuthenticationError = 7;
    case AssociationProhibitsOperation = 8;
    case UnknownErrors = 9;
    case MissingParameter = 10;
    case ItemDoesNotExist = 11;
    case StatusProhibitsOperation = 12;
    case ItemAlreadyExists = 13;
    case CommandSyntaxError = 14;
    case UnknownCommand = 15;
    case DatabaseCallFailed = 16;
    case InternalError = 17;
    case ConnectionRefused = 18;
    case BillingFailure = 19;
    case RequestTimedOut = 20;
    case ConnectionFailedToProvider = 22;
}
