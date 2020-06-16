<?php

namespace App\Models;

trait HasRole
{
    /**
     * Check User has role
     * @param  string | Array  $role
     * @return boolean
     */
    public function hasRole($role)
    {
        if (is_null($role) || empty($role)) {
            return false;
        }

        $roles = explode(':', $this->role);

        if (is_string($role)) {
            if (!$roles) {
                return false;
            }

            return in_array($role, $roles);
        }

        if (is_array($role)) {
            foreach ($role as $r) {
                if ($this->hasRole($r)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check user has super-admin role
     * @return boolean
     */
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check user has admin role
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAdmins() {
        return $this->isSuperAdmin() ?: $this->isAdmin();
    }

    public function isDonor() {
        return $this->role === 'bidder';
    }

    /**
     * check is logged in user is active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}
