<?php
namespace DTApi\Helpers;

use Carbon\Carbon;
use DTApi\Models\Job;
use DTApi\Models\User;
use DTApi\Models\Language;
use DTApi\Models\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TeHelper
{
    public static function fetchLanguageFromJobId($id)
    {
        return Language::findOrFail($id)->value('language');
    }

    public static function getUsermeta($user_id, $key = false)
    {
        return $user = UserMeta::where('user_id', $user_id)->first()->$key;
        if (!$key)
            return $user->usermeta()->get()->all();
        else {
            $meta = $user->usermeta()->where('key', '=', $key)->get()->first();
            if ($meta)
                return $meta->value;
            else return '';
        }
    }

    public static function convertJobIdsInObjs($jobs_ids)
    {
        $ids = $jobs_ids->pluck('id');
        return Job::find($ids);
    }

    public static function willExpireAt($due_time, $created_at)
    {
        $due_time = Carbon::parse($due_time);
        $created_at = Carbon::parse($created_at);

        $difference = $due_time->diffInHours($created_at);

        $time = match ($difference) {
            $difference<=90 => $due_time,
            $difference <= 24 =>  $created_at->addMinutes(90),
            $difference > 24 && $difference <= 72 => $created_at->addMinutes(16),
            default =>  $due_time->subHours(48),
        };
       
        return $time->format('Y-m-d H:i:s');

    }

}

