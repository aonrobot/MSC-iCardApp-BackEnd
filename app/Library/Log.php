<?php

namespace Library;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB as DB;

class Log{

    static public function write($event, $action_table, $action_id, $imei = '') {
        DB::connection('iCard')->table('log')->insertGetId(
            [
                'event' => $event,
                'action_table' => $action_table,
                'action_id' => $action_id,
                'imei' => $imei,
                'created_at' => Carbon::now()
            ]
        );
    }
    
}

