<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    public function complete()
    {
        $this->is_completed =  true;
        $this->save();
    }

    public function uncomplete()
    {
        $this->is_completed = false;
        $this->save();
    }


}
