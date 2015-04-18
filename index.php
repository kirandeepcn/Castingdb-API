<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

header('Access-Control-Allow-Origin: *');

$WEB_URL = "http://www.castingdb.net";
function __autoload($classname) {
    include "include/" . $classname . ".class.php";
}

$type = $_POST["type"];
switch ($type) {
    case "login": 
        $accountType = isset($_POST['accountType']) ? $_POST['accountType'] : "";
        $userObj = new User();
        if ($accountType == 1) {
            $username = isset($_POST['username']) ? $_POST['username'] : "";
            $password = isset($_POST['password']) ? $_POST['password'] : "";
            $userID = $userObj->authenticateUser($username, $password, $accountType);            
            $check = ($userID != -1) ? true : false;
        } elseif ($accountType == 2) {
            $accountID = $_POST['accountID'];
            $userID = $userObj->checkAccountID($accountID, $accountType);
            if ($userID == -1) {
                $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : "";
                $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : "";
                $gender = isset($_POST['gender']) ? $_POST['gender'] : "";
                $email = isset($_POST['email']) ? $_POST['email'] : "";
                $pic = isset($_POST['pic']) ? $_POST['pic'] : "";
                $country = isset($_POST['country']) ? $_POST['country'] : "";
                $state = isset($_POST['state']) ? $_POST['state'] : "";
                $city = isset($_POST['city']) ? $_POST['city'] : "";
                if (($email == "" ) || ($firstname == "") || ($gender == "")) {
                    echo json_encode(array("error" => "Missing parameters", "code" => "0"));
                    exit();
                } $userID = $userObj->insertUser($accountType, $accountID,"","1");
                $userObj->insertUserProfile($userID, $firstname, $lastname, $email, $gender,$country, $state, $city, "", "", "", $pic);
            } $check = true;
        } else {
            echo json_encode(array("error" => "Missing parameters", "code" => "0"));
            exit();
        } if ($check) {
            $userType = $userObj->getUserType($userID);
            $jobObj = new Job();
            if($userType == 2)
            {
                $jobIds = $jobObj->getCastingDirectorJobIds($userID);
                $castingJobDetails = array();
                $recentApplicants = array();
                if(!empty($jobIds)) {
                    $castingJobDetails = $jobObj->getCastingJobDetails($jobIds);
                    $recentApplicants = $jobObj->getRecentApplicants($jobIds,2);
                }
            } else {
                
                $jobDetails = $jobObj->getJobDetails(0, 10);
                $applied_job_ids = $jobObj->getAppliedJobIds($userID);
                for ($i = 0; $i < count($jobDetails); $i++) {
                    if (array_search($jobDetails[$i]["job_id"], $applied_job_ids) === FALSE) {
                        $jobDetails[$i]["applied"] = "0";
                    } else {
                        $jobDetails[$i]["applied"] = "1";
                    }
                } 
            }
            $userDetails = $userObj->getUserDetails($userID);
            $userDetails["profilePic"] = ($userDetails["profilePic"] == "") ? "$WEB_URL/casting_mobile/images/default.jpg" : str_replace("WEB_URL", "$WEB_URL/casting_mobile", $userDetails["profilePic"]);
            $picsArray = $userObj->getUserPics($userID);
            $messageObj = new Message();
            $unreadCount = $messageObj->getUnreadCount($userID);

            if($userType == 2) {
                echo str_replace("\/", "/", json_encode(array("user" => $userDetails, "job" => $castingJobDetails,"recentApplicants"=> $recentApplicants,"code" => "1")));
            } else {
                echo str_replace("\/", "/", json_encode(array("user" => $userDetails, "job" => $jobDetails, "pics" => $picsArray,"unreadCount"=>$unreadCount, "code" => "1")));
            }
        } else {
            echo json_encode(array("error" => "Invalid Username or Password", "code" => "0"));
        } 
        
        break;
        
    case "access_token":
        $accessToken = isset($_POST['accessToken']) ? $_POST['accessToken'] : "";
        if ($accessToken == "") {
            echo json_encode(array("error" => "Access Token is empty", "code" => "-1"));
            exit();
        } $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if ($userID != -1) {
            $userType = $userObj->getUserType($userID);
            $jobObj = new Job();
            if($userType == 2)
            {
                $jobIds = $jobObj->getCastingDirectorJobIds($userID);
                $castingJobDetails = array();
                $recentApplicants = array();
                if(!empty($jobIds)) {
                    $castingJobDetails = $jobObj->getCastingJobDetails($jobIds);
                    $recentApplicants = $jobObj->getRecentApplicants($jobIds,2);
                }
            } else {
                $jobAllJobCount = $jobObj->getAllJobCount("");
                $jobDetails = $jobObj->getJobDetails(0, 10);
                $applied_job_ids = $jobObj->getAppliedJobIds($userID);
                for ($i = 0; $i < count($jobDetails); $i++) {
                    if (array_search($jobDetails[$i]["job_id"], $applied_job_ids) === FALSE) {
                        $jobDetails[$i]["applied"] = "0";
                    } else {
                        $jobDetails[$i]["applied"] = "1";
                    }
                } 
            }
            $userDetails = $userObj->getUserDetails($userID);
            $userDetails["profilePic"] = ($userDetails["profilePic"] == "") ? "$WEB_URL/casting_mobile/images/default.jpg" : str_replace("WEB_URL", "$WEB_URL/casting_mobile", $userDetails["profilePic"]);
            $picsArray = $userObj->getUserPics($userID);
            $messageObj = new Message();
            $unreadCount = $messageObj->getUnreadCount($userID);
            if($userType == 2) {
                echo str_replace("\/", "/", json_encode(array("user" => $userDetails, "job" => $castingJobDetails,"recentApplicants"=> $recentApplicants,"code" => "1")));
            } else {
                echo str_replace("\/", "/", json_encode(array("user" => $userDetails, "job" => $jobDetails, "pics" => $picsArray, "code" => "1","unreadCount"=>$unreadCount,"count"=>$jobAllJobCount)));
            }
        } else {
            echo json_encode(array("error" => "Invalid Access Token", "code" => "0"));
        } 
        
        break;
        
    case "create_account":
        $username = isset($_POST['username']) ? $_POST['username'] : "";
        $password = isset($_POST['password']) ? $_POST['password'] : "";
        $accountType = isset($_POST['accountType']) ? $_POST['accountType'] : "";
        $gender = isset($_POST['gender']) ? $_POST['gender'] : "";
        $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : "";
        $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : "";
        $country = isset($_POST['country']) ? $_POST['country'] : "";
        $state = isset($_POST['state']) ? $_POST['state'] : "";
        $city = isset($_POST['city']) ? $_POST['city'] : "";
        $phone = isset($_POST['phone']) ? $_POST['phone'] : "";
        $skypeID = isset($_POST['skypeID']) ? $_POST['skypeID'] : "";
        $userType = isset($_POST['userType'])?$_POST['userType']:"1";
        $bio = isset($_POST['bio']) ? $_POST['bio'] : "";
        if ($username == "" || $password == "" || $accountType == "" || $firstname == "") {
            echo json_encode(array("code" => "-1", "log" => "Some fields are missing"));
            exit();
        } $userObj = new User();
        if ($userObj->checkUser($username)) {
            $userID = $userObj->insertUser($accountType, $username, $password,$userType);
            $userObj->insertUserProfile($userID, $firstname,$lastname, $username, $gender, $country, $state, $city, $phone, $skypeID, $bio);
            $jobObj = new Job();
            $jobDetails = $jobObj->getJobDetails(0, 10);
            $applied_job_ids = $jobObj->getAppliedJobIds($userID);
            for ($i = 0; $i < count($jobDetails); $i++) {
                if (array_search($jobDetails[$i]["job_id"], $applied_job_ids) === FALSE) {
                    $jobDetails[$i]["applied"] = "0";
                } else {
                    $jobDetails[$i]["applied"] = "1";
                }
            } $userDetails = $userObj->getUserDetails($userID);
            $userDetails["profilePic"] = ($userDetails["profilePic"] == "") ? "$WEB_URL/casting_mobile/images/default.jpg" : str_replace("WEB_URL", "$WEB_URL/casting_mobile", $userDetails["profilePic"]);
            $userDetails["userType"] = $userType;
            $picsArray = $userObj->getUserPics($userID);
            if($userType == 2) {
                echo str_replace("\/", "/", json_encode(array("code" => "1", "log" => "Inserted Successfully", "user" => $userDetails)));
            }else {
                echo str_replace("\/", "/", json_encode(array("code" => "1", "log" => "Inserted Successfully", "user" => $userDetails, "job" => $jobDetails, "pics" => $picsArray)));
            }
        } else {
            echo json_encode(array("code" => "0", "log" => "Username already exists"));
        } 
        
        break;
        
    case "search_jobs":
        $filter = isset($_POST["filter"]) ? $_POST["filter"] : "";
        $val = isset($_POST["val"]) ? $_POST["val"] : "";
        $from = (isset($_POST['from']) || $_POST['from'] != "") ? ($_POST['from'] * 10) : "0";
        $to = $from + 10;
        $accessToken = isset($_POST["accessToken"]) ? $_POST["accessToken"] : "";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if ($userID != -1) {
            if ($filter == "location") {
                $valArr = explode(",", $val);
                $count = count($valArr);
                $i = 0;
                $j = 0;
                $criteria = "";
                if ($count > 1) {
                    foreach ($valArr as $item) {
                        $i++;
                        $itemArr = explode(" ", trim($item));
                        if ($i == 1) {
                            foreach ($itemArr as $values) {
                                $j++;
                                if ($j == 1) {
                                    $criteria .= "country LIKE '%$values%'";
                                } else {
                                    $criteria .= " OR country LIKE '%$values%'";
                                }
                            }
                        } elseif ($i == 2) {
                            foreach ($itemArr as $values) {
                                $criteria .= " AND (state LIKE '%$values%'";
                            }
                        } elseif ($i == 3) {
                            foreach ($itemArr as $values) {
                                $criteria .= " OR city LIKE '%$values%'";
                            }
                        }
                    } if ($i > 1) {
                        $criteria .= ")";
                    }
                } else {
                    $valArr = explode(" ", $val);
                    foreach ($valArr as $item) {
                        $j++;
                        if ($j == 1) {
                            $criteria .= "country LIKE '%$item%' OR state LIKE '%$item%' OR city LIKE '%$item%'";
                        }
                    }
                }
            } elseif ($filter == "gender") {
                $criteria = "gender = '$val'";
            } elseif ($filter == "date") {
                $criteria = "DATE(posted_date) = '$val'";
            } elseif ($filter == "genre") {
                $criteria = "genre like '%$val%'";
            } else {
                $criteria = "";
            } 
            $whereCon = ($criteria != "") ? " AND (" . $criteria." )" : "";
            $whereCountCon = ($criteria != "") ? " WHERE (" . $criteria  . " )": "";
            $jobObj = new Job();
            $jobAllJobCount = $jobObj->getAllJobCount($whereCountCon);
            $jobDetails = $jobObj->getJobDetails($from, $to, $whereCon);
            $applied_job_ids = $jobObj->getAppliedJobIds($userID);
            for ($i = 0; $i < count($jobDetails); $i++) {
                if (array_search($jobDetails[$i]["job_id"], $applied_job_ids) === FALSE) {
                    $jobDetails[$i]["applied"] = "0";
                } else {
                    $jobDetails[$i]["applied"] = "1";
                }
            } if (empty($jobDetails)) {
                echo json_encode(array("error" => "No results", "code" => "0"));
            } else {
                echo str_replace("\/", "/", json_encode(array("job" => $jobDetails, "code" => "1","count"=>$jobAllJobCount)));
            }
        } else {
            echo json_encode(array("error" => "Access Token Invalid", "code" => "0"));
        } 
        
        break;
        
    case "apply_job":
        $jobID = isset($_POST["job_id"]) ? $_POST["job_id"] : "";
        $userID = isset($_POST["user_id"]) ? $_POST["user_id"] : "";
        $note = isset($_POST["note"]) ? $_POST["note"] : "";
        $picIds = isset($_POST["pics"]) ? $_POST["pics"] : "";
        if ($picIds == "" || $picIds[0] == 0) {
            $picIdsArray = array();
        } else {
            $picIdsArray = explode(",", $picIds);
        } if ($jobID == "" || $userID == "") {
            echo json_encode(array("error" => "Job ID or User ID is missing", "code" => "0"));
            exit();
        } $jobObj = new Job();
        $applied_job_ids = $jobObj->getAppliedJobIds($userID);
        if (!(array_search($jobID, $applied_job_ids) === FALSE)) {
            echo json_encode(array("error" => "Job already applied", "code" => "0"));
        } else {
            $jobObj->applyJob($jobID, $userID, $note, $picIdsArray);
            $settings = $jobObj->getJobSettingsData($jobID);
            $userObj = new User();
            $emailArr = $userObj->getCDProfileData($userID);
            if(!empty($settings["email_setting"])) {                                
                $emailArr = $userObj->getCDProfileData($userID);
                $param = new stdClass();
                $param->sendTo = $emailArr['email'];
                $param->subject = $settings['email_setting']['subject'];
                $param->content = $settings['email_setting']['message'];                
                $commonObj = new Common();
                $commonObj->sendMailFunction($param);
            }
            
            if(!empty($settings["receive_confirmation_setting"])) {
                $userObj = new User();                
                $param1 = new stdClass();
                $param1->sendTo = $settings['receive_confirmation_setting']['email_id'];
                $param1->subject = "{$emailArr['firstName']} has applied to your Job";
                $param1->content = "{$emailArr['firstName']} has applied to your Job";
                $commonObj = new Common();
                $commonObj->sendMailFunction($param1);
            }
            
            echo json_encode(array("log" => "Job applied successfully", "code" => "1"));
        }
        
        break;
        
    case "job_history":
        $userID = isset($_POST["user_id"]) ? $_POST["user_id"] : "";
        $jobObj = new Job();
        $jobDetails = $jobObj->getJobHistory($userID);
        for ($i = 0; $i < count($jobDetails); $i++) {
            $jobDetails[$i]["applied"] = "1";
        } if (!empty($jobDetails)) {
            $web_url = "$WEB_URL/casting_mobile/images";
            echo str_replace("WEB_URL", $web_url, str_replace("\/", "/", json_encode(array("job" => $jobDetails, "code" => "1"))));
        } else {
            echo json_encode(array("error" => "No Jobs found", "code" => "0"));
        } 
        
        break;
        
    case "profile_data":
        $accessToken = isset($_POST["accessToken"]) ? $_POST["accessToken"] : "";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if ($userID != "-1") {
            $details = $userObj->getProfileData($userID);
            $details["code"] = "1";
            echo str_replace("\/", "/", json_encode($details));
        } else {
            echo json_encode(array("error" => "Invalid Access Token", "code" => "0"));
        } 
        
        break;
        
    case "upload_file":
        $accessToken = isset($_POST["accessToken"]) ? $_POST["accessToken"] : "";
        $type = isset($_POST["file_type"]) ? $_POST["file_type"] : "";
        $file = isset($_FILES["file"]) ? $_FILES["file"] : "";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if ($userID != "-1") {
            $commObj = new Common();
            $filename = $commObj->uploadFile($file, $userID, $type);
            if ($filename == "-1") {
                echo json_encode(array("error" => "Unable to save file", "code" => "0"));
            } else {
                $id = $commObj->updateFilenameInDB($filename, $type, $userID);
                if ($id['file_id'] != "-1") {
                    if ($type == "images") {
                        $web_url = "$WEB_URL/casting_mobile/images";
                    } elseif ($type == "videos") {
                        $web_url = "$WEB_URL/casting_mobile/videos";
                    } elseif ($type == "resumes") {
                        $web_url = "$WEB_URL/casting_mobile/";
                    }

                    $id['path'] = str_replace("WEB_URL", $web_url, $id['path']);
                    echo str_replace("\/", "/", json_encode(array("log" => $id, "code" => "1")));
                } else {
                    echo json_encode(array("error" => "Unable to update database", "code" => "0"));
                }
            }
        } else {
            echo json_encode(array("error" => "Invalid Access token", "code" => "0"));
        } 
        
        break;
        
    case "add_video_link":
        $accessToken = isset($_POST["accessToken"]) ? $_POST["accessToken"] : "";
        $video_link = isset($_POST["videoLink"]) ? $_POST["videoLink"] : "";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if ($userID != "-1") {
            $commObj = new Common();
            $result = $commObj->addVideoLink($video_link,$userID);
            if ($result == 0) {
                echo json_encode(array("error" => "Link not acceptable", "code" => "0"));
            } else {
            echo str_replace("\/", "/",json_encode($result));
            }
        } else {
            echo json_encode(array("error" => "Invalid Access token", "code" => "0"));
        } 
        
        break;
        
    case "edit_profile":
        $accessToken = isset($_POST["accessToken"]) ? $_POST["accessToken"] : "";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if ($userID != "-1") {
            $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : "";
            $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : "";
            $phone = isset($_POST["phone"]) ? $_POST["phone"] : "";
            $email = isset($_POST["email"]) ? $_POST["email"] : "";
            $skypeID = isset($_POST["skypeID"]) ? $_POST["skypeID"] : "";
            $bio = isset($_POST["bio"]) ? $_POST["bio"] : "";
            $gender = isset($_POST["gender"]) ? $_POST["gender"] : "";
            $profilePic = isset($_FILES["file"]) ? $_FILES["file"] : array();
            if ($firstname == "" || $email == "" || $gender == "") {
                echo json_encode(array("error" => "Invalid parameters", "code" => "0"));
                exit();
            } 
            $profilePicPath = "";
            if (strtoupper($gender) == "MALE" || strtoupper($gender) == "FEMALE") {
                if (!(empty($profilePic) || $profilePic["name"] == "" || $profilePic == "")) {
                    $commObj = new Common();
                    $filename = $commObj->uploadFile($profilePic, $userID, "profile_pics");
                    if ($filename == "-1") {
                        echo json_encode(array("error" => "Unable to upload profile pic", "code" => "0"));
                        exit();
                    } 
                    $profilePicPath = "WEB_URL/profile_pics/" . $filename;
                } 
                $userObj->updateProfile($firstname,$lastname, $phone, $email, $skypeID, $bio, $gender, $userID, $profilePicPath);
                $socialLinks = isset($_POST["socialLinks"]) ? $_POST["socialLinks"] : "";
                $socialLinksArr = explode("!@#", $socialLinks);
                $count = count($socialLinksArr);
                $userObj->deleteSocialLinks($userID);
                for ($i = 0; $i < $count; $i++) {
                    $link = $socialLinksArr[$i];
                    if ($link == "") {
                        continue;
                    } $userObj->insertSocialLinks($userID, $link);
                } $details = $userObj->getProfileData($userID);
                $details["code"] = "1";
                echo str_replace("\/", "/", json_encode($details));                /* echo json_encode(array("log"=>"Profile Updated","code"=>"1")); */
            } else {
                echo json_encode(array("error" => "Invalid value for gender", "code" => "0"));
            }
        } else {
            echo json_encode(array("error" => "Invalid Access Token", "code" => "0"));
        } 
        
        break;
        
    case "account_settings":
        $accessToken = isset($_POST['accessToken']) ? $_POST['accessToken'] : "";
        $oldPass = isset($_POST['oldPass']) ? $_POST['oldPass'] : "";
        $userObj = new User();
        $userID = $userObj->authenticateUser($accessToken, $oldPass, -1);
        if ($userID == "-1") {
            echo json_encode(array("error" => "Incorrect Password", "code" => "0"));
        } else {
            $newPass = isset($_POST["newPass"]) ? $_POST["newPass"] : "";
            if ($newPass == "") {
                echo json_encode(array("error" => "New Password cannot be empty", "code" => "0"));
            } else {
                $userObj->updatePassword($accessToken, $newPass);
                echo json_encode(array("log" => "Password updated successfully", "code" => "1"));
            }
        } 
        
        break;
        
    case "delete_file":
        $accessToken = isset($_POST['accessToken']) ? $_POST['accessToken'] : "";
        $file_id = isset($_POST['file_id']) ? $_POST['file_id'] : "";
        $type = isset($_POST['file_type']) ? $_POST['file_type'] : "";
        if ($file_id == "") {
            echo json_encode(array("error" => "File ID cannot be empty", "code" => "0"));
        } else {
            $commObj = new Common();
            $commObj->deleteFile($file_id, $accessToken, $type);
            echo json_encode(array("log" => "File Deleted", "code" => "1"));
        } 
        
        break;
        
    case "search_jobs_single_params":
        $accessToken = isset($_POST['accessToken']) ? $_POST['accessToken'] : "";
        $val = isset($_POST["val"]) ? $_POST["val"] : "";
        $from = (isset($_POST['from']) || $_POST['from'] != "") ? ($_POST['from'] * 10) : "0";
        $to = $from + 10;
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        $criteria = '';
        if ($userID != -1) {

            $valArr = explode(" ", trim($val));
            $count = count($valArr);
            $i = 0;
            foreach ($valArr as $item) {
                if ($item != '') {
                    $criteria .= " job_title LIKE '%$item%' OR job_description LIKE '%$item%' OR job_email LIKE '%$item%' OR phone LIKE '%$item%' OR gender LIKE '%$item%' OR genre LIKE '%$item%' OR weblink LIKE '%$item%' OR rate LIKE '%$item%' OR posted_date LIKE '%$item%' OR country LIKE '%$item%' OR state LIKE '%$item%' OR city LIKE '%$item%'";
                    $i++;
                    if ($i < $count) {
                        $criteria .= " OR ";
                    }
                }
            }
            $whereCon = ($criteria != "") ? " AND (" . $criteria . ") AND (status = 1)" : "";
            $whereCountCon = ($criteria != "") ? " WHERE (" . $criteria . ") AND (status = 1)" : "";
            $jobObj = new Job();
            $jobAllJobCount = $jobObj->getAllJobCount($whereCountCon);
            $jobDetails = $jobObj->getJobDetails($from, $to, $whereCon);
            $applied_job_ids = $jobObj->getAppliedJobIds($userID);
            for ($i = 0; $i < count($jobDetails); $i++) {
                if (array_search($jobDetails[$i]["job_id"], $applied_job_ids) === FALSE) {
                    $jobDetails[$i]["applied"] = "0";
                } else {
                    $jobDetails[$i]["applied"] = "1";
                }
            } if (empty($jobDetails)) {
                echo json_encode(array("error" => "No results", "code" => "0"));
            } else {
                echo str_replace("\/", "/", json_encode(array("job" => $jobDetails, "code" => "1","count"=>$jobAllJobCount)));
            }
        } else {
            echo json_encode(array("error" => "Access Token Invalid", "code" => "0"));
        } 
        
        break;
        
    case "inbox":
        $accessToken = isset($_POST['accessToken'])?$_POST['accessToken']:"";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);        
        if($userID != "-1") {
            $messageObj = new Message();
            $details = $messageObj->getInboxMessages($userID);            
            echo json_encode($details);
        } else {
            echo json_encode(array("error"=>"Access Token invalid","code"=>"0"));
        }
        
        break;
    
    case "create_message":
        $subject = isset($_POST['subject'])?$_POST['subject']:"";
        $from_id = isset($_POST['from_id'])?$_POST['from_id']:"";
        $to_id = isset($_POST['to_id'])?$_POST['to_id']:"";
        $body = isset($_POST['body'])?$_POST['body']:"";
        
        $messageObj = new Message();
        $header_id = $messageObj->insertMessageHeader($subject, $from_id, $to_id);        
        $messageObj->insertMessages($header_id, $from_id, $body);
        echo json_encode(array("log"=>"Message created successfully","message_id"=>$header_id,"code"=>"1"));
        
        break;
    
    case "send_message":
        $message_id = isset($_POST['message_id'])?$_POST['message_id']:"";
        $body = isset($_POST['body'])?$_POST['body']:"";
        $from_id = isset($_POST['from_id'])?$_POST['from_id']:"";
        
        $messageObj = new Message();
        $messageObj->insertMessages($message_id, $from_id, $body);
        echo json_encode(array("log"=>"Message inserted successfully","code"=>"1"));
        break;
    
    case "get_messages":
        $messageID = isset($_POST['message_id'])?$_POST['message_id']:"";
        $accessToken = isset($_POST['accessToken'])?$_POST['accessToken']:"";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if($userID != "-1") {
            $messageObj = new Message();
            $conversation = $messageObj->getConversation($userID, $messageID);
            $messageObj->updateReadStatus($userID, $messageID);
            echo json_encode(array("conversation"=>$conversation,"code"=>"1"));
        } else {
            echo json_encode(array("error"=>"Invalid access token","code"=>"0"));
        }
    
        break;
        
    case "create_job";
        $accessToken = isset($_POST["accessToken"])?$_POST["accessToken"]:"";
        $userObj = new User();
        
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if($userID == "-1") {
            echo json_encode(array("code"=>"0","log"=>"Invalid access token"));
            exit();
        }
        $job_title = isset($_POST["job_title"])?$_POST["job_title"]:"";
        $job_icon = isset($_FILES['job_icon'])?$_FILES['job_icon']:"";
        $job_description = isset($_POST['job_description'])?$_POST['job_description']:"";
        $job_email = isset($_POST['job_email'])?$_POST['job_email']:"";
        $phone = isset($_POST['phone'])?$_POST['phone']:"" ;
        $weblink = isset($_POST['weblink'])?$_POST['weblink']:"";
        $country = isset($_POST['country'])?$_POST['country']:"";
        $state = isset($_POST['state'])?$_POST['state']:"";
        $city = isset($_POST['city'])?$_POST['city']:"";
        $gender = isset($_POST['gender'])?$_POST['gender']:"";
        $genre = isset($_POST['genre'])?$_POST['genre']:"";
        $rate = isset($_POST['rate'])?$_POST['rate']:"";
        $commObj = new Common();
        $path = $commObj->uploadFile($job_icon, $userID, "job_icon");
        if($path != "") {
            $path = "WEB_URL/".$path;
        }
        $jobObj = new Job();
        $jobID = $jobObj->createJob($job_title, $path, $job_description, $job_email, $phone, $weblink, $country, $state, $city, $gender, $genre, $rate);
        $jobObj->createJobXref($userID, $jobID);
        $settings['job_id'] = $jobID;
        $settings['send_confirmation'] = "0";
        $settings['receive_confirmation'] = "0";
        $settings['set_expiry'] = "0";
        $jobObj->insertJobSettings($settings);
        
        echo json_encode(array("code"=>"1","log"=>"Job created successfully"));
        break;
        
    case "get_applicants":
        
        $accessToken = isset($_POST['accessToken'])?$_POST['accessToken']:"";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if($userID != "-1") {
            $jobID = isset($_POST['jobID'])?$_POST['jobID']:"";
            $jobObj = new Job();
            $recentApplicants = $jobObj->getRecentApplicants(array($jobID), 0);
            echo json_encode($recentApplicants);
        } else {
            echo json_encode(array("error"=>"Access token invalid","code"=>"0"));
        }
        
        break;
        
    case "create_company":
        $accessToken = isset($_POST['accessToken'])?$_POST['accessToken']:"";
        $name = isset($_POST['name'])?$_POST['name']:"";
        $logo = isset($_FILES['logo'])?$_FILES['logo']:"";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if($userID != "-1") {
            $commObj = new Common();
            $path = $commObj->uploadFile($logo, $userID, "company_logo");
            $jobObj = new Job();
            $jobObj->createCompany($userID, $name, "WEB_URL/".$path);
            echo json_encode(array("log"=>"Job created","code"=>"1"));
        } else {
            echo json_encode(array("error"=>"Access token invalid","code"=>"0"));
        }
        
        break;
        
    case "get_job_settings":
        $accessToken = isset($_POST['accessToken'])?$_POST['accessToken']:"";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if($userID != "-1") {
            $job_id = isset($_POST['job_id'])?$_POST['job_id']:"";
            $jobObj = new Job();
            $job_setting = $jobObj->getJobSettingsData($job_id);
            echo json_encode($job_setting);
        } else {
            echo json_encode(array("error"=>"Access token invalid","code"=>"0"));
        }        
        
        break;
        
    case "update_job_settings":
        $accessToken = isset($_POST['accessToken'])?$_POST['accessToken']:"";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if($userID != "-1") {
            if($userObj->getUserType($userID) == 2) {
                $setting_id = isset($_POST['setting_id'])?$_POST['setting_id']:"";
                $send_confirmation = isset($_POST['send_confirmation'])?$_POST['send_confirmation']:"0";                
                $receive_confirmation = isset($_POST['receive_confirmation'])?$_POST['receive_confirmation']:"0";
                $set_expiry = isset($_POST['set_expiry'])?$_POST['set_expiry']:"0";
                
                if($setting_id == "") {
                    echo json_encode(array("error"=>"Setting ID cannot be empty","code"=>"0"));
                    exit();
                } 
                
                if($send_confirmation == 1) {
                    $from_email = isset($_POST['from_email'])?$_POST['from_email']:"";
                    $subject = isset($_POST['subject'])?$_POST['subject']:"";
                    $message = isset($_POST['message'])?$_POST['message']:"";
                    
                    if($from_email == "" || $subject == "" || $message == "") {
                        echo json_encode(array("error"=>"Fields are missing for send confirmation","code"=>"0"));
                        exit();
                    }
                } 
                
                if($receive_confirmation == 1) {
                    $email_id = isset($_POST['email_id'])?$_POST['email_id']:"";
                    if($email_id == "") {
                        echo json_encode(array("error"=>"Fields are missing for receive confirmation","code"=>"0"));
                        exit();
                    }
                }
                
                if($set_expiry == 1) {
                    $from_time = isset($_POST['from_time'])?$_POST['from_time']:"";
                    $to_time = isset($_POST['to_time'])?$_POST['to_time']:"";
                    if($from_time == "" || $to_time == "") {
                        echo json_encode(array("error"=>"Fields are missing for set expiry","code"=>"0"));
                        exit();
                    }                    
                }
                
                $jobObj = new Job();
                $settings['setting_id'] = $setting_id;
                $settings['send_confirmation'] = $send_confirmation;
                $settings['receive_confirmation'] = $receive_confirmation;
                $settings['set_expiry'] = $set_expiry;
                $jobObj->updateJobSettings($settings);
                
                if($send_confirmation == 1) {
                    
                    $jobObj->insertEmailSettings($setting_id, $from_email, $subject, $message);
                }
                
                if($receive_confirmation == 1) {
                    $jobObj->insertJobReceiveEmail($setting_id, $email_id);
                }
                
                if($set_expiry == 1) {
                    $jobObj->insertJobExpiry($setting_id, $from_time, $to_time);
                }
                
                echo json_encode(array("log"=>"Settings updated successfully", "code"=>"1"));
                
            } else {
                echo json_encode(array("error"=>"You are not authenticated to edit this job","code"=>"0"));
            }
            
        } else {
            echo json_encode(array("error"=>"Access token invalid","code"=>"0"));
        }
        
        break;
        
    case "search_applicants":
        
        $accessToken = isset($_POST['accessToken'])?$_POST['accessToken']:"";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if($userID != "-1") {
            if($userObj->getUserType($userID) == 2) {
                $keyword = isset($_POST['keyword'])?$_POST['keyword']:"";
                $keywordArr = explode(" ", trim($keyword));
                $filterType = isset($_POST['filterType'])?$_POST['filterType']:"";
                $filterText = isset($_POST['filterText'])?$_POST['filterText']:"";
                
                $count = count($keywordArr);
                $criteria = "";
                $i = 0;
                foreach ($keywordArr as $item) {
                    if ($item != '') {
                        $criteria .= " up.`firstName` LIKE '%$item%'
                                        OR
                                        up.`lastName` LIKE '%$item%'
                                        OR
                                        up.`phone` LIKE '%$item%'
                                        OR
                                        up.`email` LIKE '%$item%'
                                        OR
                                        up.`bio` LIKE '%$item%'";
                        $i++;
                        if ($i < $count) {
                            $criteria .= " OR ";
                        }
                    }
                }
                $whereCon = ($criteria != "") ? " OR (" . $criteria . ")" : "";
                $filter = "";
                if($filterType == 1) {
                    $filter = " AND ( UPPER(up.`gender`) = UPPER('$filterText') )";
                }
                
                $jobObj = new Job();
                $applicants = $jobObj->searchApplicants($userID, $keyword, $whereCon, $filter);
                $tagList = $jobObj->getTagList($userID);
                echo json_encode(array("applicants"=>$applicants,"tags"=>$tagList,"code"=>"1"));
            } else {
                echo json_encode(array("error"=>"You are not authenticated to search applicants","code"=>"0"));
            }
        } else {
            echo json_encode(array("error"=>"Access token invalid","code"=>"0"));
        }
        
        break;
        
    case "tag_search":
        
        $accessToken = isset($_POST['accessToken'])?$_POST['accessToken']:"";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if($userID != "-1") {
            if($userObj->getUserType($userID) == 2) {
                $tagName = isset($_POST['tagName'])?$_POST['tagName']:"";
                $jobObj = new Job();
                $applicants = $jobObj->tagSearch($userID, $tagName);
                $tagList = $jobObj->getTagList($userID);
                echo json_encode(array("applicants"=>$applicants,"tags"=>$tagList,"code"=>"1"));
        } else {
                echo json_encode(array("error"=>"You are not authenticated to search applicants","code"=>"0"));
            }
        } else {
            echo json_encode(array("error"=>"Access token invalid","code"=>"0"));
        }
        
        break;
       
    case "view_cd_profile":
        $accessToken = isset($_POST['accessToken'])?$_POST['accessToken']:"";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if($userID != "-1") {
            if($userObj->getUserType($userID) == 2) {
                $userDetails = $userObj->getCDProfileData($userID);
                $userDetails["profilePic"] = ($userDetails["profilePic"] == "") ? "$WEB_URL/casting_mobile/images/default.jpg" : str_replace("WEB_URL", "$WEB_URL/casting_mobile", $userDetails["profilePic"]);
                echo json_encode(array("details"=>$userDetails,"code"=>"1"));
            } else {
                echo json_encode(array("error"=>"You are not authenticated to search applicants","code"=>"0"));
            }        
        } else {
            echo json_encode(array("error"=>"Access token invalid","code"=>"0"));
        }
        
        break;
        
    case "update_cd_profile":
    
        $accessToken = isset($_POST['accessToken'])?$_POST['accessToken']:"";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if($userID != "-1") {
            if($userObj->getUserType($userID) == 2) {
                $firstName = isset($_POST['firstName'])?$_POST['firstName']:"";
                $lastName = isset($_POST['lastName'])?$_POST['lastName']:"";
                $phone = isset($_POST['phone'])?$_POST['phone']:"";
                $email = isset($_POST['email'])?$_POST['email']:"";
                $gender = isset($_POST['gender'])?$_POST['gender']:"";
                $profilePic = isset($_FILES["file"]) ? $_FILES["file"] : array();
                $profilePicPath = "";
                if (!(empty($profilePic) || $profilePic["name"] == "" || $profilePic == "")) {
                    $commObj = new Common();
                    $filename = $commObj->uploadFile($profilePic, $userID, "profile_pics");
                    if ($filename == "-1") {
                        echo json_encode(array("error" => "Unable to upload profile pic", "code" => "0"));
                        exit();
                    } 
                    $profilePicPath = "WEB_URL/profile_pics/" . $filename;
                } 
                $userDetails = $userObj->setCDProfileData($firstName, $lastName, $profilePicPath, $phone, $email, $gender, $userID);
                echo str_replace("WEB_URL", "$WEB_URL/casting_mobile",json_encode(array("log"=>"Details updated successfully","profilePic"=>$profilePicPath,"code"=>"1")));
            } else {
                echo json_encode(array("error"=>"You are not authenticated to search applicants","code"=>"0"));
            }        
        } else {
            echo json_encode(array("error"=>"Access token invalid","code"=>"0"));
        }
        
        break;
        
    case "getCountry":
        $commObj = new Common();
        echo json_encode($commObj->getCountry());
        
        break;
    
    case "getState":
        $commObj = new Common();
        $countryCode = isset($_POST['countryCode'])?$_POST['countryCode']:"";
        echo json_encode(array("states"=>$commObj->getState($countryCode)));
        
        break;
        
    case "getCity":
        $commObj = new Common();
        $countryCode = isset($_POST['countryCode'])?$_POST['countryCode']:"";
        $state = isset($_POST['state'])?$_POST['state']:"";
        echo json_encode(array("cities"=>$commObj->getCity($countryCode, $state)));
        
        break;
        
    case "view_applicant_profile":
        $accessToken = isset($_POST["accessToken"]) ? $_POST["accessToken"] : "";
        $userID = isset($_POST["userID"])?$_POST["userID"]:"";
        $jobID = isset($_POST["jobID"])?$_POST["jobID"]:"";
        $userObj = new User();
        
        if ($userObj->getUserIDFromAccToken($accessToken) != "-1") {
            $details = $userObj->getProfileData($userID,$jobID);
            $details["code"] = "1";
            echo str_replace("\/", "/", json_encode($details));
        } else {
            echo json_encode(array("error" => "Invalid Access Token", "code" => "0"));
        } 
        break;
        
        
    case "add_tag":
        $userID = isset($_POST["userID"])?$_POST["userID"]:"";
        $tagName = isset($_POST["tagName"])?$_POST["tagName"]:"";
        if(trim($tagName) == "" || $tagName == NULL) {
            echo json_encode(array("error"=>"Tag name cannot be blank","code"=>"0"));
            die();
        }
        $accessToken = isset($_POST['accessToken'])?$_POST['accessToken']:"";
        $userObj = new User();
        
        $loggedUserID = $userObj->getUserIDFromAccToken($accessToken);
        if($loggedUserID != "-1") {
            if($userObj->getUserType($loggedUserID) == 2) {        
                $jobObj = new Job();
                $tag_id = $jobObj->addTag($tagName, $userID);
                echo json_encode(array("log"=>"Tag added successfully","code"=>"1","tag_id"=>$tag_id));
            } else {
                   echo json_encode(array("error"=>"You are not authenticated to add tags","code"=>"0"));
               }        
        } else {
            echo json_encode(array("error"=>"Access token invalid","code"=>"0"));
        }    
        
        break;
    
    case "delete_tag":
        $userID = isset($_POST["userID"])?$_POST["userID"]:"";
        $tagName = isset($_POST["tagName"])?$_POST["tagName"]:"";
        if(trim($tagName) == "" || $tagName == NULL) {
            echo json_encode(array("error"=>"Tag name cannot be blank","code"=>"0"));
            die();
        }
        $accessToken = isset($_POST['accessToken'])?$_POST['accessToken']:"";
        $userObj = new User();    
        $loggedUserID = $userObj->getUserIDFromAccToken($accessToken);
        if($loggedUserID != "-1") {
            if($userObj->getUserType($loggedUserID) == 2) {        
                $jobObj = new Job();
                $tag_id = $jobObj->deleteTag($userID, $tagName);
                echo json_encode(array("log"=>"Tag deleted successfully","code"=>"1"));
            } else {
                   echo json_encode(array("error"=>"You are not authenticated to delete tags","code"=>"0"));
               }        
        } else {
            echo json_encode(array("error"=>"Access token invalid","code"=>"0"));
        }    
        
        break;
        
    case "get_tags":
        
        $accessToken = isset($_POST['accessToken'])?$_POST['accessToken']:"";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if($userID != "-1") {
            if($userObj->getUserType($userID) == 2) {                
                $jobObj = new Job();                
                $tagList = $jobObj->getTagList($userID);
                echo json_encode(array("tags"=>$tagList,"code"=>"1"));
        } else {
                echo json_encode(array("error"=>"You are not authenticated to search applicants","code"=>"0"));
            }
        } else {
            echo json_encode(array("error"=>"Access token invalid","code"=>"0"));
        }
        
        break;
        
        
    case "update_job";
        $accessToken = isset($_POST["accessToken"])?$_POST["accessToken"]:"";
        $userObj = new User();
        
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if($userID == "-1") {
            echo json_encode(array("code"=>"0","log"=>"Invalid access token"));
            exit();
        }
        $job_title = isset($_POST["job_title"])?$_POST["job_title"]:"";
        $job_icon = isset($_FILES['job_icon'])?$_FILES['job_icon']:"";
        $job_description = isset($_POST['job_description'])?$_POST['job_description']:"";
        $job_email = isset($_POST['job_email'])?$_POST['job_email']:"";
        $phone = isset($_POST['phone'])?$_POST['phone']:"" ;
        $weblink = isset($_POST['weblink'])?$_POST['weblink']:"";
        $country = isset($_POST['country'])?$_POST['country']:"";
        $state = isset($_POST['state'])?$_POST['state']:"";
        $city = isset($_POST['city'])?$_POST['city']:"";
        $gender = isset($_POST['gender'])?$_POST['gender']:"";
        $genre = isset($_POST['genre'])?$_POST['genre']:"";
        $rate = isset($_POST['rate'])?$_POST['rate']:"";
        $job_id = isset($_POST['job_id'])?$_POST['job_id']:"";
        $commObj = new Common();
        $path = $commObj->uploadFile($job_icon, $userID, "job_icon");
        if($path != "") {
            $path = "WEB_URL/".$path;
        }
        $jobObj = new Job();
        $jobID = $jobObj->updateJob($job_title, $path, $job_description, $job_email, $phone, $weblink, $country, $state, $city, $gender, $genre, $rate, $job_id);
                
        echo json_encode(array("code"=>"1","log"=>"Job updated successfully"));
        break;
        
    case "get_job_data":
        $accessToken = isset($_POST['accessToken'])?$_POST['accessToken']:"";
        $jobID = isset($_POST['jobID'])?$_POST['jobID']:"";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if($userID != "-1") {
            if($userObj->getUserType($userID) == 2) {                
                $jobObj = new Job();                
                $jobData = $jobObj->getJobData($jobID);
                echo json_encode(array("data"=>$jobData,"code"=>"1"));
        } else {
                echo json_encode(array("error"=>"You are not authenticated to view job details","code"=>"0"));
            }
        } else {
            echo json_encode(array("error"=>"Access token invalid","code"=>"0"));
        }
        
        break;
        
    case "delete_job":
        $accessToken = isset($_POST['accessToken'])?$_POST['accessToken']:"";
        $jobID = isset($_POST['jobID'])?$_POST['jobID']:"";
        $userObj = new User();
        $userID = $userObj->getUserIDFromAccToken($accessToken);
        if($userID != "-1") {
            if($userObj->getUserType($userID) == 2) {                
                $jobObj = new Job();                
                $jobData = $jobObj->deleteJob($jobID,$userID);
                echo json_encode(array("log"=>"Job deleted successfully","code"=>"1"));
        } else {
                echo json_encode(array("error"=>"You are not authenticated to delete this job","code"=>"0"));
            }
        } else {
            echo json_encode(array("error"=>"Access token invalid","code"=>"0"));
        }
        
        break;
        
    case "forgot_password":

        $userName = isset($_POST['userName'])?$_POST['userName']:"";
        $userObj = new User();
        $detailsArr = $userObj->checkEmail($userName);
        if(!isset($detailsArr['userID'])) {
            echo json_encode(array("error"=>"Username not found","code"=>"0"));
            exit();
        }
        $commObj = new Common();
        $token = $commObj->insertForgotPasswordToken($detailsArr['userID']);
        $param = new stdClass();
        
        $param->sendTo = $userName;
        $param->subject = "Reset Password - castingdb.net";
        $param->content = "<b>Hi {$detailsArr['firstName']},</b><br /><br /><p>Please click on the link below to reset your password.<br /> <a href='$WEB_URL/castingdb_web/forgot_password.php?token=$token'>$WEB_URL/castingdb_web/forgot_password.php?token=$token</a></p><br />Thanks,<br />Admin - castingdb.net";                
        $commonObj = new Common();
        $commonObj->sendMailFunction($param);
        echo json_encode(array("log"=>"Email sent","code"=>"1"));
        
        break;
        
    case "check_token_validity":
        $token = isset($_POST['token'])?$_POST['token']:"";
        $userObj = new User();
        $userID = $userObj->checkTokenValidity($token);
        if($userID == "-1") {
            echo json_encode(array("error"=>"Token is invalid or has expired","code"=>"0"));
        } else {
            echo json_encode(array("log"=>"Token is valid","code"=>"1"));
        }
        
        break;
        
    case "reset_password":
        $token = isset($_POST['token'])?$_POST['token']:"";
        $password = isset($_POST['password'])?$_POST['password']:"";
        if($password == "" || $password == NULL) {
            echo json_encode(array("error"=>"Password cannot be empty","code"=>"0"));
        }
        $userObj = new User();
        $userID = $userObj->checkTokenValidity($token);
        if($userID == "-1") {
            echo json_encode(array("error"=>"Token is invalid or has expired","code"=>"0"));
        } else {
            $userObj->resetPassword($userID, $password);
            echo json_encode(array("log"=>"Password has been updated","code"=>"1"));
        }
        
        break;

    default: 
        echo "Default";
        break;
}

