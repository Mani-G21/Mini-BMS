<?php

namespace App\Domain\Show\Validators\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class NoShowOverlap implements Rule
{
    private $startTime;
    private $endTime;
    private $theaterId;
    private $showId; // For update case

    public function __construct($theaterId, $startTime, $endTime, $showId = null)
    {
        $this->theaterId = $theaterId;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->showId = $showId;
    }

    public function passes($attribute, $value)
    {
        $query = DB::table('shows')
            ->where('theater_id', $this->theaterId)
            ->where('status', 'active')
            ->where(function ($q) {
                $q->where('start_time', '<', $this->endTime)
                    ->where('end_time', '>', $this->startTime);
            });

        if ($this->showId) {
            $query->where('id', '!=', $this->showId);
        }

        return !$query->exists();
    }

    public function message()
    {
        return 'Another show is already scheduled in this theater during the selected time.';
    }
}
