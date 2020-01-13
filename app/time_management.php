<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class time_management extends Model
{
    public function scopeIdDescending($query,$subject)
    {
        return $query->orderBy($subject,'DESC');
    } 

    public function scopeIdAscending($query,$subject)
    {
        return $query->orderBy($subject,'ASC');
    }

    public function scopeWhereUser($query, $subject, $id)
    {
        return $query->where($subject, $id);
    }

    public function scopeWhereWithOperators($query, $subject, $operators, $id)
    {
        return $query->where($subject, $operators, $id);    
    }

    public function scopeInsertUser($query, $data)
    {
        return $query->insert($data);
    }

    public function users()
    {	
        return $this->belongsTo(User::class);
    }

    public function scopeSetRemarksAttribute($value)
    {
        $this->attributes['remarks'] = $value != "" ? $value : null;
    }
}
