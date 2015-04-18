<?php

/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

/**

 * Description of User

 *

 * @author KDS

 */
class User extends WebConstants{

    protected $con;

    function __construct() {

        $this->con = new Connection();
    }

    public function getUserDetails($userID) {

        $query = "SELECT ul.accessToken,uf.userID,uf.firstName,uf.lastName,uf.profilePic,ul.userType FROM `User_Profile` uf, `User_Login` ul  WHERE ul.userID = :userID and ul.userid = uf.userid LIMIT 1";

        $qh = $this->con->getQueryHandler($query, array("userID" => $userID));

        return $qh->fetch(PDO::FETCH_ASSOC);
    }

    public function authenticateUser($username, $password, $accountType) {

        $hashPass = substr(hash('sha512', $password), 0, 20);

        if ($accountType == "-1") {

            $query = "SELECT userID FROM `User_Login` WHERE accessToken = :accessToken AND password = :password LIMIT 1";

            $bindParams = array("accessToken" => $username, "password" => $hashPass);
        } else {

            $query = "SELECT userID FROM `User_Login` WHERE userName = :userName AND password = :password LIMIT 1";

            $bindParams = array("userName" => $username, "password" => $hashPass);
        }



        $qh = $this->con->getQueryHandler($query, $bindParams);

        $res = $qh->fetch(PDO::FETCH_ASSOC);

        if (isset($res["userID"]) && $res["userID"] != "") {

            return $res["userID"];
        }

        return -1;
    }

    public function insertUser($accountType, $username, $password, $userType) {

        $accessToken = sha1(substr(md5($username), 0, 15));

        if ($accountType == 1) {

            $hashPass = substr(hash('sha512', $password), 0, 20);

            $query = "INSERT INTO `User_Login`(`userName`, `password`, `accessToken`, `accountType`,`userType`) VALUES (:userName,:password,:accessToken,:accountType,:userType)";

            $bindParams = array("userName" => $username, "password" => $hashPass, "accessToken" => $accessToken, "accountType" => $accountType, "userType"=>$userType);
        } else {

            $query = "INSERT INTO `User_Login`(`accountID`,`accessToken`, `accountType`,`userType`) VALUES (:accountID,:accessToken,:accountType,:userType)";

            $bindParams = array("accountID" => $username, "accessToken" => $accessToken, "accountType" => $accountType, "userType"=>$userType);
        }

        $id = $this->con->insertQuery($query, $bindParams);

        return $id;
    }

    public function checkUser($username) {

        $query = "SELECT COUNT(*) as count FROM `User_Login` WHERE `userName` = :username";

        $bindParams = array("username" => $username);

        $qh = $this->con->getQueryHandler($query, $bindParams);

        $res = $qh->fetch(PDO::FETCH_ASSOC);

        $bool = ($res["count"] > 0) ? false : true;

        return $bool;
    }

    public function checkAccountID($accountID, $accountType) {

        $query = "SELECT userID FROM `User_Login` WHERE `accountID` = :accountID and `accountType` = :accountType";

        $bindParams = array("accountID" => $accountID, "accountType" => $accountType);

        $qh = $this->con->getQueryHandler($query, $bindParams);

        $res = $qh->fetch(PDO::FETCH_ASSOC);

        $userID = (!isset($res["userID"]) || $res["userID"] == "" || $res["userID"] == 0) ? -1 : $res["userID"];

        return $userID;
    }

    public function insertUserProfile($userID, $firstname, $lastname, $email, $gender, $country, $state, $city, $phone = "", $skypeID = "", $bio = "", $pic = "") {

        $query = "INSERT INTO `User_Profile`(`userID`, `firstName`, `lastName`, `profilePic`, `phone`, `email`, `skypeID`, `bio`, `resume`,`gender`,`country`,`state`,`city`) VALUES (:userID,:firstName,:lastName,:profilePic,:phone,:email,:skypeID,:bio,:resume,:gender,:country,:state,:city)";

        $bindParams = array("userID" => $userID, "firstName" => $firstname, "lastName" => $lastname, "profilePic" => $pic, "phone" => $phone, "email" => $email, "skypeID" => $skypeID, "bio" => $bio, "resume" => "", "gender" => $gender, "country"=>$country,"state"=>$state, "city"=>$city);

        $id = $this->con->insertQuery($query, $bindParams);

        return $id;
    }

