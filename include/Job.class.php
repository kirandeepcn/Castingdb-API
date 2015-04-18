<?php

/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

/**

 * Description of Job

 *

 * @author KDS

 */
class Job extends WebConstants{

    protected $con;

    function __construct() 
    {

        $this->con = new Connection();
    }

    function getJobDetails($from = 0, $to = 10, $filter = "") 
    {
        global $WEB_URL;

        $query = "SELECT `userID`,`job_id`, `job_title`, `job_icon`, `job_description`, `job_email`, `phone`, `weblink`, `country`, `state`, `city`, `rate`, `posted_date` FROM `Jobs`,`Job_Owner_Xref` WHERE `job_id` = `jobID` $filter ORDER BY `posted_date` DESC LIMIT $from,$to";
        
        $qh = $this->con->getQueryHandler($query);

        $job_details = array();

        while ($res = $qh->fetch(PDO::FETCH_ASSOC)) {

            $res["job_icon"] = ($res["job_icon"] == "") ? "$WEB_URL/casting_mobile/images/casting.jpg" : $res["job_icon"];
            $res["job_icon"] = str_replace("WEB_URL", "$WEB_URL/casting_mobile/job_icon/", $res["job_icon"]);

            $job_details[] = $res;
        }
        
        return $job_details;
    }

    function getAllJobCount($filter = "") 
    {

        $query = "SELECT COUNT(`job_id`) FROM `Jobs` $filter ORDER BY `posted_date` DESC";

        $qh = $this->con->getQueryHandler($query);

        $data = $qh->fetch(PDO::FETCH_NUM);

        return $data[0];
    }

    function applyJob($jobID, $userID, $note, $picsArray = array()) 
    {

        $query = "INSERT INTO `Job_Applications`(`jobID`, `userID`, `note`,`applied_date`) VALUES (:jobid,:userid,:note,UTC_TIMESTAMP())";

        $bindParams = array("jobid" => $jobID, "userid" => $userID, "note" => $note);

        $id = $this->con->insertQuery($query, $bindParams);



        if (!empty($picsArray)) {

            $this->insertPicsForCastingDirector($jobID, $userID, $picsArray);
        }



        return $id;
    }

    function getJobHistory($userID, $from = 0, $to = 10) 
    {
        global $WEB_URL;
        $query = "SELECT `Job_Owner_Xref`.`userID`,`job_id`, `job_title`, `job_icon`, `job_description`, `job_email`, `phone`, `weblink`, `country`, `state`, `city`, `rate`, `posted_date`,`note` FROM `Jobs`,`Job_Applications` ,`Job_Owner_Xref` WHERE `job_id` IN (SELECT jobID FROM `Job_Applications` WHERE `Job_Applications`.`userID` = :userID ) and `Jobs`.job_id = `Job_Applications`.jobID and `Job_Applications`.`userID` = :userID and `Job_Owner_Xref`.jobID = `Jobs`.`job_id` ORDER BY `posted_date` DESC"; //LIMIT $from,$to";               

        $bindParams = array("userID" => $userID);

        $qh = $this->con->getQueryHandler($query, $bindParams);

        $job_details = array();

        while ($res = $qh->fetch(PDO::FETCH_ASSOC)) {

            $res["job_icon"] = ($res["job_icon"] == "") ? "$WEB_URL/casting_mobile/images/casting.jpg" : $res["job_icon"];
            $res["job_icon"] = str_replace("WEB_URL", "$WEB_URL/casting_mobile/job_icon/", $res["job_icon"]);

            $query_pics = "SELECT `pic_id`, `path` FROM `User_Pics` WHERE `pic_id` IN (SELECT `picID` FROM `Job_Applied_Pics` WHERE `jobID` = :jobID and `userID` = :userID)";

            $bindParams_pics = array("jobID" => $res['job_id'], "userID" => $userID);

            $qh_pics = $this->con->getQueryHandler($query_pics, $bindParams_pics);

            $res["pics"] = array();

            while ($res_pics = $qh_pics->fetch(PDO::FETCH_ASSOC)) {

                $res["pics"][] = $res_pics;
            }

            $job_details[] = $res;
        }

        return $job_details;
    }

