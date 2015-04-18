<?php

/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

/**

 * Description of Common

 *

 * @author KDS

 */
class Common {

    protected $con;

    function __construct() {

        $this->con = new Connection();
    }

    function uploadFile($file, $userID, $type) {

        $arr = array("images", "videos", "profile_pics", "resumes","job_icon","company_logo");

        if (!in_array($type, $arr)) {

            echo json_encode(array("error" => "Invalid type", "code" => "0"));

            exit();
        }



        if ($file["error"] > 0) {

            //echo json_encode(array("error" => "Error: " . $file["error"], "code" => "0"));

            //exit();
            return "";
        }

        $filename = $userID . "-" . time() . session_id();

        while (file_exists("$type/" . $filename)) {

            $filename = $userID . time() . session_id();
        }
        if($type == "resumes") {
            $filename .= ".pdf";
        }
        if (move_uploaded_file($file["tmp_name"], "$type/" . $filename)) {

            return $filename;
        } else {

            return "-1";
        }
    }

    function addVideoLink($link, $userID) {

        $thumb = '';

        $regexstr = '~
            # Match Youtube link and embed code
            (?:                             # Group to match embed codes
                (?:<iframe [^>]*src=")?       # If iframe match up to first quote of src
                |(?:                        # Group to match if older embed
                    (?:<object .*>)?      # Match opening Object tag
                    (?:<param .*</param>)*  # Match all param tags
                    (?:<embed [^>]*src=")?  # Match embed tag to the first quote of src
                )?                          # End older embed code group
            )?                              # End embed code groups
            (?:                             # Group youtube url
                https?:\/\/                 # Either http or https
                (?:[\w]+\.)*                # Optional subdomains
                (?:                         # Group host alternatives.
                youtu\.be/                  # Either youtu.be,
                | youtube\.com              # or youtube.com
                | youtube-nocookie\.com     # or youtube-nocookie.com
                )                           # End Host Group
                (?:\S*[^\w\-\s])?           # Extra stuff up to VIDEO_ID
                ([\w\-]{11})                # $1: VIDEO_ID is numeric
                [^\s]*                      # Not a space
            )                               # End group
            "?                              # Match end quote if part of src
            (?:[^>]*>)?                       # Match any extra stuff up to close brace
            (?:                             # Group to match last embed code
                </iframe>                 # Match the end of the iframe
                |</embed></object>          # or Match the end of the older embed
            )?                              # End Group of last bit of embed code
            ~ix';

        $youtubelink = preg_match($regexstr, $link, $matches);

        if ($youtubelink == 0) {
            $regexstr = '~
            # Match Vimeo link and embed code
            (?:<iframe [^>]*src=")?       # If iframe match up to first quote of src
            (?:                         # Group vimeo url
                https?:\/\/             # Either http or https
                (?:[\w]+\.)*            # Optional subdomains
                vimeo\.com              # Match vimeo.com
                (?:[\/\w]*\/videos?)?   # Optional video sub directory this handles groups links also
                \/                      # Slash before Id
                ([0-9]+)                # $1: VIDEO_ID is numeric
                [^\s]*                  # Not a space
            )                           # End group
            "?                          # Match end quote if part of src
            (?:[^>]*></iframe>)?        # Match the end of the iframe
            (?:<p>.*</p>)?              # Match any title information stuff
            ~ix';

            $vimeolink = preg_match($regexstr, $link, $matches);

            if ($vimeolink == 0) {
                return 0;
            } else {
                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/" . $matches[1] . ".php"));

                $thumb = $hash[0]['thumbnail_large'];
            }
        } else {

            $thumb = "http://img.youtube.com/vi/" . $matches[1] . "/0.jpg";
        }

        $query = "INSERT INTO `User_Videos`(`user_id`, `path`,`thumb`) VALUES (:userID,:path,:thumb)";

        $bindParams = array("userID" => $userID, "path" => $link, "thumb" => $thumb);

        $id = $this->con->insertQuery($query, $bindParams);

        return array("video_id" => $id, "path" => $link, "thumb" => $thumb, "code" => 1);
    }

    function updateFilenameInDB($filename, $type, $userID) {

        if ($type == "images") {

            $query = "INSERT INTO `User_Pics`(`user_id`, `path`) VALUES (:userID,:path)";

            $path = "WEB_URL/$filename";
        } elseif ($type == "videos") {

            $query = "INSERT INTO `User_Videos`(`user_id`, `path`) VALUES (:userID,:path)";

            $path = "WEB_URL/$filename";
        } elseif ($type == "resumes") {

            $query = "UPDATE `User_Profile` SET `resume` = :path WHERE `userID` = :userID";

            $path = "WEB_URL/$type/$filename";
        } else {

            echo json_encode(array("error" => "Invalid Type", "code" => "0"));
        }


        $bindParams = array("userID" => $userID, "path" => $path);

        $id = $this->con->insertQuery($query, $bindParams);

        return array("file_id" => $id, "path" => $path);
    }

    public function deleteFile($file_id, $accessToken, $type) {

        $userObj = new User();

        $userID = $userObj->getUserIDFromAccToken($accessToken);

        if ($userID != "-1") {

            if ($type == "images") {
                $query = "DELETE FROM `Job_Applied_Pics` WHERE `picID` = :pic_id";

                $this->con->getQueryHandler($query, array("pic_id" => $file_id));

                $query = "DELETE FROM `User_Pics` WHERE `pic_id` = :pic_id and `user_id` = :user_id";

                $this->con->getQueryHandler($query, array("pic_id" => $file_id, "user_id" => $userID));
            } elseif ($type == "videos") {

                $query = "DELETE FROM `User_Videos` WHERE `video_id` = :video_id and `user_id` = :user_id";

                $this->con->getQueryHandler($query, array("video_id" => $file_id, "user_id" => $userID));
            } else {

                echo json_encode(array("error" => "Invalid Type", "code" => "0"));

                exit();
            }
        } else {

            echo json_encode(array("error" => "Access Token Invalid", "code" => "0"));

            exit();
        }
    }

    function sendMailFunction($param) {
            $to = $param->sendTo;
            $subject = $param->subject;
//            $headers = 'MIME-Version: 1.0' . "\r\n";
//            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//            $headers .= 'From: cdbadmin@server2.saffordproductions.net' . "\r\n"
//                        . "\r\n" .
//                        "Reply-To: cdbadmin@server2.saffordproductions.net" . "\r\n" .
//                        "X-Mailer: PHP/" . phpversion();
            
            $headers = "Reply-To: castingdb.net Admin <cdbadmin@castingdb.net>\r\n"; 
            $headers .= "Return-Path: castindb.net Admin <cdbadmin@castingdb.net>\r\n";
            $headers .= "From: castingdb.net Admin <cdbadmin@castingdb.net>\r\n";
            $headers .= "Organization: castingdb.net\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            //$headers .= "X-Priority: 3\r\n";
            $headers .= "X-Priority: 2\nX-MSmail-Priority: high";
            $headers .= "X-Mailer: PHP". phpversion() ."\r\n";

            
            $message = "<html><head>" .
                   "<meta http-equiv='Content-Language' content='en-us'>" .
                   "<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>" .
                   "</head><body><h3>" .$param->content.        
                   "</h3><br><br></body></html>";
            //$message = $param->content;
           //var_dump(array($to, $subject, $message, $headers));
          if(!mail($to, $subject, $message, $headers))
          {
              echo json_encode(array("log"=>"Email not sent"));
              die();
          } 
//          else {
//              echo "mail sent<br>";
//          }
    }
    
    function getCountry()
    {
        $query = "SELECT `Code`, `Name` FROM `country` ORDER BY `Name` ASC";

        $bindParams = array();

        $qh = $this->con->getQueryHandler($query, $bindParams);
        $country = array();
        
        while($res = $qh->fetch(PDO::FETCH_ASSOC))
        {
            $country[] = $res;
        }
        return $country;
    }
    
    function getState($countryCode)
    {
        $query = "SELECT DISTINCT `District` FROM `city` WHERE `CountryCode` = :countryCode ORDER BY `District` ASC";

        $bindParams = array("countryCode"=>$countryCode);

        $qh = $this->con->getQueryHandler($query, $bindParams);
        $state = array();
        
        while($res = $qh->fetch(PDO::FETCH_ASSOC))
        {
            $state[] = $res['District'];
        }
        return $state;
    }
    
    function getCity($countryCode,$state)
    {
        $query = "SELECT `Name` FROM `city` WHERE `CountryCode` = :countryCode AND `District` = :state ORDER BY `Name` ASC";

        $bindParams = array("countryCode"=>$countryCode,"state"=>$state);

        $qh = $this->con->getQueryHandler($query, $bindParams);
        $city = array();
        
        while($res = $qh->fetch(PDO::FETCH_ASSOC))
        {
            $city[] = $res['Name'];
        }
        return $city;
    }
    
    
    function insertForgotPasswordToken($userID)
    {       
        $token = substr(sha1(md5($userID.time().session_id().rand(0, 100))),0,20);
        
        $query = "SELECT COUNT(*) AS countdata FROM `forgot_password` WHERE `userID` = :userID";

        $bindParams = array("userID"=>$userID);

        $qh = $this->con->getQueryHandler($query, $bindParams);
        
        $res = $qh->fetch(PDO::FETCH_ASSOC);
        
        if($res['countdata'] == 0) {
        
            $query = "INSERT INTO `forgot_password`(`userID`, `token`) VALUES (:userID,:token)";

            $bindParams = array("userID" => $userID, "token"=>$token);

            $id = $this->con->insertQuery($query, $bindParams);
        } else {
            $query = "UPDATE `forgot_password` SET `token` = :token, updatedDate = NOW() WHERE `userID` = :userID";

            $bindParams = array("userID" => $userID, "token"=>$token);

            $id = $this->con->insertQuery($query, $bindParams);
        }
        
        return $token;
    }
    
}