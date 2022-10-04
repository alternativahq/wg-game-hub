<?php

namespace App\Models;

use App\Models\Concerns\HasUUID;
use Illuminate\Database\Eloquent\Model;

class BlacklistedNotification extends Model
{
    use HasUUID;

    protected $primaryKey = 'idempotency_id';
    protected $guarded = [];

    public const UPDATED_AT = null;
}
