# Castingdb-API

castingdb.net API Documentation

1> Login:

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):

 type: login
accountType: 1 (for normal login), 2(for facebook login)

username: (accountType: 1 )
password: (accountType: 1 )

accountID (accountType: 2)
firstname(accountType: 2 )
lastname(accountType: 2 )
gender (accountType: 2 )
email (accountType: 2)
pic(accountType: 2)
country(accountType: 2)
state(accountType: 2)
city(accountType: 2)

Response:

{
"user":
{
	“userID”: 1,
"name":"Nikhil",
"profilePic":""
},
"job":[
{
	“userID : “137”,
"job_id":"1",
"job_title":"Casting BFF's with an Amazing How we met Story!",
"job_icon":"",
"job_description":"The real word Tampa is the only reality show in the USA that has been running for 15 years.",
"job_email":"careers@entertainmentcareers.net",
"phone":"+17696865491",
"weblink":"www.test.com",
"country":"US" OR “country”:”United States”,
"state":"New Hamphshire",
"city":"Concord",
"rate":"10",
"posted_date":"2014-07-02 00:04:18",
“applied”:”1”
},


{
"job_id":"2",
"job_title":"Casting Call for Gay Real World",
"job_icon":"",
"job_description":"The real word Tampa is the only reality show in the USA that has been running for 15 years.",
"job_email":"careers@testcareers.net",
"phone":"+17123456789",
"weblink":"www.test123.com",
"country":"US",
"state":"New Hamphshire",
"city":"Concord",
"rate":"20",
"posted_date":"2014-07-02 00:05:59",
“applied”:”1”
}
],
"pics":
[
{
"pic_id":"17",
"link":"http://www.castingdb.net/casting_mobile/images/12-1406479426"
},
{
"pic_id":"18",
"link":"http://www.castingdb.net/casting_mobile/images/12-1406479546"
}
],
“unreadCount”:48,
"code":"1"
}

OR (For casting director) 

{
"user":
{
"accessToken":"f4b68c81d59552aefe3490109cbc81d8cc3cb7eb",
"userID":"152",
"firstName":"Casting",
"lastName":"Singh",
"profilePic":"http://castingdb.net/casting_mobile/images/default.jpg",
"userType":"2"
},
"job":
[
{
"job_id":"35",
"job_title":"Casting Comedians",
"job_icon":"http://www.castingdb.net/casting_mobile/job_icon//152-1411484984",
"jobCount":"3"
}
],
"recentApplicants":
[
{
"userID":"12",
"job_title":"Casting Comedians",
"applied_date":"2014-09-23 17:23:50",
"firstname":"Kirandeep Singh",
"lastname":""
},
{
"userID":"67",
"job_title":"Casting Comedians",
"applied_date":"2014-09-23 17:23:50",
"firstname":"Anish Kumar",
"lastname":"kumar"
}
],
"code":"1"
}
If invalid username/password then response is

{
"error":"Invalid Username or Password",
"code":"0"
}

Here code = 1 if login is successful and code = 0 in case authentication fails



2> Access Token Login:

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):

 type: access_token
accessToken:

Response:

{
"user":
{
	“userID”: 1,
"name":"Nikhil",
"profilePic":""
},
"job":[
{
"job_id":"1",
"job_title":"Casting BFF's with an Amazing How we met Story!",
"job_icon":"",
"job_description":"The real word Tampa is the only reality show in the USA that has been running for 15 years.",
"job_email":"careers@entertainmentcareers.net",
"phone":"+17696865491",
"weblink":"www.test.com",
"country":"US" OR “country”:”United States”,
"state":"New Hamphshire",
"city":"Concord",
"rate":"10",
"posted_date":"2014-07-02 00:04:18",
“applied”:”1”
},


{
"job_id":"2",
"job_title":"Casting Call for Gay Real World",
"job_icon":"",
"job_description":"The real word Tampa is the only reality show in the USA that has been running for 15 years.",
"job_email":"careers@testcareers.net",
"phone":"+17123456789",
"weblink":"www.test123.com",
"country":"US",
"state":"New Hamphshire",
"city":"Concord",
"rate":"20",
"posted_date":"2014-07-02 00:05:59",
“applied”:”0”
}
],
"pics":
[
{
"pic_id":"17",
"link":"http://www.castingdb.net/casting_mobile/images/12-1406479426"
},
{
"pic_id":"18",
"link":"http://www.castingdb.net/casting_mobile/images/12-1406479546"
}
],
“unreadCount”:48,
"code":"1"
}

