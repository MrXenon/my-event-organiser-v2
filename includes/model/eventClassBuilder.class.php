<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
require_once (MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR. '/eventClassTables.class.php');
require_once (MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR. '/eventClassPostValues.class.php');
require_once (MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR. '/eventClassLists.class.php');
require_once (MY_EVENT_ORGANISER_PLUGIN_MODEL_DIR. '/eventClassStoreData.class.php');
class eventBuilder{

    // Repetitive id
    private $id             =       '';
    // category & type
    private $name           =       '';
    private $description    =       '';
    // apply list
    private $eventTitel     =       '';
    private $gebruiker      =       '';

    // sign up for event
    private $fkEventCat     =       '';
    private $fkEventType    =       '';
    private $eventInfo      =       '';
    private $eventDate      =       '';
    private $eventDueDate   =       '';
    private $eventEndDate   =       '';
    private $applyId        =       '';
    private $applyTitle     =       '';
    private $applyUser      =       '';

    public function __construct(){
        $this->tables       =   new eventTables();
        $this->postValues   =   new eventPostValues();
        $this->eventlist    =   new eventLists();
        $this->storeData    =   new eventStoreData();
    }
    #region Tables
        private function TablePrefix(){return $this->Tables->TablePrefix();}
        private function EventTypeTable(){return $this->Tables->EventTypeTable();}
        private function EventCategoryTable(){return $this->Tables->EventCategoryTable();}
        private function EventTable(){return $this->Tables->EventTable();}
        private function EventSignupTable(){return $this->Tables->EventSignupTable();}
    #endregion
    #region PostValues
        public function getPostValues(){return $this->postValues->getPostValues();}
    #endregion
    #region Lists
        public function getUsersById($id){return $this->eventlist->getUsersById($id);}
        public function getTitleById($id){return $this->eventlist->getTitleById($id);}
        public function getNrOfEventTypes(){return $this->eventlist->getNrOfEventTypes();}
        public function getEventTypeList(){return $this->eventlist->getEventTypeList();}
        public function getCategoryById($id){return $this->eventlist->getCategoryById($id);}
        public function getTypeById($id){return $this->eventlist->getTypeById($id);}
        public function getNrOfEvents(){return $this->eventlist->getNrOfEvents();}
        public function getNrOfInschrijvingen(){return $this->eventlist->getNrOfInschrijvingen();}
        public function getEventList() {return $this->eventlist->getEventList();}
        public function getSignupList() {return $this->eventlist->getSignupList();}
        public function getEventCategoryList() {return $this->eventlist->getEventCategoryList();}
        public function getNrOfEventCategories() {return $this->eventlist->getNrOfEventCategories();}
    #endregion
    #region Store Data
        public function save($input_array){return $this->storeData->save($input_array);}
        public function update($input_array){return $this->storeData->update($input_array);}
        public function delete($input_array){return $this->storeData->delete($input_array);}
        public function handleGetAction($get_array){return $this->storeData->handleGetAction($get_array);} 
        public function getGetValues(){return $this->storeData->getGetValues();}
    #endregion
    #region repetitive ID Get & set
        public function setId( $id ) {
            if ( is_int(intval($id) ) ){
                $this->id = $id;
            }
        }
        public function getId() {
            return $this->id;
        }
    #endregion
    #region set & get EventType & Category
        public function setName( $name ) {
            if ( is_string($name )){
                $this->name = trim($name);
            }
        }
        public function setDescription ($desc) {
            if ( is_string($desc)){
                $this->description = trim($desc);
            }
        }
        public function getName(){
            return $this->name;
        }
        public function getDescription(){
            return $this->description;    
        }
    #endregion

    #region ApplyList
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
    #endregion
}