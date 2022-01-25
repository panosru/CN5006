<?php

declare(strict_types=1);

namespace App\Enums;

enum AppPermission: string
{
    case LIST_USERS = 'list users';
    case VIEW_USER = 'view user';
    case CREATE_USER = 'create user';
    case UPDATE_USER = 'update user';
    case DELETE_USER = 'delete user';
    case USER_TICKETS = 'user tickets';
    case CURRENT_PROFILE = 'current profile';
    case LOGOUT = 'logout';
    case BOOKING_HISTORY = 'booking history';

    CASE CREATE_MOVIE = 'create movie';
    CASE UPDATE_MOVIE = 'update movie';
    CASE DELETE_MOVIE = 'delete movie';

    CASE CREATE_HALL = 'create hall';
    CASE UPDATE_HALL = 'update hall';
    CASE DELETE_HALL = 'delete hall';

    case LIST_OPTIONS = 'list options';
    CASE CREATE_OPTION = 'create option';
    CASE UPDATE_OPTION = 'update option';
    CASE DELETE_OPTION = 'delete option';

    CASE CREATE_SHOW = 'create show';
    CASE UPDATE_SHOW = 'update show';
    CASE DELETE_SHOW = 'delete show';

    case LIST_TICKETS = 'list tickets';
    case VIEW_TICKET = 'view ticket';
    CASE CREATE_TICKET = 'create ticket';
    CASE UPDATE_TICKET = 'update ticket';
    CASE DELETE_TICKET = 'delete ticket';
    case BOOK_TICKET = 'book ticket';
}
