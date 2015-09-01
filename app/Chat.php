<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
      'engineer_id',
      'suser',
      'customer_number',
      'installation_number',
      'system_id',
      'client',
      'logon_data',
      'email',
      'closed',
      'started',
      'ended',
      'issue_type',
      'has_incident'
    ];
}
