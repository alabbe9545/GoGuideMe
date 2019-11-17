<?php

namespace GoGuideMe;

use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
	use \Phaza\LaravelPostgis\Eloquent\PostgisTrait;

	protected $postgisFields = [
        'location'
    ];

    protected $postgisTypes = [
        'location' => [
            'geomtype' => 'geography',
            'srid' => 4326
        ]
    ];

    public function zone(){
    	return $this->belongsTo('GoGuideMe\Zone');
    }
}
