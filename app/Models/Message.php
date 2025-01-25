<?php

namespace App\Models;

use App\Models\Conversation;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'user_id',
        'message',
    ];

    protected $appends = ['get_created_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function getCreatedAt(): Attribute
    {
        return Attribute::get(
            fn() => $this->created_at->format('d-m-Y H:i:s')
        );
    }
}