    function getAppliedJobIds($userID) 
    {

        $query = "SELECT `jobID` FROM `Job_Applications` WHERE `userID` = :userID";

        $bindParams = array("userID" => $userID);

        $qh = $this->con->getQueryHandler($query, $bindParams);

        $job_ids = array();

        while ($res = $qh->fetch(PDO::FETCH_ASSOC)) {

            $job_ids[] = $res['jobID'];
        }

        return $job_ids;
    }

    function insertPicsForCastingDirector($jobID, $userID, $picIds = array()) 
    {

        $id = "-1";

        foreach ($picIds as $picID) {

            $query = "INSERT INTO `Job_Applied_Pics`(`jobID`, `userID`, `picID`) VALUES (:jobID,:userID,:picID)";

            $bindParams = array("jobID" => $jobID, "userID" => $userID, "picID" => $picID);

            $id = $this->con->insertQuery($query, $bindParams);
        }

        return $id;
    }
    
    function getCastingDirectorJobIds($userID)
    {
        $query = "SELECT `jobID` FROM `Job_Owner_Xref` WHERE `userID` = :userID";

        $bindParams = array("userID" => $userID);

        $qh = $this->con->getQueryHandler($query, $bindParams);
        $jobID = array();
        while ($res = $qh->fetch(PDO::FETCH_ASSOC)) {

            $jobID[] = $res['jobID'];
        }
        
        return $jobID;
    }
    
    function getCastingJobDetails($jobID = array())
    {
        global $WEB_URL;
        $query = "SELECT `job_id`, `job_title`, `job_icon` FROM `Jobs` WHERE `job_id` IN (".implode(",", $jobID).")";

        $bindParams = array();

        $qh = $this->con->getQueryHandler($query, $bindParams);
        $jobs = array();
        while ($res = $qh->fetch(PDO::FETCH_ASSOC)) {
            $res["job_icon"] = str_replace("WEB_URL", "$WEB_URL/casting_mobile/job_icon/", $res["job_icon"]);
            $jobs[$res['job_id']] = $res;
        }
        
        $jobsCount = $this->getCountOfApplicants($jobID);
        
        foreach ($jobID as $id)
        {
            $jobs[$id]['jobCount'] = isset($jobsCount[$id])?$jobsCount[$id]:0;
        }
        
        return array_values($jobs);
    }
    
    function getCountOfApplicants($jobID = array())
    {
        $query = "SELECT `jobID`,COUNT(`userID`) as jobCount FROM `Job_Applications` WHERE `jobID` IN (".implode(",", $jobID).") GROUP BY `jobID`";

        $bindParams = array();

        $qh = $this->con->getQueryHandler($query, $bindParams);
        $jobsCount = array();
        while ($res = $qh->fetch(PDO::FETCH_ASSOC)) {

            $jobsCount[$res['jobID']] = $res['jobCount'];
        }
        
        return $jobsCount;
    }
    
    function getRecentApplicants($jobID, $limit)
    {
        global $WEB_URL;
        $limitTxt = ($limit == 0)?"":"LIMIT ".$limit;
        $query = "SELECT ja.`userID`, j.`job_id` ,j.`job_title`,ja.`applied_date`,u.`firstname`,u.`lastname`,u.`profilePic` as profilePic FROM `Job_Applications` ja,`Jobs` j,`User_Profile` u WHERE (ja.`jobID` = j.`job_id` AND u.`userID` = ja.`userID`) AND ja.`jobID` IN(".  implode(",", $jobID).") ORDER BY ja.`applied_date` DESC $limitTxt";
        $bindParams = array();

        $qh = $this->con->getQueryHandler($query, $bindParams);
        $applicants = array();
        while ($res = $qh->fetch(PDO::FETCH_ASSOC)) {
             $res["profilePic"] = ($res["profilePic"] == "") ? "$WEB_URL/casting_mobile/images/default.jpg" : str_replace("WEB_URL", "$WEB_URL/casting_mobile", $res["profilePic"]);
            $applicants[] = $res;
        }
        return $applicants;
    }
    
