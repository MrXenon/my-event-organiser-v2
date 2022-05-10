<?php
/**
 * Description of EventList
 * 
 * @author Kevin Schuit
 */

 class EventList{

     /**
  * getPostValues : 
  * Filter input and retrieve POST input params
  *
  *@return array containing known POST input fields
  */
  public function getPostValues(){
      
    //Define the check for params
    $post_check_array = array (
        //Submit action
        'add' => array('filter' => FILTER_SANITIZE_STRING ),
        'update' => array('filter' => FILTER_SANITIZE_STRING ),

        //List all update form fields!!!
        //
        //Event type name
        'gebruiker' => array('filter' => FILTER_SANITIZE_STRING ),

        //Help text
        'eventTitel' => array('filter' => FILTER_SANITIZE_STRING),
        
        //Id of current row
        'id' => array('filter' => FILTER_VALIDATE_INT )
    );

    //Get filtered input: 
    $inputs = filter_input_array( INPUT_POST, $post_check_array );

    //RTS
    return $inputs;
  }

  private function getTableName(){

    global $wpdb;
    return $table = $wpdb->prefix . "meo_event"; 
}


private function getApplyTableName(){

    global $wpdb;
    return $table = $wpdb->prefix . "meo_event_signup"; 
}
    /**
     * 
     * @return int number of Event categories stored in db
     */
    public function getNrOfEvents(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `". $this->getTableName()."`";
        $result = $wpdb->get_results( $query, ARRAY_A);

        return $result[0] ['nr'];
    }

    public function getNrOfInschrijvingen(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `". $this->getApplyTableName()."`";
        $result = $wpdb->get_results( $query, ARRAY_A);

        return $result[0] ['nr'];
    }

    /**
     * 
     * @return type
     */
    public function getEventList() {

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->getTableName() . "` ORDER BY `id_event`", ARRAY_A);

        //For all database results:
        foreach ( $result_array as $idx => $array) {
            //New object
        $event = new EventList();
        //Set all info
        $event->setId($array['id_event']);
        $event->setTitle($array['event_title']);
        $event->setFkEventCategory($array['fk_event_category']);
        $event->setFkEventType($array['fk_event_type']);
        $event->setEventInfo($array['event_info']);
        $event->setEventDate($array['event_date']);
        $event->setEventDueDate($array['event_due_date']);
        $event->setEventEndDate($array['event_end_date']);

        //Add new object to return array
        $return_array[] = $event;
        }
        return $return_array;
    }

    public function getSignupList() {

        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM `". $this->getApplyTableName() . "` ORDER BY `id`", ARRAY_A);

        //For all database results:
        foreach ( $result_array as $idx => $array) {
            //New object
        $signup = new EventList();
        //Set all info
        $signup->setApplyId($array['id']);
        $signup->setApplyTitle($array['event_title']);
        $signup->setApplyUser($array['event_user']);
        //Add new object to return array
        $return_array[] = $signup;
        }
        return $return_array;
    }

    /**
     * @param type $id Id of the event category
     */
    public function setId( $id ) {
        if ( is_int(intval($id) ) ){
            $this->id = $id;
        }
    }
    public function setTitle( $title ) {
        if ( is_string($title )){
            $this->title = trim($title);
        }
    }
    public function setFkEventCategory( $fkEventCat ) {
        if ( is_string($fkEventCat )){
            $this->fkEventCat = trim($fkEventCat);
        }
    }
    public function setFkEventType( $fkEventType ) {
        if ( is_string($fkEventType )){
            $this->fkEventType = trim($fkEventType);
        }
    }
    public function setEventInfo( $eventInfo ) {
        if ( is_string($eventInfo )){
            $this->eventInfo = trim($eventInfo);
        }
    }
    public function setEventDate( $eventDate ) {
        if ( is_string($eventDate )){
            $this->eventDate = trim($eventDate);
        }
    }
    public function setEventDueDate( $eventDueDate ) {
        if ( is_string($eventDueDate )){
            $this->eventDueDate = trim($eventDueDate);
        }
    }
    public function setEventEndDate( $eventEndDate ) {
        if ( is_string($eventEndDate )){
            $this->eventEndDate = trim($eventEndDate);
        }
    }
    public function setApplyId( $applyId ) {
        if ( is_int(intval($applyId) ) ){
            $this->applyId = $applyId;
        }
    }
    public function setApplyTitle( $applyTitle ) {
        if ( is_string($applyTitle )){
            $this->applyTitle = trim($applyTitle);
        }
    }
    public function setApplyUser( $applyUser ) {
        if ( is_string($applyUser )){
            $this->applyUser = trim($applyUser);
        }
    }

    /**
     * 
     * @return int The db id of this event
     */
    public function getId() {
        return $this->id;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getEventCategory(){
        return $this->fkEventCat;
    }
    public function getEventType(){
        return $this->fkEventType;
    }
    public function getEventInfo(){
        return $this->eventInfo;
    }
    public function getEventDate(){
        return $this->eventDate;
    }
    public function getEventDueDate(){
        return $this->eventDueDate;
    }
    public function getEventEndDate(){
        return $this->eventEndDate;
    }
    public function getApplyId(){
        return $this->applyId;
    }
    public function getApplyTitle(){
        return $this->applyTitle;
    }
    public function getApplyUser(){
        return $this->applyUser;
    }

    public function getGetValues(){
        //Define the check for params
        $get_check_array = array (
            //Action
            'action' => array('filter' => FILTER_SANITIZE_STRING ),

            //Id of current row
            'id' => array('filter' => FILTER_VALIDATE_INT ));

            //Get filtered input:
            $inputs = filter_input_array( INPUT_GET, $get_check_array );

            // RTS
            return $inputs;
    }

    public function getCategoryById($id) {
        //Calling wpdb
        global $wpdb;
        //Setting var as an array
        //Database query
        $result_array = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "meo_event_category WHERE id_event_category = $id", ARRAY_A );
        // Loop through images
        foreach ($result_array as $array) {
            $category = $array['name'];
        }
        // Return array
        return $category;
    }

    public function getTypeById($id) {
        //Calling wpdb
        global $wpdb;
        //Setting var as an array
        //Database query
        $result_array = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "meo_event_type WHERE id_event_type = $id", ARRAY_A );
        // Loop through images
        foreach ($result_array as $array) {
            $type = $array['name'];
        }
        // Return array
        return $type;
    }

    public function save($input_array){
        try {
            if (!isset($input_array['gebruiker']) OR
                !isset($input_array['eventTitel'])){
                // Mandatory fields are missing
                throw new Exception(__("Missing mandatory fields"));
            }
            if ( (strlen($input_array['gebruiker']) < 1) OR
                (strlen($input_array['eventTitel']) < 1) ){
                // Mandatory fields are empty
                throw new Exception( __("Empty mandatory fields") );
            }

            global $wpdb;

            // Insert query
            $wpdb->query($wpdb->prepare("INSERT INTO `". $this->getApplyTableName()."` ( `event_title`, `event_user`)".
                " VALUES ( '%d', '%d');",$input_array['gebruiker'],$input_array['eventTitel']) );
            // Error ? It's in there:
            if ( !empty($wpdb->last_error) ){
                $this->last_error = $wpdb->last_error;
                return FALSE;
            }

        } catch (Exception $exc) {
            // @todo: Add error handling
            echo '<pre>'. $exc->getTraceAsString() .'</pre>';
        }

    return TRUE;
}

