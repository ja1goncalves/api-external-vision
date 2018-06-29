<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    /**
     * @var string table Api Config
     */
    protected $table = 'api_logs';

    /**
     * @var array 'name','url','company','user','password'
     */
    protected $fillable = [
        'name',
        'info',
        'args'
    ];

    public function log($name, $info, $args) {
        return self::create([
            'name' => $name,
            'info' => $info,
            'args' => $args
        ]);
    }

}