    public function getUserIDFromAccToken($accessToken) {

        $query = "SELECT `userID` FROM `User_Login` WHERE `accessToken` = :accessToken";

        $bindParams = array("accessToken" => $accessToken);

        $qh = $this->con->getQueryHandler($query, $bindParams);

        $res = $qh->fetch(PDO::FETCH_ASSOC);

        $userID = isset($res["userID"]) ? $res["userID"] : "-1";

        return $userID;
    }

    public function getSocialLinks($userID) {

        $query_link = "SELECT `sl_id`, `link` FROM `Social_Links` WHERE `user_id` = :userID";

        $qh_link = $this->con->getQueryHandler($query_link, array("userID" => $userID));

        $socialLinks = array();

        while ($res_link = $qh_link->fetch(PDO::FETCH_ASSOC)) {

            $socialLinks[] = $res_link['link'];
        }



        return $socialLinks;
    }

    public function getUserPics($userID) {
        global $WEB_URL;

        $query_pic = "SELECT `pic_id`, `path` FROM `User_Pics` WHERE `user_id` = :userID";

        $qh_pic = $this->con->getQueryHandler($query_pic, array("userID" => $userID));

        $picArray = array();

        while ($res_pic = $qh_pic->fetch(PDO::FETCH_ASSOC)) {

            $link = str_replace("WEB_URL", "$WEB_URL/casting_mobile/images", $res_pic['path']);

            $picArray[] = array("pic_id" => $res_pic['pic_id'], "link" => $link);
        }



        return $picArray;
    }

    public function getUserVideos($userID) {
        global $WEB_URL;

        $query_video = "SELECT `video_id`, `path`, `thumb` FROM `User_Videos` WHERE `user_id` = :userID";

        $qh_video = $this->con->getQueryHandler($query_video, array("userID" => $userID));

        $videoArray = array();

        while ($res_video = $qh_video->fetch(PDO::FETCH_ASSOC)) {

            $link = str_replace("WEB_URL", "$WEB_URL/casting_mobile/videos", $res_video['path']);

            $videoArray[] = array("video_id" => $res_video['video_id'], "link" => $link, "thumb" => $res_video['thumb']);
        }



        return $videoArray;
    }

    public function getUserToCDPics($userID,$jobID)
    {
        global $WEB_URL;

        $query_pic = "SELECT `pic_id`,`path` FROM `user_pics` 
                    WHERE 
                    `pic_id` 
                    IN 
                    (
                        SELECT `picID` FROM `job_applied_pics` 
                            WHERE `userID` = :userID 
                            AND `jobID` = :jobID
                    )
                    AND
                    `user_id` = :userID";

        $qh_pic = $this->con->getQueryHandler($query_pic, array("userID" => $userID,"jobID"=>$jobID));

        $picArray = array();

        while ($res_pic = $qh_pic->fetch(PDO::FETCH_ASSOC)) {

            $link = str_replace("WEB_URL", "$WEB_URL/casting_mobile/images", $res_pic['path']);

            $picArray[] = array("pic_id" => $res_pic['pic_id'], "link" => $link);
        }

        return $picArray;
    }
    
    public function getUserTags($userID)
    {
        $query = "SELECT `tag_id`, `tag_name` FROM `tags` WHERE `tag_id` "
                    . "IN "
                    . "("
                    . "SELECT `tagID` FROM `user_tags` WHERE `userID` = :userID"
                    . ")";

        $qh = $this->con->getQueryHandler($query, array("userID" => $userID));

        $tagArray = array();

        while ($res = $qh->fetch(PDO::FETCH_ASSOC)) {

            $tagArray[] = array("tag_id" => $res['tag_id'], "name" => $res['tag_name']);
        }

        return $tagArray;
    }
    