If invalid username/password then response is

{
"error":"Invalid Username or Password",
"code":"0"
}

 OR

{
	“error” : “Access Token is missing”,
	“code” : “-1”
}
Here code = 1 if login is successful ,code = 0 in case authentication fails and code = -1 if Access Token is missing


3> Create Account

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
 type: create_account
username:
password:
accountType: 1 (for normal login), 2(for facebook login)
firstname: firstname
lastname: lastname
gender: male or female
country:
state:
city:
userType: optional (2 for Casting director)
phone: optional
bio: optional

Response:
{
"code":"1",
"log":"Inserted Successfully",
"user":
{
	“userID”: 1,
"name":"Nikhil",
"profilePic":"",
“userType”:”2”
},
"job":[
{
"job_id":"1",
"job_title":"Casting BFF's with an Amazing How we met Story!",
"job_icon":"",
"job_description":"The real word Tampa is the only reality show in the USA that has been running for 15 years.",
"job_email":"careers@entertainmentcareers.net",
"phone":"+17696865491",
"weblink":"www.test.com",
"country":"US" OR “country”:”United States”,
"state":"New Hamphshire",
"city":"Concord",
"rate":"10",
"posted_date":"2014-07-02 00:04:18",
“applied”:”1”
},


{
"job_id":"2",
"job_title":"Casting Call for Gay Real World",
"job_icon":"",
"job_description":"The real word Tampa is the only reality show in the USA that has been running for 15 years.",
"job_email":"careers@testcareers.net",
"phone":"+17123456789",
"weblink":"www.test123.com",
"country":"US",
"state":"New Hamphshire",
"city":"Concord",
"rate":"20",
"posted_date":"2014-07-02 00:05:59",
“applied”:”0”
}
],
"pics":
[
{
"pic_id":"17",
"link":"http://www.castingdb.net/casting_mobile/images/12-1406479426"
},
{
"pic_id":"18",
"link":"http://www.castingdb.net/casting_mobile/images/12-1406479546"
}
]

}
OR
{
"code":"0",
"log":"Username already exists"
}
OR
{
"code":"-1",
"log":"Some fields are missing"
}













4> Search Jobs

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: search_jobs
accessToken:
filter: location OR date OR gender(male,female) OR genre
val:
from: optional (0,1,2,...,n)
from and to are the number of jobs that will be returned. Default value will be 0 and 10 respectively.

Response:

{
"job":
[
{
"job_id":"1",
"job_title":"Casting BFF's with an Amazing How we met Story!",
"job_icon":"http://castingdb.net/casting_mobile/images/casting.jpg",
"job_description":"The real word Tampa is the only reality show in the USA that has been running for 15 years.",
"job_email":"careers@entertainmentcareers.net",
"phone":"+17696865491",
"weblink":"www.test.com",
"country":"US",
"state":"New Hamphshire",
"city":"Concord",
"rate":"10",
"posted_date":"2014-07-12 14:31:43",
“applied”:”0”
},
{
"job_id":"2",
"job_title":"Casting Call for Gay Real World",
"job_icon":"http://castingdb.net/casting_mobile/images/casting.jpg",
"job_description":"The real word Tampa is the only reality show in the USA that has been running for 15 years.",
"job_email":"careers@testcareers.net",
"phone":"+17123456789",
"weblink":"www.test123.com",
"country":"US",
"state":"New Hamphshire",
"city":"Concord",
"rate":"20",
"posted_date":"2014-07-12 14:31:12",
“applied”:”0”
}
],

"code":"1"
}

OR

{
"error":"No results",
"code":"0"
}


5>  Apply Jobs

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: apply_job
job_id:
user_id:
note:
pics: (Comma separated pic ids)

Response:

{
"log":"Job applied successfully",
"code":1
}

OR

{
"error":"Job ID or User ID is missing",
"code":"0"
}

6>  Fetch Job History

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: job_history
user_id:

Response:

