<?php

namespace App\Controllers\Api;

use App\Models\UsersModel;
use CodeIgniter\Controller;

class Timeline extends Controller
{

    public function __construct() {
        
    }

    public function show( $id ) 
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new usersModel)
            ->builder()
            ->join('roles', 'users.user_role=roles.id_role', 'left')
            ->join('divisi', 'users.user_divisi=divisi.id_divisi', 'left')
            ->find( $id );

        if($find) {
            $response['data']       = $find;
            $response['code']       = 200;
            $response['message']    = 'Success';
        }

        return $this->response->setJson($response);

    }

    public function index()
    {

        $response = [
            'data'      => [], 
            'errors'    => [],
            'code'      => 200, 
            'message'   => '' 
        ];
        
        $links = (new \App\Models\TimelineLinksModel())->findAll();
        $tasks = (new \App\Models\TimelineTasksModel())->findAll();

       
        foreach($tasks as $task) 
        {

            $task['start_date']     = (new \DateTime($task['start_date']))->format('d-m-Y');
            $task['end_date']       = (new \DateTime($task['end_date']))->format('d-m-Y');
            $tempTasks[] = $task;

        }

        $response['data']['links'] = $links;
        $response['data']['tasks'] = $tempTasks;
        

        return $this->response->setJson($response);
    }

    public function addTask()
    {

        $response = [
            'data'      => [], 
            'errors'    => [],
            'code'      => 200, 
            'message'   => '' 
        ];

        
        // $rules = [];

    
        // if(!$this->validate($rules))
        // {

        //     $response['code']       = 400;
        //     $response['message']    = 'Bad Request';
        //     $response['errors']     = $this->validator->getErrors();
        //     return $this->response->setJson($response);

        // }

        $insertData = [
            'text'          => $this->request->getPost('text'),
            'start_date'    => (new \DateTime($this->request->getPost('start_date')))->format('Y-m-d'),
            'end_date'      => (new \DateTime($this->request->getPost('end_date')))->format('Y-m-d'),
            'duration'      => $this->request->getPost('duration'),
            'progress'      => $this->request->getPost('progress'),
            'parent'        => $this->request->getPost('parent'),
            'budget'        => $this->request->getPost('budget'),
        ];

        $this->response->setJSON($insertData);

        $model = new \App\Models\TimelineTasksModel();
        $model->save($insertData);

        $response['code']       = 200;
        $response['data']       = $this->request->getPost();
        //$response['data'] = $insertData;
        $response['message']    = 'Insert Success';

        return $this->response->setJson($response);



    }

    public function updateTask( $id )
    {

        $response = [
            'data'      => [], 
            'errors'    => [],
            'code'      => 200, 
            'message'   => '' 
        ];


        // $rules = [];

    
        // if(!$this->validate($rules))
        // {

        //     $response['code']       = 400;
        //     $response['message']    = 'Bad Request';
        //     $response['errors']     = $this->validator->getErrors();
        //     return $this->response->setJson($response);

        // }

        $insertData = [
            'id'            => $id,
            'text'          => $this->request->getPost('text'),
            'start_date'    => (new \DateTime($this->request->getPost('start_date')))->format('Y-m-d'),
            'end_date'      => (new \DateTime($this->request->getPost('end_date')))->format('Y-m-d'),
            'duration'      => $this->request->getPost('duration'),
            'progress'      => $this->request->getPost('progress'),
            'parent'        => $this->request->getPost('parent'),
            'budget'        => $this->request->getPost('budget'),
        ];

        $model = new \App\Models\TimelineTasksModel();
        $model->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        //$response['data'] = $insertData;
        $response['message']    = 'Update Success';

        return $this->response->setJson($response);
    }

    public function deleteTask($id)
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new \App\Models\TimelineTasksModel())->find( $id );
        if($find) {

            (new \App\Models\TimelineTasksModel())->delete($id);

            $response = [
                'code'      => 200,
                'data'      => $find,
                'message'   => 'Success',
                'errors'    => []
            ];

        }

        

        return $this->response->setJson($response);
    }

    public function addLink()
    {

        $response = [
            'data'      => [], 
            'errors'    => [],
            'code'      => 200, 
            'message'   => '' 
        ];


        $rules = [];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'source'    => $this->request->getPost('source'),
            'target'    => $this->request->getPost('target'),
            'type'      => $this->request->getPost('type')
        ];

        $this->response->setJSON($insertData);

        $model = new \App\Models\TimelineLinksModel();
        $model->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        //$response['data'] = $insertData;
        $response['message']    = 'Insert Success';

        return $this->response->setJson($response);



    }

    public function updateLink( $id )
    {

        $response = [
            'data'      => [], 
            'errors'    => [],
            'code'      => 200, 
            'message'   => '' 
        ];


        $rules = [];

    
        if(!$this->validate($rules))
        {

            $response['code']       = 400;
            $response['message']    = 'Bad Request';
            $response['errors']     = $this->validator->getErrors();
            return $this->response->setJson($response);

        }

        $insertData = [
            'id'        => $id,
            'source'    => $this->request->getPost('source'),
            'target'    => $this->request->getPost('target'),
            'type'      => $this->request->getPost('type')
        ];

        $model = new \App\Models\TimelineLinksModel();
        $model->save($insertData);

        $response['code']       = 200;
        $response['data']       = $insertData;
        //$response['data'] = $insertData;
        $response['message']    = 'Update Success';

        return $this->response->setJson($response);
    }

    public function deleteLink($id)
    {

        $response = [
            'code'          => 0,
            'message'       =>'',
            'data'          => [],
            'errors'        => []
        ];

        $find = (new \App\Models\TimelineLinksModel())->find( $id );
        if($find) {

            (new \App\Models\TimelineLinksModel())->delete($id);

            $response = [
                'code'      => 200,
                'data'      => $find,
                'message'   => 'Success',
                'errors'    => []
            ];

        }

        

        return $this->response->setJson($response);
    }



}