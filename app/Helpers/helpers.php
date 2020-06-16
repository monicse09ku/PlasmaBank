<?php

/**
 * Predefined Messages
 */
define('SUCCESS', 'Successfully created');
define('FAIL', 'Failed to create');
define('UPDATE_SUCCESS', 'Successfully updated');
define('UPDATE_FAIL', 'Failed to update');
define('SERVER_ERROR', 'Internal server error!');
define('DELETE_SUCCESS', 'Successfully deleted');
define('DELETE_FAIL', 'Failed to delete');
define('UNAUTHORIZED', 'These credentials do not match our records.');
define('PERMISSION_DENIED', 'Insufficient Permissions!');
define('PAGINATE_LIMIT', 10);

/**
 * Flash message with label
 * @Param String $message
 * @param String $level ='info'
 * @Return null
 */
if (!function_exists('flash')) {
    function flash($message, $level = 'success', $important = false)
    {
        session()->flash('flash_message', $message);
        session()->flash('flash_message_level', $level);
        session()->flash('flash_important', $important);
    }
}

/**
 * Remove spaces from string
 */
if (!function_exists('removeSpace')) {
    function removeSpace($str)
    {
        return preg_replace('/\s+/', '', $str);
    }
}

/**
 * Common json response with datas
 */
if (!function_exists('respond')) {
    function respond($data, $key = 'data', $code = 200, $status = true)
    {
        return response()->json([
            'success' => $status,
            "{$key}" => $data,
        ], $code);
    }
}

/**
 * Common json success response
 */
if (!function_exists('respondSuccess')) {
    function respondSuccess($message, $code = 200, $status = true)
    {
        return response()->json([
            'success' => $status,
            'message' => $message
        ], $code);
    }
}

/**
 * Common json error response
 */
if (!function_exists('respondError')) {
    function respondError($message, $code = 500, $status = false)
    {
        return response()->json([
            'success' => $status,
            'message' => $message
        ], $code);
    }
}

/**
 * Generate Menu Urls
 */
if (!function_exists('generateNavUrl')) {
    function generateNavUrl($route, $url, $hasSubNav = null)
    {
        if ($hasSubNav) {
            return 'javascript:';
        }

        $url = removeSpace($url);
        $route = removeSpace($route);

        if (($url == 'null' || empty($url) || !$url) && ($route == 'null' || empty($route) || !$route)) {
            return 'javascript:';
        }
        return ($url == 'null' || empty($url) || !$url) ? route($route) : url($url);
    }
}

/**
 * Date Format
 */
if (!function_exists('dateFormat')) {
    function dateFormat($date, $format = 'l, d F Y')
    {
        return date($format, strtotime($date));
    }
}

/**
 * get admin email
 */
if (!function_exists('getAdminEmail')) {
    function getAdminEmail()
    {
        return \App\Models\User::where('role', 'admin')->select('email')->first()->email ?? 'abc@gmail.com';
    }
}

/**
 * get cc emails
 */
if (!function_exists('ccEmails')) {
    function ccEmails()
    {
        $ccEmails = [];
        $user = auth()->user();
        if ($user->isTrainer()) {
            if ($supervisor = $user->parent) {
                if ($approver = $supervisor->parent) {
                    $ccEmails[] = $approver->email;
                }
                $ccEmails[] = $supervisor->email;
            }
        } else {
            if ($observer = $user->parent) {
                $ccEmails[] = $observer->email;
            }
        }

        return $ccEmails;
    }
}

/**
 * event report cc emails
 */
if (!function_exists('ccEmailsForReport')) {
    function ccEmailsForReport()
    {
        $ccEmails = [];
        $user = auth()->user();
        if ($user->isTrainer()) {
            if ($supervisor = $user->parent) {
                $ccEmails[] = $supervisor->email;
            }
        } elseif ($user->isSupervisor()) {
            if ($approver = $user->parent) {
                $ccEmails[] = $approver->email;
            }
        }

        return $ccEmails;
    }
}

if (!function_exists('ownershipStatuses')) {
    function ownershipStatuses()
    {
        return [
            'Owner',
            'Rented',
            'Leased'
        ];
    }
}

if (!function_exists('installationYears')) {
    function installationYears()
    {
        $years = [];

        for ($i = 0; $i < 40; $i++) {
            $new_year = date('Y', strtotime('-' . $i . ' year'));
            array_push($years, $new_year);
        }
        return $years;
    }
}

if (!function_exists('getInstallationHeaderByRole')) {
    function getInstallationHeaderByRole()
    {
        $headers = 'Ownership, Install Year, Facility, System Used, Monitoring, Fire, Status';

        if(auth()->user()->isManager()) {
            $headers .= ', User';
        }

        if(auth()->user()->isAdmins()) {
            $headers .= ', User, Observer';
        }

        return $headers . ', ';
    }
}

