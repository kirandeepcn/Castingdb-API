<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="index.php" method="post">
        <fieldset>
            <legend>Login</legend>
            <table>
                <tr><td>Username:</td> <td><input type="text" name="username" /></td></tr>
                <tr><td>Password:</td> <td><input type="text" name="password" /></td></tr>
                <tr><td>First Name:</td> <td><input type="text" name="firstname" /></td></tr>
                <tr><td>Last Name:</td> <td><input type="text" name="lastname" /></td></tr>
                <tr><td>Gender:</td> <td><input type="text" name="gender" /></td></tr>
                <tr><td>Email:</td> <td><input type="text" name="email" /></td></tr>
                <tr><td>Country:</td> <td><input type="text" name="country" /></td></tr>
                <tr><td>State:</td> <td><input type="text" name="state" /></td></tr>
                <tr><td>City:</td> <td><input type="text" name="city" /></td></tr>
                <tr><td>Account ID:</td> <td><input type="text" name="accountID" /></td></tr>
                <tr><td>Account Type:</td> <td><input type="text" name="accountType" /></td></tr>
                <tr><td><input type="hidden" name="type" value="login" /><input type="submit" value="Login" /></td></tr>
            </table>
        </fieldset>
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Access Token Login</legend>
            <table>
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>                
                <tr><td><input type="hidden" name="type" value="access_token" /><input type="submit" value="Login" /></td></tr>
            </table>
        </fieldset>
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Create Account</legend>
            <table>
                <tr><td>Username:</td> <td><input type="text" name="username" /></td></tr>
                <tr><td>Password:</td> <td><input type="text" name="password" /></td></tr>
                <tr><td>Account Type:</td> <td><input type="text" name="accountType" /></td></tr>
                <tr><td>First Name:</td> <td><input type="text" name="firstname" /></td></tr>
                <tr><td>Last Name:</td> <td><input type="text" name="lastname" /></td></tr>
                <tr><td>Phone:</td> <td><input type="text" name="phone" /></td></tr>
                <tr><td>Skype ID:</td> <td><input type="text" name="skypeID" /></td></tr>
                <tr><td>Gender:</td> <td><input type="text" name="gender" /></td></tr>                
                <tr><td>Country:</td> <td><input type="text" name="country" /></td></tr>
                <tr><td>State:</td> <td><input type="text" name="state" /></td></tr>
                <tr><td>City:</td> <td><input type="text" name="city" /></td></tr>                
                <tr><td>Bio:</td> <td><input type="text" name="bio" /></td></tr>
                <tr><td>User Type:</td> <td><input type="text" name="userType" /></td></tr>
                <tr><td><input type="hidden" name="type" value="create_account" /><input type="submit" value="Create" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
       <form action="index.php" method="post">
        <fieldset>
            <legend>Search Jobs</legend>
            <table>
                <tr><td>Filter:</td> <td>
                        <select name="filter" >
                            <option value="location">Location</option>
                            <option value="gender">Gender</option>
                            <option value="date">Date</option>
                            <option value="genre">Genre</option>
                        </select></td></tr>
                <tr><td>Value:</td> <td><input type="text" name="val" /></td></tr>
                <tr><td>From:</td> <td><input type="text" name="from" /></td></tr>
                <tr><td>To:</td> <td><input type="text" name="to" /></td></tr>
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
                <tr><td><input type="hidden" name="type" value="search_jobs" /><input type="submit" value="Search" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Apply Jobs</legend>
            <table>
                <tr><td>Job ID:</td> <td><input type="text" name="job_id" /></td></tr>
                <tr><td>User ID:</td> <td><input type="text" name="user_id" /></td></tr>
                <tr><td>Note:</td> <td><input type="text" name="note" /></td></tr>
                <tr><td>Pic ID's:</td> <td><input type="text" name="pics" /></td></tr>
                <tr><td><input type="hidden" name="type" value="apply_job" /><input type="submit" value="Apply" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Job History</legend>
            <table>
                <tr><td>User ID:</td> <td><input type="text" name="user_id" /></td></tr>
                <tr><td><input type="hidden" name="type" value="job_history" /><input type="submit" value="Fetch" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Profile Data</legend>
            <table>
                <tr><td> Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
                <tr><td><input type="hidden" name="type" value="profile_data" /><input type="submit" value="Fetch" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Upload File</legend>
            <table>
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
                <tr><td>Type:</td> <td><input type="text" name="file_type" /></td></tr>
                <tr><td>Upload:</td> <td><input type="file" name="file" /></td></tr>
                <tr><td><input type="hidden" name="type" value="upload_file" /><input type="submit" value="Upload" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Edit Profile</legend>
            <table>
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
               <tr><td>First Name:</td> <td><input type="text" name="firstname" /></td></tr>
                 <tr><td>Last Name:</td> <td><input type="text" name="lastname" /></td></tr>
                <tr><td>Phone:</td> <td><input type="text" name="phone" /></td></tr>
                <tr><td>Email:</td> <td><input type="text" name="email" /></td></tr>
                <tr><td>Skype ID:</td> <td><input type="text" name="skypeID" /></td></tr>
                <tr><td>Bio:</td> <td><input type="text" name="bio" /></td></tr>
                <tr><td>Gender:</td> <td><select name="gender"><option value="male">Male</option><option value="female">Female</option></select></td></tr>
                <tr><td>Social Links:</td> <td><input type="text" name="socialLinks" /></td></tr>
                <tr><td>Profile Pic:</td> <td><input type="file" name="file" /></td></tr>                
                <tr><td><input type="hidden" name="type" value="edit_profile" /><input type="submit" value="Update" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Account Settings</legend>
            <table>
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>                
                <tr><td>Old Password:</td> <td><input type="text" name="oldPass" /></td></tr>
                <tr><td>New Password:</td> <td><input type="text" name="newPass" /></td></tr>
                <tr><td><input type="hidden" name="type" value="account_settings" /><input type="submit" value="Update" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Delete File</legend>
            <table>
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>                
                <tr><td>File ID:</td> <td><input type="text" name="file_id" /></td></tr>
                <tr><td>Type:</td> <td><input type="text" name="file_type" /></td></tr>
                <tr><td><input type="hidden" name="type" value="delete_file" /><input type="submit" value="Update" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Search Jobs With Single Parameter</legend>
            <table>
               <tr><td>Value:</td> <td><input type="text" name="val" /></td></tr>
                <tr><td>From:</td> <td><input type="text" name="from" /></td></tr>
                <tr><td>To:</td> <td><input type="text" name="to" /></td></tr>
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
                <tr><td><input type="hidden" name="type" value="search_jobs_single_params" /><input type="submit" value="Search" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
         <form action="index.php" method="post">
        <fieldset>
            <legend>Add Video Link</legend>
            <table>
               <tr><td>Video Link:</td> <td><input type="text" name="videoLink" /></td></tr>
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
                <tr><td><input type="hidden" name="type" value="add_video_link" /><input type="submit" value="Add" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Inbox</legend>
            <table>               
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>                
                <tr><td><input type="hidden" name="type" value="inbox" /><input type="submit" value="View" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Create Message</legend>
            <table>
               <tr><td>Subject:</td> <td><input type="text" name="subject" /></td></tr>
                <tr><td>From ID:</td> <td><input type="text" name="from_id" /></td></tr>
                <tr><td>To ID:</td> <td><input type="text" name="to_id" /></td></tr>
                <tr><td>Body:</td> <td><input type="text" name="body" /></td></tr>
                <tr><td><input type="hidden" name="type" value="create_message" /><input type="submit" value="Create" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Send Message</legend>
            <table>               
                <tr><td>From ID:</td> <td><input type="text" name="from_id" /></td></tr>
                <tr><td>Message ID:</td> <td><input type="text" name="message_id" /></td></tr>
                <tr><td>Body:</td> <td><input type="text" name="body" /></td></tr>
                <tr><td><input type="hidden" name="type" value="send_message" /><input type="submit" value="Send" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>View Conversation</legend>
            <table>                               
                <tr><td>Message ID:</td> <td><input type="text" name="message_id" /></td></tr>
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
                <tr><td><input type="hidden" name="type" value="get_messages" /><input type="submit" value="View" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post"enctype="multipart/form-data">
        <fieldset>
            <legend>Create Job</legend>
            <table>                                               
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
                <tr><td>Job Title:</td> <td><input type="text" name="job_title" /></td></tr>
                <tr><td>Job Icon:</td> <td><input type="file" name="job_icon" /></td></tr>
                <tr><td>Job Description:</td> <td><input type="text" name="job_description" /></td></tr>
                <tr><td>Job Email:</td> <td><input type="text" name="job_email" /></td></tr>
                <tr><td>Phone:</td> <td><input type="text" name="phone" /></td></tr>
                <tr><td>Weblink:</td> <td><input type="text" name="weblink" /></td></tr>
                <tr><td>Country:</td> <td><input type="text" name="country" /></td></tr>
                <tr><td>State:</td> <td><input type="text" name="state" /></td></tr>
                <tr><td>City:</td> <td><input type="text" name="city" /></td></tr>
                <tr><td>Gender:</td> <td><input type="text" name="gender" /></td></tr>
                <tr><td>Genre:</td> <td><input type="text" name="genre" /></td></tr>
                <tr><td>Rate:</td> <td><input type="text" name="rate" /></td></tr>
                <tr><td><input type="hidden" name="type" value="create_job" /><input type="submit" value="Create" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>View Applicants</legend>
            <table>                               
                <tr><td>Job ID:</td> <td><input type="text" name="jobID" /></td></tr>
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
                <tr><td><input type="hidden" name="type" value="get_applicants" /><input type="submit" value="View" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Create Company</legend>
            <table>                                               
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
                <tr><td>Name:</td> <td><input type="text" name="name" /></td></tr>
                <tr><td>Logo:</td> <td><input type="file" name="logo" /></td></tr>
                <tr><td><input type="hidden" name="type" value="create_company" /><input type="submit" value="Create" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>View Job Settings</legend>
            <table>                                               
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
                <tr><td>Job ID:</td> <td><input type="text" name="job_id" /></td></tr>                
                <tr><td><input type="hidden" name="type" value="get_job_settings" /><input type="submit" value="View" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Update Job Settings</legend>
            <table>                                               
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
                <tr><td>Setting ID:</td> <td><input type="text" name="setting_id" /></td></tr>            
                <tr><td>Send Confirmation:</td> <td><input type="text" name="send_confirmation" /></td></tr>
                <tr><td>Receive Confirmation:</td> <td><input type="text" name="receive_confirmation" /></td></tr>
                <tr><td>Set Expiry:</td> <td><input type="text" name="set_expiry" /></td></tr>
                
                <tr><td>From Email:</td> <td><input type="text" name="from_email" /></td></tr>
                <tr><td>Subject:</td> <td><input type="text" name="subject" /></td></tr>
                <tr><td>Message:</td> <td><input type="text" name="message" /></td></tr>
                
                <tr><td>Email ID:</td> <td><input type="text" name="email_id" /></td></tr>
                <tr><td>From time:</td> <td><input type="text" name="from_time" /></td></tr>
                <tr><td>To time:</td> <td><input type="text" name="to_time" /></td></tr>
                <tr><td><input type="hidden" name="type" value="update_job_settings" /><input type="submit" value="Update" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Search Applicants</legend>
            <table>                                               
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>                
                <tr><td>Keyword:</td> <td><input type="text" name="keyword" /></td></tr>
                <tr><td>Filter Type:</td> <td><input type="text" name="filterType" /></td></tr>
                <tr><td>Filter Text:</td> <td><input type="text" name="filterText" /></td></tr>
                <tr><td><input type="hidden" name="type" value="search_applicants" /><input type="submit" value="Search" /></td></tr>
            </table>
        </fieldset>        
        </form>

        <form action="index.php" method="post">
        <fieldset>
            <legend>View Casting Director Profile</legend>
            <table>                                               
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>                                
                <tr><td><input type="hidden" name="type" value="view_cd_profile" /><input type="submit" value="Search" /></td></tr>
            </table>
        </fieldset>        
        </form>

        <form action="index.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Update Casting Director Profile</legend>
            <table>                                               
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>   
                <tr><td>First Name:</td> <td><input type="text" name="firstName" /></td></tr>
                 <tr><td>Last Name:</td> <td><input type="text" name="lastName" /></td></tr>
                <tr><td>Phone:</td> <td><input type="text" name="phone" /></td></tr>
                <tr><td>Email:</td> <td><input type="text" name="email" /></td></tr>
                <tr><td>Gender:</td> <td><select name="gender"><option value="male">Male</option><option value="female">Female</option></select></td></tr>
                <tr><td>Profile Pic:</td> <td><input type="file" name="file" /></td></tr>  
                <tr><td><input type="hidden" name="type" value="update_cd_profile" /><input type="submit" value="Update" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Get Country</legend>
            <table>                                               
                <tr><td><input type="hidden" name="type" value="getCountry" /><input type="submit" value="View" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Get State</legend>
            <table>                                                               
                <tr><td>Country Code:</td> <td><input type="text" name="countryCode" /></td></tr>  
                <tr><td><input type="hidden" name="type" value="getState" /><input type="submit" value="View" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Get City</legend>
            <table>                                               
                <tr><td>Country Code:</td> <td><input type="text" name="countryCode" /></td></tr>
                <tr><td>State:</td><td><input type="text" name="state" /></td> </tr>
                <tr><td><input type="hidden" name="type" value="getCity" /><input type="submit" value="View" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>View Applicant Profile</legend>
            <table>                                               
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
                <tr><td>User ID:</td><td><input type="text" name="userID" /></td> </tr>
                <tr><td>Job ID:</td><td><input type="text" name="jobID" /></td> </tr>
                <tr><td><input type="hidden" name="type" value="view_applicant_profile" /><input type="submit" value="View" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Add tag</legend>
            <table>                                               
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
                <tr><td>User ID:</td><td><input type="text" name="userID" /></td> </tr>
                <tr><td>Tag Name:</td><td><input type="text" name="tagName" /></td> </tr>
                <tr><td><input type="hidden" name="type" value="add_tag" /><input type="submit" value="Add" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Tag Search</legend>
            <table>                                               
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>                
                <tr><td>Tag Name:</td><td><input type="text" name="tagName" /></td> </tr>
                <tr><td><input type="hidden" name="type" value="tag_search" /><input type="submit" value="Search" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Tags List</legend>
            <table>                                               
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>                                
                <tr><td><input type="hidden" name="type" value="get_tags" /><input type="submit" value="Search" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Update Job</legend>
            <table>                                               
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
                <tr><td>Job ID:</td> <td><input type="text" name="job_id" /></td></tr>
                <tr><td>Job Title:</td> <td><input type="text" name="job_title" /></td></tr>
                <tr><td>Job Icon:</td> <td><input type="file" name="job_icon" /></td></tr>
                <tr><td>Job Description:</td> <td><input type="text" name="job_description" /></td></tr>
                <tr><td>Job Email:</td> <td><input type="text" name="job_email" /></td></tr>
                <tr><td>Phone:</td> <td><input type="text" name="phone" /></td></tr>
                <tr><td>Weblink:</td> <td><input type="text" name="weblink" /></td></tr>
                <tr><td>Country:</td> <td><input type="text" name="country" /></td></tr>
                <tr><td>State:</td> <td><input type="text" name="state" /></td></tr>
                <tr><td>City:</td> <td><input type="text" name="city" /></td></tr>
                <tr><td>Gender:</td> <td><input type="text" name="gender" /></td></tr>
                <tr><td>Genre:</td> <td><input type="text" name="genre" /></td></tr>
                <tr><td>Rate:</td> <td><input type="text" name="rate" /></td></tr>
                
                <tr><td><input type="hidden" name="type" value="update_job" /><input type="submit" value="Update" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Job Data</legend>
            <table>                                               
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
                <tr><td>Job ID:</td> <td><input type="text" name="jobID" /></td></tr>                                
                <tr><td><input type="hidden" name="type" value="get_job_data" /><input type="submit" value="Get" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Delete Job</legend>
            <table>                                               
                <tr><td>Access Token:</td> <td><input type="text" name="accessToken" /></td></tr>
                <tr><td>Job ID:</td> <td><input type="text" name="jobID" /></td></tr>         
                <tr><td><input type="hidden" name="type" value="delete_job" /><input type="submit" value="Delete" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Forgot Password</legend>
            <table>                                                               
                <tr><td>Username:</td> <td><input type="text" name="userName" /></td></tr>         
                <tr><td><input type="hidden" name="type" value="forgot_password" /><input type="submit" value="Send mail" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
         <form action="index.php" method="post">
        <fieldset>
            <legend>Check token validity</legend>
            <table>                                                               
                <tr><td>Token:</td> <td><input type="text" name="token" /></td></tr>         
                <tr><td><input type="hidden" name="type" value="check_token_validity" /><input type="submit" value="Check" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
        <form action="index.php" method="post">
        <fieldset>
            <legend>Reset Password</legend>
            <table>                                                               
                <tr><td>Token:</td> <td><input type="text" name="token" /></td></tr>
                <tr><td>Password:</td> <td><input type="text" name="password" /></td></tr>
                <tr><td><input type="hidden" name="type" value="reset_password" /><input type="submit" value="Submit" /></td></tr>
            </table>
        </fieldset>        
        </form>
        
    </body>
</html>
