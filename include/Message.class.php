<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Message
 *
 * @author KDS
 */
class Message extends WebConstants{
    
    protected $con;
    
    function __construct() {
        $this->con = new Connection();
    }
    
    function insertMessageHeader($subject,$from_id,$to_id)
    {
        if($subject == "" || $from_id == "" || $to_id == "") {
            echo json_encode(array("error"=>"Invalid parameters passed"));
            exit();
        }
        $query = "INSERT INTO `Message_Header`(`subject`, `from_id`, `to_id`,`time`) VALUES (:subject,:fromID,:toID,UTC_TIMESTAMP())";
        $bindParams = array("subject"=>$subject,"fromID"=>$from_id,"toID"=>$to_id);
        $id = $this->con->insertQuery($query, $bindParams);
        
        return $id;
    }
    
    function insertMessages($header_id,$is_from_id,$body)
    {
        $query = "INSERT INTO `Messages`(`header_id`, `is_from_id`, `body`, `read`,`time`) VALUES (:headerID,:isFromID,:body,0,UTC_TIMESTAMP())";
        $bindParams = array("headerID"=>$header_id,"isFromID"=>$is_from_id,"body"=>$body,);
        $id = $this->con->insertQuery($query, $bindParams);
        
        return $id;
    }
    
    function getInboxMessages($userID)
    {
        global $WEB_URL;
        $query = "SELECT `id`, `subject`, `from_id`, `to_id`, `time` FROM `Message_Header` WHERE `from_id` = :userID OR `to_id` = :userID";
        $bindParams = array("userID" => $userID);
        $qh = $this->con->getQueryHandler($query, $bindParams);
        $i = 0;
        $response = array();
        while($res = $qh->fetch(PDO::FETCH_ASSOC))
        {
            $response[$i]["id"] = $res["id"];
            $response[$i]["subject"] = $res["subject"];
            $response[$i]["time"] = $res["time"];
            
            if($res["from_id"] == $userID) {                
                $userDetails = $this->getUserNameAndPic($res["to_id"]);  
                $userDetails["sender_id"] = $res["to_id"];
            } else {               
                $userDetails = $this->getUserNameAndPic($res["from_id"]);
                $userDetails["sender_id"] = $res["from_id"];
            }
            $userDetails['profilePic'] = ($userDetails['profilePic'] == "")?"":str_replace("WEB_URL", "$WEB_URL/casting_mobile", $userDetails['profilePic']);
            $response[$i]["userDetails"] = $userDetails;
            $i++;
        }
        return $response;
    }
    
    function getUserNameAndPic($userID)
    {
        $query = "SELECT `firstName`,`lastName`,`profilePic` FROM `User_Profile` WHERE `userID` = :userID LIMIT 1";
        $bindParams = array("userID" => $userID);
        $qh = $this->con->getQueryHandler($query, $bindParams);
        $res = $qh->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
    
    function getConversation($userID,$messageID)
    {
        $query = "SELECT `id` AS `message_id`, "
                . "CASE WHEN (`is_from_id` = :userID) "
                . "THEN '1' "
                . "ELSE '0' "
                . "END AS `is_user`, "
                . "`body`, `time` FROM `Messages` WHERE `header_id` = :messageID";
        $bindParams = array("userID" => $userID,"messageID"=>$messageID);
        $qh = $this->con->getQueryHandler($query, $bindParams);
        $messages = array();
        while($res = $qh->fetch(PDO::FETCH_ASSOC))
        {
           $messages[] = $res;
        }
        return $messages;
    }
    
    function updateReadStatus($userID,$messageID)
    {
        $query = "UPDATE `Messages` SET `read`='1' WHERE `header_id` = :headerID AND `is_from_id` != :userID";
        $bindParams = array("headerID"=>$messageID,"userID"=>$userID);
        $id = $this->con->insertQuery($query, $bindParams);
        return $id;
    }
    
    function getUnreadCount($userID)
    {
        $query = "SELECT COUNT(*) as unread FROM `Messages` WHERE `read` = :readStatus AND `is_from_id` != :userID AND `header_id` IN (SELECT `id` FROM `Message_Header` WHERE `from_id` = :userID or `to_id` = :userID)";
        $bindParams = array("userID" => $userID,"readStatus"=>"0");
        $qh = $this->con->getQueryHandler($query, $bindParams);
        $res = $qh->fetch(PDO::FETCH_ASSOC);
        return $res['unread'];
    }
}
