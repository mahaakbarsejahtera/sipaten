<?php 

namespace App\Models;

use CodeIgniter\Model;

class TimelineTasksModel extends Model
{
    protected $table = "timeline_tasks";
    protected $primaryKey = "id";
    
    protected $allowedFields = [
        'text', 'start_date', 'end_date', 'duration', 'progress', 'parent'
    ];

    protected $orderby = [
        'id', 'text', 'duration',
        'progress', 'parent'
    ];

    protected $filterby = [
    ];



}   