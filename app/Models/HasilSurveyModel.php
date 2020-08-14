<?php 

namespace App\Models;

use CodeIgniter\Model;

class HasilSurveyModel extends Model
{
    
    protected $table = "hasil_survey";
    protected $primaryKey = "id_survey_item";
    
    protected $allowedFields = [
        'id_survey', 'survey_item_name', 'survey_item_qty',
        'survey_item_unit', 'survey_harga_pokok', '	survey_harga_jual',
        'survey_harga_pokok_nego', 'survey_harga_jual_nego'
    ];

    protected $orderby = [
        'id_survey_item', 'id_survey', 'survey_item_name',
        'survey_item_qty', 'survey_item_unit', 'survey_harga_pokok',
        'survey_harga_jual', 'survey_harga_pokok_nego','survey_harga_jual_nego'
    ];

    protected $filterby = [
        'id_survey_item' => 'hasil_survey.id_survey_item',
        'id_survey' => 'hasil_survey.id_survey',
        'survey_item_name' => 'hasil_survey.survey_item_name',
        'survey_item_qty' => 'hasil_survey.survey_item_qty',
        'survey_item_unit' => 'hasil_survey.survey_item_unit',
        'survey_harga_pokok' => 'hasil_survey.survey_harga_pokok',
        'survey_harga_jual'=> 'hasil_survey.survey_harga_jual',
        'survey_harga_pokok_nego' => 'hasil_survey.survey_harga_pokok_nego',
        'survey_harga_jual_nego' => 'hasil_survey.survey_harga_jual_nego'
    ];



}   