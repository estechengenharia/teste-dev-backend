<?php

use Illuminate\Support\Facades\Cache;

if(!function_exists('cacheClear')){
    /**
     * @param  array $keys
     * @return void
     * clear eloquent cache
     */
    function cacheClear(array $keys){
        try {
            if(count($keys) > 0){
                foreach($keys as $key){
                    Cache::forget($key);
                }
            }
        } catch (\Throwable $th) {
            return null;
        }
    }
}