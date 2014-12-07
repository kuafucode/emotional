<?php
use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class SentryUser extends SentryUserModel  {
    public function getFullnameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