    function createJob($job_title,$job_icon,$job_description,$job_email,$phone,$weblink,$country,$state,$city,$gender,$genre,$rate)
    {
        $query = "INSERT INTO `Jobs`(`job_title`, `job_icon`, `job_description`, `job_email`, `phone`, `weblink`, `country`, `state`, `city`, `gender`, `genre`, `rate`, `posted_date`, `status`) VALUES (:job_title,:job_icon,:job_description,:job_email,:phone,:weblink,:country,:state,:city,:gender,:genre,:rate,UTC_TIMESTAMP(),1)";

        $bindParams = array("job_title"=>$job_title,"job_icon"=>$job_icon,"job_description"=>$job_description,"job_email"=>$job_email,"phone"=>$phone,"weblink"=>$weblink,"country"=>$country,"state"=>$state,"city"=>$city,"gender"=>$gender,"genre"=>$genre,"rate"=>$rate);

        $id = $this->con->insertQuery($query, $bindParams);
        
        return $id;
    }
    
    function updateJob($job_title,$job_icon,$job_description,$job_email,$phone,$weblink,$country,$state,$city,$gender,$genre,$rate,$job_id)
    {
        $query = "UPDATE `jobs` SET `job_title`= :job_title,`job_icon`= :job_icon,`job_description`= :job_description,`job_email`= :job_email,`phone`= :phone,`weblink`= :weblink,`country`= :country,`state`= :state,`city`= :city,`gender`= :gender,`genre`= :genre,`rate`= :rate WHERE `job_id`= :job_id";

        $bindParams = array("job_title"=>$job_title,"job_icon"=>$job_icon,"job_description"=>$job_description,"job_email"=>$job_email,"phone"=>$phone,"weblink"=>$weblink,"country"=>$country,"state"=>$state,"city"=>$city,"gender"=>$gender,"genre"=>$genre,"rate"=>$rate, "job_id"=>$job_id);

        $id = $this->con->insertQuery($query, $bindParams);
        
        return $id;
    }
    
    function createJobXref($userID,$jobID)
    {
        $query = "INSERT INTO `Job_Owner_Xref`(`userID`, `jobID`) VALUES (:userID,:jobID)";

        $bindParams = array("userID"=>$userID,"jobID"=>$jobID);

        $id = $this->con->insertQuery($query, $bindParams);
        return $id;
    }
    
    function createCompany($userID,$name,$path)
    {
        $query = "INSERT INTO `Company_Details`( `name`, `logo_path`, `user_id`) VALUES (:name,:path,:userID)";

        $bindParams = array("name"=>$name,"userID"=>$userID,"path"=>$path);

        $id = $this->con->insertQuery($query, $bindParams);
        return $id;
    }
    
    function insertJobSettings($settings)
    {
        $query = "INSERT INTO `Job_Settings`(`job_id`, `send_confirmation`, `receive_confirmation`, `set_expiry`) VALUES (:job_id,:send_confirmation,:receive_confirmation,:set_expiry)";

       // $bindParams = array("job_id"=>$settings['job_id'],"send_confirmation"=>$settings['send_confirmation'],"receive_confirmation"=>$settings['receive_confirmation'],"set_expiry"=>$settings['receive_confirmation']);

        $id = $this->con->insertQuery($query, $settings);
        return $id;
    }
    
    function updateJobSettings($settings)
    {
        $query = "UPDATE `Job_Settings` SET `send_confirmation`=:send_confirmation,`receive_confirmation`=:receive_confirmation,`set_expiry`=:set_expiry WHERE `setting_id`=:setting_id";

        $id = $this->con->insertQuery($query, $settings);
        return $id;
    }
    
