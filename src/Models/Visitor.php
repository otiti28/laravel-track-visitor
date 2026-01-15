<?php 
namespace Kitoko\VisitorTracker\Models;

use Illuminate\Database\Eloquent\Model;
use Kitoko\VisitorTracker\Models\PageVisit;

class Visitor extends Model
{
    protected $fillable = [
        'session_id',
        'ip',
        'user_agent',
        'browser',
        'platform',
        'user_id',
    ];

    public function pageVisits()
    {
        return $this->hasMany(PageVisit::class);
    }
}
