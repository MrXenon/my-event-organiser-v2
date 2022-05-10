<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
class eventPostValues{
    public function getPostValues(){
      
        //Define the check for params
        $post_check_array = array (
            //Submit action
            'add' => array('filter' => FILTER_SANITIZE_STRING ),
            'update' => array('filter' => FILTER_SANITIZE_STRING ),
            
            // event type & category name.
            'name'   => array('filter' => FILTER_SANITIZE_STRING ),

            // Help text - Type & Category
            'description'   => array('filter' => FILTER_SANITIZE_STRING ),

            //Event list user
            'gebruiker' => array('filter' => FILTER_SANITIZE_STRING ),
    
            //Event list title
            'eventTitel' => array('filter' => FILTER_SANITIZE_STRING),
            
            // get page slug
            'p' => array('filter' => FILTER_SANITIZE_STRING),
            
            //Id of current row
            'id' => array('filter' => FILTER_VALIDATE_INT )
        );
    
        //Get filtered input: 
        $inputs = filter_input_array( INPUT_POST, $post_check_array );
    
        //RTS
        return $inputs;
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
}
?>