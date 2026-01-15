<?php 
namespace Kitoko\VisitorTracker\Models;

use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'visitor_id',
        'url',
        'referer',
        'visited_at',
    ];
}
