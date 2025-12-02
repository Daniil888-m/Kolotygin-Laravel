<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Разрешаем массовое заполнение этих полей
    protected $fillable = ['text', 'articles_id', 'user_id'];

	public function user() {
		return $this->belongsTo(User::class);
	}
}