public function handleGetAction( $get_array ){
    $action = '';

    switch($get_array['action']){
        case 'update':
            // Indicate current action is update if id provided
            if ( !is_null($get_array['id']) ){
                $action = $get_array['action'];
            }
            break;

        case 'delete':
            // Delete current id if provided
            if ( !is_null($get_array['id']) ){
                $this->delete($get_array);
            }
            $action = 'delete';
            break;

        default:
            // Oops
                break;
    }
    return $action;
}

public function delete($input_array){
    try {
        // Check input id
        if (!isset($input_array['id']) ) throw new Exception(__("Missing mandatory fields") );
        global $wpdb;
        // Delete row by provided id (WordPress style)
        $wpdb->delete( $this->getApplyTableName(),
            array( 'id' => $input_array['id'] ),
            array( '%d' ) );

        // Where format
        //*/
        // Error ? It's in there:
        if ( !empty($wpdb->last_error) ){
            throw new Exception( $wpdb->last_error);
        }
    } catch (Exception $exc) {
    }

    return TRUE;
}

public function getUsersById($id) {
    //Calling wpdb
    global $wpdb;
    //Setting var as an array
    //Database query
    $result_array = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "users WHERE ID = $id", ARRAY_A );
    // Loop through images
    foreach ($result_array as $array) {
        $user = $array['display_name'];
    }
    // Return array
    return $user;
}

public function getTitleById($id) {
    //Calling wpdb
    global $wpdb;
    //Setting var as an array
    //Database query
    $result_array = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "meo_event WHERE id_event = $id", ARRAY_A );
    // Loop through images
    foreach ($result_array as $array) {
        $title = $array['event_title'];
    }
    // Return array
    return $title;
}


} 
 ?>