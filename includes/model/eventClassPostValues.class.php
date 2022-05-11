<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
class eventPostValues{
    public function getPostValues(){
      
        //Define the check for params
        // FILTER_UNSAFE_RAW  just pass raw html values
        /** Escape output with filter_string_polyfill
        *   function filter_string_polyfill(string $string): string
        *   {
        *       $str = preg_replace('/\x00|<[^>]*>?/', '', $string);
        *       return str_replace(["'", '"'], ['&#39;', '&#34;'], $str);
        *   }
        */
        $post_check_array = array (
            //Submit action
            'add' => array('filter' => FILTER_SANITIZE_STRING  ),
            'update' => array('filter' => FILTER_SANITIZE_STRING  ),
            
            // event type & category name.
            'name'   => array('filter' => FILTER_SANITIZE_STRING  ),

            // Help text - Type & Category
            'description'   => array('filter' => FILTER_SANITIZE_STRING  ),

            //Event list user
            'gebruiker' => array('filter' => FILTER_SANITIZE_STRING  ),
    
            //Event list title
            'eventTitel' => array('filter' => FILTER_SANITIZE_STRING ),
            
            // get page slug
            'p' => array('filter' => FILTER_SANITIZE_STRING ),
            
            //Id of current row
            'id' => array('filter' => FILTER_VALIDATE_INT )
        );
    
        //Get filtered input: 
        $inputs = filter_input_array( INPUT_POST, $post_check_array );
    
        //RTS
        return $inputs;
      }
}
?>