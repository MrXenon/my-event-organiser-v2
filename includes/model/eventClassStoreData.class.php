<?php
require_once (MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR. '/eventClassTables.class.php');
class eventStoreData{
    public function __construct(){
        $this->Tables       = new eventTables();
    }

    private function TablePrefix(){return $this->Tables->TablePrefix();}
    private function EventTypeTable(){return $this->Tables->EventTypeTable();}
    private function EventCategoryTable(){return $this->Tables->EventCategoryTable();}
    private function EventTable(){return $this->Tables->EventTable();}
    private function EventSignupTable(){return $this->Tables->EventSignupTable();}

    public function save($input_array){
        try {
            if($input_array['p'] == 'meo_admin_event_apply_list'){
                $array_fields = array('gebruiker','titel');
            }else{
                $array_fields = array( 'name', 'description');
            }
            $data_array = array();

            foreach( $array_fields as $field){

                if (!isset($input_array[$field])){
                    throw new Exception(__("$field is mandatory for update."));
                }
                $data_array[] = $input_array[$field];
            }
            global $wpdb;
            if($input_array['p'] == 'meo_admin_event_apply_list'){

            $wpdb->query($wpdb->prepare("INSERT INTO `". $this->EventSignupTable()."` ( `event_title`, `event_user`)".
            " VALUES ( '%s', '%s');",$input_array['titel'],
            $input_array['gebruiker']) );
            }elseif($input_array['p'] == 'meo_admin_event_category'){
            $wpdb->query($wpdb->prepare("INSERT INTO `". $this->EventCategoryTable()."` ( `name`, `description`)".
                " VALUES ( '%s', '%s');",$input_array['name'],
                $input_array['description']) );
            }else{
                $wpdb->query($wpdb->prepare("INSERT INTO `". $this->EventTypeTable()."` ( `name`, `description`)".
                " VALUES ( '%s', '%s');",$input_array['name'],
                $input_array['description']) );
            }

            if ( !empty($wpdb->last_error) ){
                $this->last_error = $wpdb->last_error;
                return FALSE;
            }

        } catch (Exception $exc) {
            echo '<pre>'. $exc->getTraceAsString() .'</pre>';
        }
    return TRUE;
}


public function update($input_array){
    try {
        if($input_array['p'] == 'meo_admin_event_apply_list'){
            $array_fields = array('id','gebruiker','titel');
        }else{
            $array_fields = array('id', 'name', 'description');
        }
        $data_array = array();

        foreach( $array_fields as $field){

            if (!isset($input_array[$field])){
                throw new Exception(__("$field is mandatory for update."));
            }

            $data_array[] = $input_array[$field];
        }
        global $wpdb;
        if($input_array['p'] == 'meo_admin_event_apply_list'){
        $wpdb->query($wpdb->prepare("UPDATE ".$this->EventSignupTable()."
        SET `event_title` = '%s', `event_user` = '%s' ".
            "WHERE `".$this->EventSignupTable()."`.`id` =%d;",$input_array['titel'],
            $input_array['gebruiker'], $input_array['id']) );
        }elseif($input_array['p'] == 'meo_admin_event_category'){
            $wpdb->query($wpdb->prepare("UPDATE ".$this->EventCategoryTable()."
        SET `name` = '%s', `description` = '%s' ".
            "WHERE `".$this->EventCategoryTable()."`.`id_event_category` =%d;",$input_array['name'],
            $input_array['description'], $input_array['id']) );
        }else{
            $wpdb->query($wpdb->prepare("UPDATE ".$this->EventTypeTable()."
        SET `name` = '%s', `description` = '%s' ".
            "WHERE `".$this->EventTypeTable()."`.`id_event_type` =%d;",$input_array['name'],
            $input_array['description'], $input_array['id']) );
        }
    } catch (Exception $exc) {

        echo $exc->getTraceAsString();
        $this->last_error = $exc->getMessage();
        return FALSE;
    }
    return TRUE;
}


public function delete($input_array){
    try {
        if (!isset($input_array['id']) ) throw new Exception(__("Missing mandatory fields") );
        global $wpdb;

        if($input_array['p'] == 'meo_admin_event_apply_list'){
        $wpdb->delete( $this->EventSignupTable(),
            array( 'id' => $input_array['id'] ),
            array( '%d' ) );
        }elseif($input_array['p'] == 'meo_admin_event_category'){
            $wpdb->delete( $this->EventCategoryTable(),
            array( 'id_event_category' => $input_array['id'] ),
            array( '%d' ) );
        }else{
            $wpdb->delete( $this->EventTypeTable(),
            array( 'id_event_type' => $input_array['id'] ),
            array( '%d' ) );
        }
        if ( !empty($wpdb->last_error) ){
            throw new Exception( $wpdb->last_error);
        }
    } catch (Exception $exc) {
    }

    return TRUE;
}

    public function handleGetAction( $get_array ){
        $action = '';
    
        switch($get_array['action']){
            case 'update':

                if ( !is_null($get_array['id']) ){
                    $action = $get_array['action'];
                }
                break;
    
            case 'delete':

                if ( !is_null($get_array['id']) ){
                    $this->delete($get_array);
                }
                $action = 'delete';
                break;
    
            default:

                    break;
        }
        return $action;
    }

    public function getGetValues(){

        $get_check_array = array (

            'action' => array('filter' => FILTER_SANITIZE_STRING ),


            'id' => array('filter' => FILTER_VALIDATE_INT ));


        $inputs = filter_input_array( INPUT_GET, $get_check_array );

        return $inputs;

    }

}
?>