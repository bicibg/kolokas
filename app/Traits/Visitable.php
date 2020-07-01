<?php


namespace App\Traits;


use App\Models\Visit;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait Visitable
 * @package App
 */
trait Visitable
{
    public function visit()
    {
        $visit = [
            'session_id' => request()->getSession()->getId(),
            'ip' => request()->getClientIp(),
            'agent' => request()->header('User-Agent'),
            'user_id' => auth()->id()
        ];
        if (!$this->isVisited()) {
            return $this->visits()->create($visit);
        }
    }

    /**
     * @return bool
     */
    public function isVisited()
    {
        return !!$this->visits->where('session_id', request()->getSession()->getId())->count();
    }

    /**
     * @return MorphMany
     */
    public function visits()
    {
        return $this->morphMany(Visit::class, 'visited');
    }

    /**
     * @return int
     */
    public function getVisitsCountAttribute()
    {
        return $this->visits->count();
    }

    /**
     * @return bool
     */
    public function getIsVisitedAttribute()
    {
        return $this->isVisited();
    }
}
