$lockKey = {{lock_key}};
        \App\Http\Locking::checkAndWait($lockKey);