    public function getUserNoteToCD($userID,$jobID)
    {
        $query = "SELECT `note` FROM `job_applications` WHERE `userID` = :userID AND `jobID` = :jobID";
        $qh = $this->con->getQueryHandler($query, array("userID" => $userID,"jobID"=>$jobID));                
        $res = $qh->fetch(PDO::FETCH_ASSOC);
        
        return $res['note'];
    }
    
    public function getProfileData($userID, $jobID = "-1") {
        global $WEB_URL;

        $query_main = "SELECT `firstName`,`lastName`, `profilePic`, `phone`, `email`, `skypeID`, `bio`, `resume`, `gender` "
                    . "FROM `User_Profile` "
                    . "WHERE `userID` = :userID "
                    . "LIMIT 1";

        $qh_main = $this->con->getQueryHandler($query_main, array("userID" => $userID));

        $details = $qh_main->fetch(PDO::FETCH_ASSOC);

        $details["profilePic"] = ($details["profilePic"] == "") ? "$WEB_URL/casting_mobile/images/default.jpg" : str_replace("WEB_URL", "$WEB_URL/casting_mobile", $details["profilePic"]);

        $details["resume"] = ($details["resume"] == "") ? "" : str_replace("WEB_URL", "$WEB_URL/casting_mobile", $details["resume"]);

        if (empty($details)) {

            echo json_encode(array("error" => "Invalid User ID", "code" => "0"));

            exit();
        }


        $details["social_link"] = $this->getSocialLinks($userID);
        
        if($jobID == "-1") {
            $details["pic"] = $this->getUserPics($userID);
        } else {
            $details["pic"] = $this->getUserToCDPics($userID, $jobID);
            $details["tags"] = $this->getUserTags($userID);
            $details["note"] = $this->getUserNoteToCD($userID, $jobID);
        }

        $details["video"] = $this->getUserVideos($userID);

        return $details;
    }

    public function updateProfile($firstname, $lastname, $phone, $email, $skypeID, $bio, $gender, $userID, $profilePicPath = "") {

        if ($firstname == "" || $email == "" || $gender == "" || $userID == "") {

            echo json_encode(array("error" => "Invalid parameters", "code" => "0"));

            exit();
        }

        if ($profilePicPath == "") {

            $query = "UPDATE `User_Profile` SET `firstName`=:firstName,`lastName`=:lastName,`phone`=:phone,`email`=:email,`skypeID`=:skypeID,`bio`=:bio,`gender`=:gender WHERE `userID`=:userID";

            $bindParams = array("firstName" => $firstname, "lastName" => $lastname, "phone" => $phone, "email" => $email, "skypeID" => $skypeID, "bio" => $bio, "gender" => $gender, "userID" => $userID);
        } else {

            $query = "UPDATE `User_Profile` SET `firstName`=:firstName,`lastName`=:lastName,`phone`=:phone,`email`=:email,`skypeID`=:skypeID,`bio`=:bio,`gender`=:gender, `profilePic` = :profilePic WHERE `userID`=:userID";

            $bindParams = array("firstName" => $firstname, "lastName" => $lastname, "phone" => $phone, "email" => $email, "skypeID" => $skypeID, "bio" => $bio, "gender" => $gender, "profilePic" => $profilePicPath, "userID" => $userID);
        }



        $id = $this->con->insertQuery($query, $bindParams);

        return $id;
    }

    public function insertSocialLinks($userID, $link) {

        if (!($this->checkSocialLink($userID, $link))) {

            $query = "INSERT INTO `Social_Links`(`user_id`, `link`) VALUES (:userID,:link)";

            $bindParams = array("userID" => $userID, "link" => $link);

            $id = $this->con->insertQuery($query, $bindParams);
        } else {

            $id = "-1";
        }

        return $id;
    }

