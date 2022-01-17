<?php

class AdminFixturesController extends MvcAdminController {

    var $default_columns = array(
        'id',
        'data'=>array('value_method'=>'admin_column_data'),
        'timezone',
        'timestamp'=>array('value_method' => 'admin_column_timestamp'),
        'active' => array('value_method' => 'admin_column_active')
    );
    public function admin_column_timestamp($object) {
        return empty($object->timestamp) ? null : date('d/m/Y H:i:s', $object->timestamp);
    }

    public function admin_column_data($object){
        if($object->data){
            $data = unserialize($object->data);
            return $data['teams']->home->name .' - '. $data['teams']->away->name;
        }
        return '';
    }

    public function admin_column_active($object){
        return $object->active == 1 ? 'Yes' : 'No';
    }

    public function index(){
        $this->load_helper('Datetime');
        $this->set_objects();
    }
}
