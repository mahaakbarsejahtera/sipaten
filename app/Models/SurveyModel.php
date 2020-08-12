<?php 

namespace App\Models;

use CodeIgniter\Model;

class SurveyModel extends Model
{
    protected $table = "survey";
    protected $primaryKey = "id_survey";
    
    protected $allowedFields = [
        'id_permintaan', 'survey_user', 'survey_approve_status', 'survey_approve_by'
    ];

    protected $orderby = [
        'id_permintaan', 'permintaan_status', 'permintaan_status',
        'date_create'
    ];

    protected $filterby = [
        'survey_user' => 'survey.survey_user',
        'survey_approve_status' => 'survey.survey_approve_status',
        'survey_approve_by' => 'survey.survey_approve_by'
    ];



}   