    public function checkSocialLink($userID, $link) {

        $query = "SELECT `sl_id` FROM `Social_Links` WHERE `user_id` = :userID AND `link` = :link LIMIT 1";

        $qh = $this->con->getQueryHandler($query, array("userID" => $userID, "link" => $link));

        $check = $qh->fetch(PDO::FETCH_ASSOC);

        if (!isset($check["sl_id"]) || $check["sl_id"] == "") {

            return FALSE;
        }

        return TRUE;
    }

    public function deleteSocialLinks($userID) {

        $query = "DELETE FROM `Social_Links` WHERE `user_id` = :userID";

        $this->con->getQueryHandler($query, array("userID" => $userID));
    }

    public function updatePassword($accessToken, $password) {

        $hashPass = substr(hash('sha512', $password), 0, 20);

        $query = "UPDATE `User_Login` SET `password` = :password WHERE `accessToken` = :accessToken";

        $bindParams = array("password" => $hashPass, "accessToken" => $accessToken);

        $id = $this->con->insertQuery($query, $bindParams);

        return $id;
    }
    
    public function getUserType($userID)
    {
        $query = "SELECT `userType` FROM `User_Login` WHERE `userID` = :userID LIMIT 1";

        $qh = $this->con->getQueryHandler($query, array("userID" => $userID));

        $userType = $qh->fetch(PDO::FETCH_ASSOC);
        
        return $userType['userType'];
    }
    
    public function getCDProfileData($userID)
    {
        $query = "SELECT `firstName`, `lastName`, `profilePic`, `phone`, `email`, `gender` FROM `user_profile` WHERE `userID` = :userID LIMIT 1";

        $qh = $this->con->getQueryHandler($query, array("userID" => $userID));

        $userDetails = $qh->fetch(PDO::FETCH_ASSOC);
        
        return $userDetails;
    }
    
    public function setCDProfileData($firstName,$lastName,$profilePic,$phone,$email,$gender,$userID)
    {
        $query = "UPDATE `user_profile` "
                . "SET `firstName`=:firstName,`lastName`=:lastName,`profilePic`=:profilePic,`phone`=:phone,`email`=:email,`gender`=:gender "
                . "WHERE `userID`=:userID";

        $bindParams = array("firstName"=>$firstName,"lastName"=>$lastName,"profilePic"=>$profilePic,"phone"=>$phone,"email"=>$email,"gender"=>$gender,"userID"=>$userID);

        $id = $this->con->insertQuery($query, $bindParams);

        return $id;
    }
    
    function checkEmail($userName)
    {
        $query = "SELECT `userID`,`firstName` FROM `user_profile` WHERE `userID` = (SELECT `userID` FROM `user_login` WHERE `userName` = :userName)";
        $qh = $this->con->getQueryHandler($query, array("userName" => $userName));

        $userDetails = $qh->fetch(PDO::FETCH_ASSOC);
        
        return $userDetails;
    }
    
    function checkTokenValidity($token)
    {
        $query = "SELECT `userID` FROM `forgot_password` WHERE TIMESTAMPDIFF(day,`updatedDate`,NOW()) <= 1 AND `token` = :token";
        $qh = $this->con->getQueryHandler($query, array("token" => $token));

        $res = $qh->fetch(PDO::FETCH_ASSOC);
        $userID = isset($res['userID'])?$res['userID']:"-1";
        return $userID;
    }
    
    public function resetPassword($userID, $password) {

        $hashPass = substr(hash('sha512', $password), 0, 20);

        $query = "UPDATE `User_Login` SET `password` = :password WHERE `userID` = :userID";

        $bindParams = array("password" => $hashPass, "userID" => $userID);

        $id = $this->con->insertQuery($query, $bindParams);

        return $id;
    }

}