    function insertEmailSettings($setting_id,$from_email,$subject,$message)
    {
        
        $query = "SELECT COUNT(*) as `entry_count` FROM `Email_Settings` WHERE `setting_id` = :setting_id";

        $qh = $this->con->getQueryHandler($query,array("setting_id"=>$setting_id));

        $data = $qh->fetch(PDO::FETCH_NUM);
        
        if($data[0] == 0) {

            $query = "INSERT INTO `Email_Settings`(`setting_id`, `from_email`, `subject`, `message`) VALUES (:setting_id,:from_email,:subject,:message)";

            $bindParams = array("setting_id"=>$setting_id,"from_email"=>$from_email,"subject"=>$subject,"message"=>$message);

            $id = $this->con->insertQuery($query, $bindParams);
        } else {
            $query = "UPDATE `Email_Settings` SET `from_email`=:from_email,`subject`=:subject,`message`=:message WHERE `setting_id`=:setting_id";

            $bindParams = array("setting_id"=>$setting_id,"from_email"=>$from_email,"subject"=>$subject,"message"=>$message);

            $id = $this->con->insertQuery($query, $bindParams);
        }
        return $id;
    }
    
    function insertJobExpiry($setting_id,$from_time,$to_time)
    {
        $query = "SELECT COUNT(*) AS `entry_count` FROM `Job_Expiry` WHERE `setting_id` = :setting_id";

        $qh = $this->con->getQueryHandler($query,array("setting_id"=>$setting_id));

        $data = $qh->fetch(PDO::FETCH_NUM);
        
        if($data[0] == 0) {

            $query = "INSERT INTO `Job_Expiry`(`setting_id`, `from_time`, `to_time`) VALUES (:setting_id,:from_time,:to_time)";

            $bindParams = array("setting_id"=>$setting_id,"from_time"=>$from_time,"to_time"=>$to_time);

            $id = $this->con->insertQuery($query, $bindParams);
        } else {
            $query = "UPDATE `Job_Expiry` SET `from_time`=:from_time,`to_time`=:to_time WHERE `setting_id` = :setting_id";

             $bindParams = array("setting_id"=>$setting_id,"from_time"=>$from_time,"to_time"=>$to_time);

            $id = $this->con->insertQuery($query, $bindParams);
        }
        return $id;
    }
    
    function insertJobReceiveEmail($setting_id,$email_id)
    {
        $query = "SELECT COUNT(*) AS `entry_count` FROM `Job_Receive_Email` WHERE `setting_id` = :setting_id";

        $qh = $this->con->getQueryHandler($query,array("setting_id"=>$setting_id));

        $data = $qh->fetch(PDO::FETCH_NUM);
        
        if($data[0] == 0) {

            $query = "INSERT INTO `Job_Receive_Email`(`setting_id`, `email_id`) VALUES (:setting_id,:email_id)";

            $bindParams = array("setting_id"=>$setting_id,"email_id"=>$email_id);

            $id = $this->con->insertQuery($query, $bindParams);
        } else {
            $query = "UPDATE `Job_Receive_Email` SET `email_id`=:email_id WHERE `setting_id`= :setting_id";

             $bindParams = array("setting_id"=>$setting_id,"email_id"=>$email_id);

            $id = $this->con->insertQuery($query, $bindParams);
        }
        return $id;
    }
    
    function getJobSettingsData($job_id)
    {
        $query = "SELECT `setting_id`, `send_confirmation`, `receive_confirmation`, `set_expiry` FROM `Job_Settings` WHERE `job_id` = :job_id";

        $bindParams = array("job_id"=>$job_id);

        $qh = $this->con->getQueryHandler($query, $bindParams);
        
        $res = $qh->fetch(PDO::FETCH_ASSOC);
        $setting_id = $res['setting_id'];
        
        $email_setting = array();
        $receive_confirmation_setting = array();
        $set_expiry_setting = array();
        
        if($res['send_confirmation'] == 1) {
           $email_setting = $this->getEmailSetting($setting_id);
        }
        
        if($res['receive_confirmation'] == 1) {
            $receive_confirmation_setting = $this->getReceiveConfirmationSetting($setting_id);
        }
        
        if($res['set_expiry'] == 1) {
            $set_expiry_setting = $this->getJobExpirySetting($setting_id);
        }
        
        return array("job_setting"=>$res,"email_setting"=>$email_setting,"receive_confirmation_setting"=>$receive_confirmation_setting,"expiry_setting"=>$set_expiry_setting);
    }
    
