<?php 

namespace App\Models;

use CodeIgniter\Model;

class TimelineLinksModel extends Model
{
    protected $table = "timeline_links";
    protected $primaryKey = "id";
    
    protected $allowedFields = [
        'id', 'source', 'target', 'type'
    ];

    protected $orderby = [
        'id', 'source', 'target', 'type'
    ];

    protected $filterby = [
    ];



}   