{
"job":
[
{
"job_id":"1",
"job_title":"Casting BFF's with an Amazing How we met Story!",
"job_icon":"http://castingdb.net/casting_mobile/images/casting.jpg",
"job_description":"The real word Tampa is the only reality show in the USA that has been running for 15 years.",
"job_email":"careers@entertainmentcareers.net",
"phone":"+17696865491",
"weblink":"www.test.com",
"country":"US",
"state":"New Hamphshire",
"city":"Concord",
"rate":"10",
"posted_date":"2014-07-12 14:31:43",
"note":"job applie",
"pics":
[
{
"pic_id":"17",
"path":"http://www.castingdb.net/casting_mobile/images/12-1406479426"
},
{
"pic_id":"32",
"path":"http://www.castingdb.net/casting_mobile/images/12-1406483894"
}
]
},
"code":"1"
}


OR

{
"error":"No Jobs found",
"code":"0"
}



7>  Fetch Profile Data

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: profile_data
accessToken:

Response:

{
"name":"Er Anish Kumar",
"profilePic":"http://graph.facebook.com/797457540298507/picture?type=large" , "phone":"9782136443",
"email":"facebook.anish@yahoo.com",
"skypeID":"anishk",
"bio":"This is test biography. I love singing and dancing.",
"resume":"",
"gender":"male",
"social_link":[
"www.facebook.com/kirandeep.singh1",
"www.castingdb.net",
"www.castingdb.net"
],
"pic":[
{
"pic_id":"17",
"link":"http://www.castingdb.net/casting_mobile/images/12-1406479426"
},
{
"pic_id":"18",
"link":"http://www.castingdb.net/casting_mobile/images/12-1406479546"
},
{
"pic_id":"19",
"link":"http://www.castingdb.net/casting_mobile/images/12-1406479603"
}
],
"video":[],
"code":"1";
}

OR 

{
"error":"Invalid User ID",
"code":"0"
}















8> Upload Image/Video

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: upload_file
accessToken:
file_type: images OR videos OR resumes
file: Binary image/video file

Response:

{
"log":
{
"file_id":"32",
"path":"http://www.castingdb.net/casting_mobile/images/12-1406483894"
},
"code":"1"
}

OR 

{
"error"=>"Unable to save file",
"code"=>"0"	
}

OR

{
"error"=>"Unable to update database",
"code"=>"0"
}








9> Edit Profile

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: edit_profile
accessToken:
firstname:
lastname:
phone:
email:
skypeID:
bio:
gender:
socialLinks:  ( !@# separated values .For ex http://www.castingdb.net!@#http://www.google.com: )
file:Profile Pic Binary Image

Response:

{
"name":"Er Anish Kumar",
"profilePic":"http://graph.facebook.com/797457540298507/picture?type=large" , "phone":"9782136443",
"email":"facebook.anish@yahoo.com",
"skypeID":"anishk",
"bio":"This is test biography. I love singing and dancing.",
"resume":"",
"gender":"male",
"social_link":[
"www.facebook.com/kirandeep.singh1",
"www.castingdb.net",
"www.castingdb.net"
],
"pic":[
{
"pic_id":"17",
"link":"http://www.castingdb.net/casting_mobile/images/12-1406479426"
},
{
"pic_id":"18",
"link":"http://www.castingdb.net/casting_mobile/images/12-1406479546"
},
{
"pic_id":"19",
"link":"http://www.castingdb.net/casting_mobile/images/12-1406479603"
}
],
"video":[],
"code":"1";
}


OR 

{
	"error"=>"Invalid value for gender",
"code"=>"0"
}

OR

{
	"error"=>"Invalid Access Token",
"code"=>"0"
}

10> Account Settings

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: account_settings
accessToken:
oldPass:
newPass:

Response:

{
"log":"Password updated successfully",
"code":"1"
}

OR

{
"error":"Authentication failed",
"code":"0"
}

OR

{
"error":"New Password cannot be empty",
"code":"0"
}


11> Delete File

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: delete_file
accessToken:
file_id:
file_type: images or videos

Response:

{
"log":"File Deleted",
"code":"1"
}

OR

{
"error"=>"Invalid Type",
"code"=>"0"
}

OR
{
	“error"=>"File ID cannot be empty",
"code"=>"0"
}


12> Search Jobs With Single Parameter

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: search_jobs_single_params
accessToken:
val:
from: optional (0,1,2,...,n)
from and to are the number of jobs that will be returned. Default value will be 0 and 10 respectively.

Response:

{
"job":
[
{
"job_id":"1",
"job_title":"Casting BFF's with an Amazing How we met Story!",
"job_icon":"http://castingdb.net/casting_mobile/images/casting.jpg",
"job_description":"The real word Tampa is the only reality show in the USA that has been running for 15 years.",
"job_email":"careers@entertainmentcareers.net",
"phone":"+17696865491",
"weblink":"www.test.com",
"country":"US",
"state":"New Hamphshire",
"city":"Concord",
"rate":"10",
"posted_date":"2014-07-12 14:31:43",
“applied”:”0”
},
{
"job_id":"2",
"job_title":"Casting Call for Gay Real World",
"job_icon":"http://castingdb.net/casting_mobile/images/casting.jpg",
"job_description":"The real word Tampa is the only reality show in the USA that has been running for 15 years.",
"job_email":"careers@testcareers.net",
"phone":"+17123456789",
"weblink":"www.test123.com",
"country":"US",
"state":"New Hamphshire",
"city":"Concord",
"rate":"20",
"posted_date":"2014-07-12 14:31:12",
“applied”:”0”
}
],

"code":"1"
}

OR

{
"error":"No results",
"code":"0"
}

13> Add Video Link

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: add_video_link
accessToken:
videoLink:  video links only from youtube and vimeo
                                
Response:

{
"video_id":"7",
"path":"https://www.youtube.com/watch?v=KaQqoWtBZ6U",
"thumb":"http://img.youtube.com\/vi\/KaQqoWtBZ6U\/0.jpg",
"code":1
}

OR

{
"error"=>"Invalid Access token",
"code"=>"0"
}

OR
{
	“error"=>"Link not acceptable",
"code"=>"0"
}






14> View Inbox

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: inbox
accessToken:
                                
Response:
[
{
"id":"1",
"subject":"Test subject",
"time":"2014-08-24 16:19:17",
"userDetails":
{
"firstName":"Vin",
"lastName":"Diesel",
"profilePic":"",
"sender_id":"137"
}
},
{
"id":"2",
"subject":"This is another subject",
"time":"2014-08-24 17:37:04",
"userDetails":
{
"firstName":"John",
"lastName":"Welling",
"profilePic":"",
"sender_id":"138"
}
}
]








15> Create Message

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: create_message
subject:
from_id:
to_id:
body:
                                
Response:

{
"log":"Message created successfully",
"message_id":”1”
}

16> Send Message

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: send_message
message_id:
from_id:
body:
                                
Response:

{
“log":"Message inserted successfully"
}










17> View Conversation

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: get_messages
message_id:
accessToken::
                                
Response:

{
"conversation":
[
{
"message_id":"1",
"is_user":"1",
"body":"This is a test message",
"time":"2014-08-24 16:19:17"
},
{
"message_id":"2",
"is_user":"0",
"body":"Check",
"time":"2014-08-24 16:36:47"
}
],
"code":"1"
}

is_user = 1 if the message is send by the user
is_user = 0 if the message is send by the client

18> Create Job

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: create_job
accessToken:
job_title:
job_icon:
job_description:
job_email:
phone:
weblink:
country:
state:
city:
gender:
genre:
rate:
                                
Response:

{
	log: “Job created successfully”,
code: “1”
}

OR 

{
	log: “Access token invalid”,
	code: “0”
}

19> Get Applicants

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: get_applicants
accessToken:
jobID:
                                
Response:

[
{
"userID":"86",
"job_title":"NOW CASTING \u2013 ROCKSTAR KIDS!",
"applied_date":"2014-09-23 17:23:50",
"firstname":"Kirandeep Singh",
"lastname":""
},
{
"userID":"49",
"job_title":"NOW CASTING \u2013 ROCKSTAR KIDS!",
"applied_date":"2014-09-23 17:23:50",
"firstname":"Tim Safford",
"lastname":""
}
]

20> Create Company

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: create_company
name:
logo: (FILE Type)
                                
Response:
{
"log":"Job created",
"code":"1"
}
21> View Job Settings

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: get_job_settings
accessToken:
job_id:
                                
Response:

{
"job_setting":
{
"setting_id":"1",
"send_confirmation":"1",
"receive_confirmation":"1",
"set_expiry":"1"
},
"email_setting":
{
"from_email":"kirandeep05@gmail.com",
"subject":"Hey this is a test email",
"message":"So this is a test message"
},
"receive_confirmation_setting":
{
"email_id":"kirandeep05@gmail.com"
},
"expiry_setting":
{
"from_time":"2014-10-01 20:00:00",
"to_time":"2014-10-10 20:00:00"
}
}

22> Update Job Settings

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: update_job_settings
setting_id: (You will get this ID while getting the job list)
send_confirmation:
receive_confirmation:
set_expiry:

from_email:
subject:
message:

email_id:
from_time:
to_time:
                                
Response:
{
"log":"Settings updated successfully", 
"code": "1"
}

23> Search Applicants

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: search_applicants
accessToken: 
keyword:

filterType: 1 (for Gender)
filterText:
       


                         
Response:	
{
"applicants":
[
{
"userID":"124",
"firstName":"Tarun",
"lastName":"Garg",
"profilePic":"http:\/\/www.castingdb.net\/casting_mobile\/profile_pics\/124-1409069038",
"applied_date":"2014-10-06 12:13:56",
"job_title":"Looking for Divas"
},
{
"userID":"12",
"firstName":"Kirandeep Singh",
"lastName":"",
"profilePic":"http:\/\/www.castingdb.net\/casting_mobile\/profile_pics\/12-1406471997",
"applied_date":"2014-10-02 07:39:14",
"job_title":"Job Title"
}
	],
"tags":
[
{
"tag_id":"1",
"tag_name":"Test Tag"
},
{
"tag_id":"2",
"tag_name":"Test Tag 1"
}
]
	code: “1”
}

24> View Casting Director Profile

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: view_cd_profile
accessToken: 
                         
Response:	
{
"details":
{
"firstName":"Kirandeep",
"lastName":"Singh",
"profilePic":"www.castingdb.net\/casting_mobile\/profile_pics\/153-1414172927",
"phone":"09780123456",
"email":"psaha62@gmail.com",
"gender":"male"
},
"code":"1"
}

25> Update Casting Director Profile

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: update_cd_profile
accessToken: 
firstName:
lastName:
phone:
email:
gender:
file: (Profile pic)
                         
Response:

{
"log":"Details updated successfully",
"code":"1"
}

26> Get Country

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: getCountry
                         
Response:

[
{
"Code":"ABW",
"Name":"Aruba"
},
{
"Code":"AFG",
"Name":"Afghanistan"
}
]



27> Get State

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: getState
countryCode:
                         
Response:

{
"states":
[	
"Andhra Pradesh",
"Assam"
]
}

28> Get Cities

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: getCity
countryCode:
state:
                         
Response:
{
"cities":
[
"Abohar",
"Amritsar"
]
}


29> View Applicant Profile

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: view_applicant_profile
accessToken:
userID:
jobID:

Response:

{
"name":"Er Anish Kumar",
"profilePic":"http://graph.facebook.com/797457540298507/picture?type=large" , "phone":"9782136443",
"email":"facebook.anish@yahoo.com",
"skypeID":"anishk",
"bio":"This is test biography. I love singing and dancing.",
"resume":"",
"gender":"male",
"social_link":[
"www.facebook.com/kirandeep.singh1",
"www.castingdb.net",
"www.castingdb.net"
],
"pic":[
{
"pic_id":"17",
"link":"http://www.castingdb.net/casting_mobile/images/12-1406479426"
},
{
"pic_id":"18",
"link":"http://www.castingdb.net/casting_mobile/images/12-1406479546"
},
{
"pic_id":"19",
"link":"http://www.castingdb.net/casting_mobile/images/12-1406479603"
}
],
"tags":[{tag_id:”1”,name:“tag1”},{tag_id:”2”,name:“tag2”}],
"note":"Testing email",
"video":[],
"code":"1";
}

OR 

{
"error":"Invalid User ID",
"code":"0"
}





30> Add Tags

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: add_tag
accessToken:
userID:
tagName:

Response:

{
"log":"Tag added successfully",
"code":"1"
}

OR 

{
"error":"User is already associated with the tag",
"code":"0"
}

OR

{
	“error”: “Tag name cannot be blank”,
	“code”: “0”
}


30> Delete Tags

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: delete_tag
accessToken:
userID:
tagName:

Response:

{
"log":"Tag deleted successfully",
"code":"1"
}

OR

{
	“error”: “Tag name cannot be blank”,
	“code”: “0”
}


31> Tag Search

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: tag_search
accessToken:
tagName:

Response:

{
"applicants":
[
{
"userID":"124",
"firstName":"Tarun",
"lastName":"Garg",
"profilePic":"http:\/\/www.castingdb.net\/casting_mobile\/profile_pics\/124-1409069038",
"applied_date":"2014-09-23 06:53:50",
"job_title":"Casting BFF's with an Amazing How we met Story!",
"job_id":"1"
},
{
"userID":"124",
"firstName":"Tarun",

"lastName":"Garg",
"profilePic":"http:\/\/www.castingdb.net\/casting_mobile\/profile_pics\/124-1409069038",
"applied_date":"2014-09-23 06:53:50",
"job_title":"Casting Call for Still Photographer",
"job_id":"3"
}
],
"tags":
[
{
"tag_id":"1",
"tag_name":"Test Tag"
},
{
"tag_id":"2",
"tag_name":"Checking"
}
],
"code":"1"
}


32> Tag List

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: get_tags
accessToken:

Response:

{
"tags":
[
{
"tag_id":"5",
"tag_name":"sumeetrana"
}
],
"code":"1"
}

33> Update Job

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: update_job
accessToken:
job_id:
job_title:
job_icon:
job_description:
job_email:
phone:
weblink:
country:
state:
city:
gender:
genre:
rate:
                                
Response:

{
	log: “Job updated successfully”,
code: “1”
}




34> View Job

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: get_job_data
accessToken:
jobID:
                                
Response:

{
"data":
{
"job_title":"NOW CASTING \u2013 ROCKSTAR KIDS!",
"job_icon":"https:\/\/fbcdn-sphotos-g-a.akamaihd.net\/hphotos-ak-xpa1\/v\/t1.0-9\/p480x480\/10509513_10102135413895399_3603049308126693998_n.jpg?oh=8621b374079993f0e8fd4144a3578382&oe=543F99CC&__gda__=1413456179_9a6278db1064f25d31f7cb0142080cb8",
"job_description":"Are you ready for a music show about the next generation?\r\nNow casting a show about a CHILD ROCKBAND!\r\nWe are looking for children ages 13-17 with the ability to light up the small screen with both the musical talent and personality that will have America tuning in week after week. We are looking to create the rock band of the future and follow them as they rehearse, travel, play gigs, and deal with their rising fame!\r\nSeeking both male and female singers, drummers, guitarists, bass players, keyboardists, saxophonists, and more! If you have skills, we want to meet you!\r\nSouthern California Residents ONLY!\r\nWe look forward to hearing from you!",
"job_email":"careers@tesing.net",
"phone":"+407454546719",
"weblink":"http:\/\/www.google.com",
"country":"US",
"state":"NY",
"city":"New York",
"gender":"Male",
"genre":"",
"rate":"24"
},
"code":"1"
}


35> Delete Job

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: delete_job
accessToken:
jobID:
                                
Response:

{
"log":"Job deleted successfully",
"code":"1"
}


36> Forgot Password

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: forgot_password
userName:
                                
Response:

{
"log":"Email sent",
"code":"1"
}

OR

{
"error":"Username not found",
"code":"0"
}



37> Check Token Availability

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: check_token_validity
token:
                                
Response:

{
"log":"Token is valid",
"code":"1"
}
OR 
{
"error":"Token is invalid or has expired",
"code":"0"
}

38> Reset Password

Link: http://castingdb.net/casting_mobile/index.php

Parameters (Post Parameters):
type: reset_password
token:
password:
                                
Response:

{
"log":"Password has been updated",
"code":"1"
}


OR 
{
"error":"Token is invalid or has expired",
"code":"0"
}