    function getEmailSetting($setting_id)
    {
        $query = "SELECT `from_email`, `subject`, `message` FROM `Email_Settings` WHERE `setting_id` = :setting_id";

        $bindParams = array("setting_id"=>$setting_id);

        $qh = $this->con->getQueryHandler($query, $bindParams);
        
        $res = $qh->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
    
    function getReceiveConfirmationSetting($setting_id)
    {
        $query = "SELECT `email_id` FROM `Job_Receive_Email` WHERE `setting_id` = :setting_id";

        $bindParams = array("setting_id"=>$setting_id);

        $qh = $this->con->getQueryHandler($query, $bindParams);
        
        $res = $qh->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
    
    function getJobExpirySetting($setting_id)
    {
        $query = "SELECT `from_time`, `to_time` FROM `Job_Expiry` WHERE `setting_id` = :setting_id";

        $bindParams = array("setting_id"=>$setting_id);

        $qh = $this->con->getQueryHandler($query, $bindParams);
        
        $res = $qh->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
    
    function searchApplicants($userID,$keyword,$criteria,$filter = "")
    {
        global $WEB_URL;
        $query = "SELECT up.`userID`, up.`firstName`, up.`lastName`,up.`profilePic`,ja.`applied_date`,j.`job_title`, j.`job_id`
        FROM `User_Profile` up, `Job_Applications` ja, `Jobs` j 
        WHERE 
        ja.`jobID` IN
        (
           SELECT `jobID` FROM `Job_Owner_Xref` WHERE `userID` = :userID
        )
        AND
        up.`userID` = ja.`userID`
        AND
        ja.`jobID` = j.`job_id`        
        AND
        (
            up.`userID` IN ( SELECT  `userID` FROM `user_tags` WHERE `tagID` IN ( SELECT `tag_id` FROM `tags` WHERE `tag_name` LIKE '%$keyword%' ))
            $criteria
            $filter
        )";
        
        $bindParams = array("userID"=>$userID);
        $qh = $this->con->getQueryHandler($query, $bindParams);
        $applicants = array();
        while ($res = $qh->fetch(PDO::FETCH_ASSOC)) {
             $res["profilePic"] = ($res["profilePic"] == "") ? "$WEB_URL/casting_mobile/images/default.jpg" : str_replace("WEB_URL", "$WEB_URL/casting_mobile", $res["profilePic"]);
            $applicants[] = $res;
        }
        
        return $applicants;
    }
    
    function tagSearch($userID,$tagName)
    {
        global $WEB_URL;
        
        $query = "SELECT up.`userID`, up.`firstName`, up.`lastName`,up.`profilePic`,ja.`applied_date`,j.`job_title`, j.`job_id`
        FROM `User_Profile` up, `Job_Applications` ja, `Jobs` j, `user_tags` ut
        WHERE 
        ja.`jobID` IN
        (
           SELECT `jobID` FROM `Job_Owner_Xref` WHERE `userID` = :userID
        )
        AND
        up.`userID` = ja.`userID`
        AND
        ja.`jobID` = j.`job_id`
        AND
        ut.`userID` = up.`userID`
        AND
        ut.`tagID` IN ( SELECT `tag_id` from `tags` WHERE `tag_name` = :tagName)";
        
        $bindParams = array("userID"=>$userID,"tagName"=>$tagName);
        $qh = $this->con->getQueryHandler($query, $bindParams);
        $applicants = array();
        while ($res = $qh->fetch(PDO::FETCH_ASSOC)) {
             $res["profilePic"] = ($res["profilePic"] == "") ? "$WEB_URL/casting_mobile/images/default.jpg" : str_replace("WEB_URL", "$WEB_URL/casting_mobile", $res["profilePic"]);
            $applicants[] = $res;
        }
        
        return $applicants;
    }
    
    function getTagList($userID)
    {
        $query = "SELECT `tag_id`,`tag_name` FROM `tags` WHERE `tag_id` IN "
                . "("
                . "SELECT `tagID` FROM `user_tags` WHERE `userID` IN "
                . "("
                . "SELECT  `userID` FROM `job_applications` WHERE `jobID` IN "
                . "( SELECT  `jobID` FROM `job_owner_xref` WHERE `userID` = :userID "
                . ")"
                . ")"
                . ")";
        
        $bindParams = array("userID"=>$userID);
        $qh = $this->con->getQueryHandler($query, $bindParams);
        $tags = array();
        while ($res = $qh->fetch(PDO::FETCH_ASSOC)) {
            $tags[] = $res;
        }
        return $tags;
    }
    
    function addTag($tagName,$userID)
    {
        $query1 = "SELECT `tag_id` FROM `Tags` WHERE `tag_name` = :tagName";
        
        $bindParams1 = array("tagName"=>$tagName);
        $qh = $this->con->getQueryHandler($query1, $bindParams1);
        
        $res = $qh->fetch(PDO::FETCH_ASSOC);
        
        if(isset($res['tag_id'])) {
            $tag_id = $res['tag_id'];
            
            $query3 = "SELECT COUNT(*) as tagcount FROM `user_tags` WHERE `tagID` = :tagID";       
            $bindParams3 = array("tagID"=>$tag_id);
            $qh = $this->con->getQueryHandler($query3, $bindParams3);

            $res1 = $qh->fetch(PDO::FETCH_ASSOC);
            if($res1['tagcount'] > 0) {
                echo json_encode(array("error"=>"User is already associated with the tag","code"=>"0"));
                exit();
            }
            
        } else {
            $query2 = "INSERT INTO `tags`(`tag_name`) VALUES (:tagName)";
            $bindParams2 = array("tagName"=>$tagName);
            $tag_id = $this->con->insertQuery($query2, $bindParams2);
        }
        $query = "INSERT INTO `user_tags`(`userID`, `tagID`) VALUES (:userID,:tagID)";

        $bindParams = array("tagID"=>$tag_id,"userID"=>$userID);

        $id = $this->con->insertQuery($query, $bindParams);
        
        return $tag_id;
    }
    
    function deleteTag($userID, $tagName)
    {
        $query = "DELETE FROM `user_tags` WHERE `userID` = :userID AND `tagID` = (SELECT `tag_id` FROM `Tags` WHERE `tag_name` = :tagName)";

        $bindParams = array("tagName"=>$tagName,"userID"=>$userID);

        $id = $this->con->insertQuery($query, $bindParams);
        
        return $id;
    }
    
    function getSettings($jobID)
    {
        $query = "SELECT `setting_id`, `send_confirmation`, `receive_confirmation`, `set_expiry` FROM `job_settings` WHERE `job_id`=:jobID";
        $bindParams = array("jobID"=>$jobID);
        $qh = $this->con->getQueryHandler($query, $bindParams);        
        $settings = $qh->fetch(PDO::FETCH_ASSOC);
        return $settings;
    }
    
    function getJobData($jobID)
    {
        $query = "SELECT `job_title`, `job_icon`, `job_description`, `job_email`, `phone`, `weblink`, `country`, `state`, `city`, `gender`, `genre`, `rate` FROM `jobs` WHERE `job_id` = :jobID";
        $bindParams = array("jobID"=>$jobID);
        $qh = $this->con->getQueryHandler($query, $bindParams);        
        $data = $qh->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    
    function deleteJob($jobID,$userID)
    {
        $query1 = "SELECT COUNT(*) AS countdata FROM `job_owner_xref` WHERE `userID` = :userID AND `jobID` = :jobID";
        $bindParams1 = array("userID"=>$userID,"jobID"=>$jobID);
        $qh1 = $this->con->getQueryHandler($query1, $bindParams1);        
        $countdata = $qh1->fetch(PDO::FETCH_ASSOC);
        $countdata;
        if($countdata['countdata'] == 0) {
            echo json_encode(array("error"=>"You are not authenticated to delete this job","code"=>"0"));
            exit();
        }
        $query = "DELETE FROM `jobs` WHERE `job_id` = :jobID";
        $bindParams = array("jobID"=>$jobID);
        $id = $this->con->insertQuery($query, $bindParams);
        
        return $id;
    }
}