<?php
use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class SentryUser extends SentryUserModel  {
    public function getFullnameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getPositiveFaceAttribute()
    {
        if(!$this->attributes['positive_face']) {
            return 'images/face/positive.png';
        }
        return $this->attributes['positive_face'];
    }

    public function getNegativeFaceAttribute()
    {
        if(!$this->attributes['negative_face']) {
            return 'images/face/negative.png';
        }
        return $this->attributes['negative_face'];
    }

    public function getNeutralFaceAttribute()
    {
        if(!$this->attributes['neutral_face']) {
            return 'images/face/neutral.png';
        }
        return $this->attributes['neutral_face'];
    }

    public function getLanguagesAttribute()
    {
        if(!$this->attributes['languages']) {
            return 'en';
        }
        return $this->attributes['languages'];
    }
}
