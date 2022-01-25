<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\AppPermission;
use App\Enums\AppRole;
use Illuminate\Database\Seeder;
use Maklad\Permission\Models\Permission;
use Maklad\Permission\Models\Role;

class AclSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $adminRole = Role::create([
            'name' => AppRole::ADMIN->value,
            'display_name' => 'Administrator',
            'description' => 'Administrator role',
        ]);

        $staffRole = Role::create([
            'name' => AppRole::STAFF->value,
            'display_name' => 'Staff',
            'description' => 'Staff role',
        ]);

        $userRole = Role::create([
            'name' => AppRole::USER->value,
            'display_name' => 'User',
            'description' => 'User role',
        ]);

        // Create permissions
        $permissionListUsers = Permission::create([
            'name' => AppPermission::LIST_USERS->value,
            'display_name' => 'List Users',
            'description' => 'List Users',
        ]);

        $permissionViewUser = Permission::create([
            'name' => AppPermission::VIEW_USER->value,
            'display_name' => 'View User',
            'description' => 'View User',
        ]);

        $permissionCreateUser = Permission::create([
            'name' => AppPermission::CREATE_USER->value,
            'display_name' => 'Create User',
            'description' => 'Create User',
        ]);

        $permissionUpdateUser = Permission::create([
            'name' => AppPermission::UPDATE_USER->value,
            'display_name' => 'Update User',
            'description' => 'Update User',
        ]);

        $permissionDeleteUser = Permission::create([
            'name' => AppPermission::DELETE_USER->value,
            'display_name' => 'Delete User',
            'description' => 'Delete User',
        ]);

        $permissionCreateMovie = Permission::create([
            'name' => AppPermission::CREATE_MOVIE->value,
            'display_name' => 'Create Movie',
            'description' => 'Create Movie',
        ]);

        $permissionUpdateMovie = Permission::create([
            'name' => AppPermission::UPDATE_MOVIE->value,
            'display_name' => 'Update Movie',
            'description' => 'Update Movie',
        ]);

        $permissionDeleteMovie = Permission::create([
            'name' => AppPermission::DELETE_MOVIE->value,
            'display_name' => 'Delete Movie',
            'description' => 'Delete Movie',
        ]);

        $permissionCreateHall = Permission::create([
            'name' => AppPermission::CREATE_HALL->value,
            'display_name' => 'Create Hall',
            'description' => 'Create Hall',
        ]);

        $permissionUpdateHall = Permission::create([
            'name' => AppPermission::UPDATE_HALL->value,
            'display_name' => 'Update Hall',
            'description' => 'Update Hall',
        ]);

        $permissionDeleteHall = Permission::create([
            'name' => AppPermission::DELETE_HALL->value,
            'display_name' => 'Delete Hall',
            'description' => 'Delete Hall',
        ]);

        $permissionListOptions = Permission::create([
            'name' => AppPermission::LIST_OPTIONS->value,
            'display_name' => 'List Options',
            'description' => 'List Options',
        ]);

        $permissionCreateOption = Permission::create([
            'name' => AppPermission::CREATE_OPTION->value,
            'display_name' => 'Create Option',
            'description' => 'Create Option',
        ]);

        $permissionUpdateOption = Permission::create([
            'name' => AppPermission::UPDATE_OPTION->value,
            'display_name' => 'Update Option',
            'description' => 'Update Option',
        ]);

        $permissionDeleteOption = Permission::create([
            'name' => AppPermission::DELETE_OPTION->value,
            'display_name' => 'Delete Option',
            'description' => 'Delete Option',
        ]);

        $permissionCreateShow = Permission::create([
            'name' => AppPermission::CREATE_SHOW->value,
            'display_name' => 'Create Show',
            'description' => 'Create Show',
        ]);

        $permissionUpdateShow = Permission::create([
            'name' => AppPermission::UPDATE_SHOW->value,
            'display_name' => 'Update Show',
            'description' => 'Update Show',
        ]);

        $permissionDeleteShow = Permission::create([
            'name' => AppPermission::DELETE_SHOW->value,
            'display_name' => 'Delete Show',
            'description' => 'Delete Show',
        ]);

        $permissionListTickets = Permission::create([
            'name' => AppPermission::LIST_TICKETS->value,
            'display_name' => 'List Tickets',
            'description' => 'List Tickets',
        ]);

        $permissionViewTicket = Permission::create([
            'name' => AppPermission::VIEW_TICKET->value,
            'display_name' => 'View Ticket',
            'description' => 'View Ticket',
        ]);

        $permissionCreateTicket = Permission::create([
            'name' => AppPermission::CREATE_TICKET->value,
            'display_name' => 'Create Ticket',
            'description' => 'Create Ticket',
        ]);

        $permissionUpdateTicket = Permission::create([
            'name' => AppPermission::UPDATE_TICKET->value,
            'display_name' => 'Update Ticket',
            'description' => 'Update Ticket',
        ]);

        $permissionDeleteTicket = Permission::create([
            'name' => AppPermission::DELETE_TICKET->value,
            'display_name' => 'Delete Ticket',
            'description' => 'Delete Ticket',
        ]);

        $permissionUserTickets = Permission::create([
            'name' => AppPermission::USER_TICKETS->value,
            'display_name' => 'User Tickets',
            'description' => 'User Tickets',
        ]);

        $permissionCurrentProfile = Permission::create([
            'name' => AppPermission::CURRENT_PROFILE->value,
            'display_name' => 'Current Profile',
            'description' => 'Current Profile',
        ]);

        $permissionLogout = Permission::create([
            'name' => AppPermission::LOGOUT->value,
            'display_name' => 'Logout',
            'description' => 'Logout',
        ]);

        $permissionBookTicket = Permission::create([
            'name' => AppPermission::BOOK_TICKET->value,
            'display_name' => 'Book Ticket',
            'description' => 'Book Ticket',
        ]);

        $permissionBookingHistory = Permission::create([
            'name' => AppPermission::BOOKING_HISTORY->value,
            'display_name' => 'Booking History',
            'description' => 'Booking History',
        ]);

        // Assign Permissions to Roles
        $userRole->syncPermissions([
            $permissionLogout,
            $permissionBookTicket,
            $permissionBookingHistory,
            $permissionCurrentProfile,
            $permissionUserTickets
        ]);

        $staffRole->syncPermissions([
            $permissionListUsers,
            $permissionViewUser,
            $permissionCreateUser,
            $permissionUpdateUser,
            $permissionDeleteUser,
            $permissionCreateMovie,
            $permissionUpdateMovie,
            $permissionDeleteMovie,
            $permissionCreateHall,
            $permissionUpdateHall,
            $permissionDeleteHall,
            $permissionListOptions,
            $permissionCreateShow,
            $permissionUpdateShow,
            $permissionDeleteShow,
            $permissionListTickets,
            $permissionViewTicket,
            $permissionCreateTicket,
            $permissionUpdateTicket,
            $permissionDeleteTicket,
        ]);

        $adminRole->syncPermissions([
            $permissionCreateOption,
            $permissionUpdateOption,
            $permissionDeleteOption,
        ]);
    }
}
