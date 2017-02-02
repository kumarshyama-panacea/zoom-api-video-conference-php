<?php
/*
 * Library Name: Zoom.us API Integration
 * Description:  This library helps developer to connect zoom APi for managing meetings, live conferences.
 *               On this library, we have taken only Mandatory fields. If you wish to pass more parameter, then refer the links we have put before function
 * Author: KumarShyama
 * Version: 1.0
 */

include(dirname(__FILE__).'/configuration.php');

class ZoomAPI{

	/*The API Key, Secret, & URL will be used in every function.*/
	private $api_key = API_KEY;
	private $api_secret = API_SECRET;
	private $api_url = API_URL;

	// Function to send HTTP POST Requests Used by every function below to make HTTP POST call
        
	function sendRequest($calledFunction, $data){
		/*Creates the endpoint URL*/
		$request_url = $this->api_url.$calledFunction;

		/*Adds the Key, Secret, & Datatype to the passed array*/
		$data['api_key'] = $this->api_key;
		$data['api_secret'] = $this->api_secret;
		$data['data_type'] = 'JSON';

		$postFields = http_build_query($data);
		/*Check to see queried fields*/
		/*Used for troubleshooting/debugging*/
		echo $postFields;

		/*Preparing Query...*/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		$response = curl_exec($ch);

		/*Check for any errors*/
		$errorMessage = curl_exec($ch);
		echo $errorMessage;
		curl_close($ch);

		/*Will print back the response from the call*/
		/*Used for troubleshooting/debugging		*/
		echo $request_url;
		var_dump($data);
		var_dump($response);
		if(!$response){
			return false;
		}
		/*Return the data in JSON format*/
		return json_encode($response);
	}
	
        
        // Functions for management of users (Ref: https://support.zoom.us/hc/en-us/articles/201363033-REST-User-API)
        
	function createAUser($userEmail, $userType){		
		$createAUserArray = array();
		$createAUserArray['email'] = $userEmail;
		$createAUserArray['type'] = $userType;
		return $this->sendRequest('user/create', $createAUserArray);
	}   

	function autoCreateAUser($userEmail, $userType, $userPassword){
	  $autoCreateAUserArray = array();
	  $autoCreateAUserArray['email'] = $userEmail;
	  $autoCreateAUserArray['type'] = $userType;
	  $autoCreateAUserArray['password'] = $userPassword;
	  return $this->sendRequest('user/autocreate', $autoCreateAUserArray);
	}

	function custCreateAUser($userEmail, $userType){
	  $custCreateAUserArray = array();
	  $custCreateAUserArray['email'] = $userEmail;
	  $custCreateAUserArray['type'] = $userType;
	  return $this->sendRequest('user/custcreate', $custCreateAUserArray);
	}  

	function deleteAUser($userId){
	  $deleteAUserArray = array();
	  $deleteAUserArray['id'] = $userId;
	  return $this->sendRequest('user/delete', $deleteUserArray);
	}     

	function listUsers(){
	  $listUsersArray = array();
	  return $this->sendRequest('user/list', $listUsersArray);
	}   

	function listPendingUsers(){
	  $listPendingUsersArray = array();
	  return $this->sendRequest('user/pending', $listPendingUsersArray);
	}    

	function getUserInfo($userId){
	  $getUserInfoArray = array();
	  $getUserInfoArray['id'] = $userId;
	  return $this->sendRequest('user/get',$getUserInfoArray);
	}   

	function getUserInfoByEmail($userEmail, $userLoginType){
	  $getUserInfoByEmailArray = array();
	  $getUserInfoByEmailArray['email'] = $userEmail;
	  $getUserInfoByEmailArray['login_type'] = $userLoginType;
	  return $this->sendRequest('user/getbyemail',$getUserInfoByEmailArray);
	}  

	function updateUserInfo($userId){
	  $updateUserInfoArray = array();
	  $updateUserInfoArray['id'] = $userId;
	  return $this->sendRequest('user/update',$updateUserInfoArray);
	}  

	function updateUserPassword($userId, $userNewPassword){
	  $updateUserPasswordArray = array();
	  $updateUserPasswordArray['id'] = $userId;
	  $updateUserPasswordArray['password'] = $userNewPassword;
	  return $this->sendRequest('user/updatepassword', $updateUserPasswordArray);
	}      

	function setUserAssistant($userId, $userEmail, $assistantEmail){
	  $setUserAssistantArray = array();
	  $setUserAssistantArray['id'] = $userId;
	  $setUserAssistantArray['host_email'] = $userEmail;
	  $setUserAssistantArray['assistant_email'] = $assistantEmail;
	  return $this->sendRequest('user/assistant/set', $setUserAssistantArray);
	}     

	function deleteUserAssistant($userId, $userEmail, $assistantEmail){
	  $deleteUserAssistantArray = array();
	  $deleteUserAssistantArray['id'] = $userId;
	  $deleteUserAssistantArray['host_email'] = $userEmail;
	  $deleteUserAssistantArray['assistant_email'] = $assistantEmail;
	  return $this->sendRequest('user/assistant/delete',$deleteUserAssistantArray);
	}   

	function revokeSSOToken($userId, $userEmail){
	  $revokeSSOTokenArray = array();
	  $revokeSSOTokenArray['id'] = $userId;
	  $revokeSSOTokenArray['email'] = $userEmail;
	  return $this->sendRequest('user/revoketoken', $revokeSSOTokenArray);
	}      

	function deleteUserPermanently($userId, $userEmail){
	  $deleteUserPermanentlyArray = array();
	  $deleteUserPermanentlyArray['id'] = $userId;
	  $deleteUserPermanentlyArray['email'] = $userEmail;
	  return $this->sendRequest('user/permanentdelete', $deleteUserPermanentlyArray);
	} 
        
        

	// Functions for management of meetings (Ref: https://support.zoom.us/hc/en-us/articles/201363053-REST-Meeting-API)
        
	function createAMeeting($userId, $meetingTopic, $meetingType){
	  $createAMeetingArray = array();
	  $createAMeetingArray['host_id'] = $userId;
	  $createAMeetingArray['topic'] = $meetingTopic;
	  $createAMeetingArray['type'] = $meetingType;
	  return $this->sendRequest('meeting/create', $createAMeetingArray);
	}

	function deleteAMeeting($meetingId, $userId){
	  $deleteAMeetingArray = array();
	  $deleteAMeetingArray['id'] = $meetingId;
	  $deleteAMeetingArray['host_id'] = $userId;
	  return $this->sendRequest('meeting/delete', $deleteAMeetingArray);
	}

	function listMeetings($userId){
	  $listMeetingsArray = array();
	  $listMeetingsArray['host_id'] = $userId;
	  return $this->sendRequest('meeting/list',$listMeetingsArray);
	}

	function getMeetingInfo(){
      $getMeetingInfoArray = array();
	  $getMeetingInfoArray['id'] = $_POST['meetingId'];
	  $getMeetingInfoArray['host_id'] = $_POST['userId'];
	  return $this->sendRequest('meeting/get', $getMeetingInfoArray);
	}

	function updateMeetingInfo($meetingId, $userId){
	  $updateMeetingInfoArray = array();
	  $updateMeetingInfoArray['id'] = $meetingId;
	  $updateMeetingInfoArray['host_id'] = $userId;
	  return $this->sendRequest('meeting/update', $updateMeetingInfoArray);
	}

	function endAMeeting($meetingId, $userId){
          $endAMeetingArray = array();
	  $endAMeetingArray['id'] = $meetingId;
	  $endAMeetingArray['host_id'] = $userId;
	  return $this->sendRequest('meeting/end', $endAMeetingArray);
	}

	function listRecording($userId){
            $listRecordingArray = array();
	  $listRecordingArray['host_id'] = $userId;
	  return $this->sendRequest('recording/list', $listRecordingArray);
	}


	

	// Functions for management of webinars (Ref: https://support.zoom.us/hc/en-us/articles/204484645-REST-Webinar-API)
        
	function createAWebinar($userId, $topic){
	  $createAWebinarArray = array();
	  $createAWebinarArray['host_id'] = $userId;
	  $createAWebinarArray['topic'] = $topic;
          $createAWebinarArray['option_audio'] = 'both';
          $createAWebinarArray['type'] = '5';
	  return $this->sendRequest('webinar/create',$createAWebinarArray);
	}

	function deleteAWebinar($webinarId, $userId){
	  $deleteAWebinarArray = array();
	  $deleteAWebinarArray['id'] = $webinarId;
	  $deleteAWebinarArray['host_id'] = $userId;
	  return $this->sendRequest('webinar/delete',$deleteAWebinarArray);
	}

	function listWebinars($userId){
	  $listWebinarsArray = array();
	  $listWebinarsArray['host_id'] = $userId;
	  return $this->sendRequest('webinar/list',$listWebinarsArray);
	}

	function getWebinarInfo($webinarId, $userId){
	  $getWebinarInfoArray = array();
	  $getWebinarInfoArray['id'] = $webinarId;
	  $getWebinarInfoArray['host_id'] = $userId;
	  return $this->sendRequest('webinar/get',$getWebinarInfoArray);
	}

	function updateWebinarInfo($webinarId, $userId){
	  $updateWebinarInfoArray = array();
	  $updateWebinarInfoArray['id'] = $webinarId;
	  $updateWebinarInfoArray['host_id'] = $userId;
	  return $this->sendRequest('webinar/update',$updateWebinarInfoArray);
	}

	function endAWebinar($webinarId, $userId){
	  $endAWebinarArray = array();
	  $endAWebinarArray['id'] = $webinarId;
	  $endAWebinarArray['host_id'] = $userId;
	  return $this->sendRequest('webinar/end',$endAWebinarArray);
	}
        
        // Functions for management of Dashboard (Ref: https://support.zoom.us/hc/en-us/articles/208403693-REST-Dashboard-API)
        
        function getMeetingList($type=1, $from, $to){
	  $createADashboardArray = array();
	  $createADashboardArray['type'] = $type;
	  $createADashboardArray['from'] = $from;
          $createADashboardArray['to'] = $to;
	  return $this->sendRequest('metrics/meetings',$createADashboardArray);
	}
        
        function getMeetingDetails($meeting_id, $type){
	  $createADashboardArray = array();
	  $createADashboardArray['meeting_id'] = $meeting_id;
	  $createADashboardArray['type'] = $type;
	  return $this->sendRequest('metrics/meetingdetail',$createADashboardArray);
	}
        
        function getWebnairList($type=1, $from, $to){
	  $createADashboardArray = array();
	  $createADashboardArray['type'] = $type;
	  $createADashboardArray['from'] = $from;
          $createADashboardArray['to'] = $to;
	  return $this->sendRequest('metrics/webinars',$createADashboardArray);
    	}
        
        function getWebnairDetails($meeting_id, $type){
	  $createADashboardArray = array();
	  $createADashboardArray['meeting_id'] = $meeting_id;
	  $createADashboardArray['type'] = $type;
	  return $this->sendRequest('metrics/webinardetail',$createADashboardArray);
    	}
        
        function getUserQoS($meeting_id, $type, $user_id){
	  $createADashboardArray = array();
	  $createADashboardArray['meeting_id'] = $meeting_id;
	  $createADashboardArray['type'] = $type;
          $createADashboardArray['user_id'] = $user_id;          
	  return $this->sendRequest('metrics/qos',$createADashboardArray);
    	}
        
        function zoomRoomList(){
	  return $this->sendRequest('metrics/zoomrooms');
    	}
        
        function getCRCPortUsage($from, $to){
	  $createADashboardArray = array();
	  $createADashboardArray['from'] = $from;
	  $createADashboardArray['to'] = $to;        
	  return $this->sendRequest('metrics/crc',$createADashboardArray);
    	}
      
         // Functions for management of Report (Ref: https://support.zoom.us/hc/en-us/articles/201363083-REST-Report-API)

        function getDailyReport($year, $month){
	  $createAccountReportArray = array();
	  $createAccountReportArray['year'] = $year;
	  $createAccountReportArray['month'] = $month;        
	  return $this->sendRequest('report/getdailyreport',$createAccountReportArray);
    	}
        
        function getAccountReport($from, $to){
	  $createAccountReportArray = array();
	  $createAccountReportArray['from'] = $from;
	  $createAccountReportArray['to'] = $to;        
	  return $this->sendRequest('report/getaccountreport',$createAccountReportArray);
    	}
        
        function getUserReport($user_id, $from, $to){
	  $createAccountReportArray = array();
          $createAccountReportArray['user_id'] = $user_id;
	  $createAccountReportArray['from'] = $from;
	  $createAccountReportArray['to'] = $to;        
	  return $this->sendRequest('report/getuserreport',$createAccountReportArray);
    	}
        
        function getAudioReport($from, $to){
	  $createAccountReportArray = array();
	  $createAccountReportArray['from'] = $from;
	  $createAccountReportArray['to'] = $to;        
	  return $this->sendRequest('report/getaudioreport',$createAccountReportArray);
    	}
        
        // Functions for management of Archived Chat Messages (Ref: https://support.zoom.us/hc/en-us/articles/208064196-REST-Archived-Chat-Messages-API)
        
        function getChatHistoryList($access_token, $from, $to){
	  $createChattArray = array();
	  $createChattArray['access_token'] = $access_token;
          $createChattArray['from'] = $from;
	  $createChattArray['to'] = $to;        
	  return $this->sendRequest('chat/list',$createChattArray);
    	}
        
        function getChatMessage($access_token, $session_id, $from, $to){
	  $createChattArray = array();
	  $createChattArray['access_token'] = $access_token;
          $createChattArray['session_id'] = $session_id;
          $createChattArray['from'] = $from;
	  $createChattArray['to'] = $to;        
	  return $this->sendRequest('chat/get',$createChattArray);
    	}
        
        // Functions for management of Archived Chat Messages (Ref: https://support.zoom.us/hc/en-us/articles/208064196-REST-Archived-Chat-Messages-API)
        
        function getIMGroupsList(){
	  return $this->sendRequest('im/group/list');
    	}
        
        function getIMGroupsInfo($group_id){
	  $createIMArray = array();
	  $createIMArray['id'] = $group_id;
                  
	  return $this->sendRequest('im/group/get',$createIMArray);
    	}
        
        function createIMGroup($name){
	  $createIMArray = array();
	  $createIMArray['name'] = $name;
                  
	  return $this->sendRequest('im/group/create',$createIMArray);
    	}
        
        function editIMGroup($group_id){
	  $createIMArray = array();
	  $createIMArray['id'] = $group_id;
                  
	  return $this->sendRequest('im/group/edit',$createIMArray);
    	}
        
        function deleteIMGroup($group_id){
	  $createIMArray = array();
	  $createIMArray['id'] = $group_id;
                  
	  return $this->sendRequest('im/group/delete',$createIMArray);
    	}
        
        function AddIMGroupMember($group_id, $member_ids){
	  $createIMArray = array();
	  $createIMArray['id'] = $group_id;
          $createIMArray['member_ids'] = $member_ids;  
          
	  return $this->sendRequest('im/group/member/add',$createIMArray);
    	}
        
        function deleteIMGroupMember($group_id, $member_ids){
	  $createIMArray = array();
	  $createIMArray['id'] = $group_id;
          $createIMArray['member_ids'] = $member_ids;  
          
	  return $this->sendRequest('im/group/member/delete',$createIMArray);
    	}
        
        // Functions for management of Cloud Recording API (Ref: https://support.zoom.us/hc/en-us/articles/206324325-REST-Cloud-Recording-API)
        
        function getRecordingList($host_id){
          $createCloudRecordingArray = array();
          $createCloudRecordingArray['host_id'] = $host_id;
          
	  return $this->sendRequest('recording/list', $createCloudRecordingArray);
    	}
        
        function getRecordingForMachine($host_id){
          $createCloudRecordingArray = array();
          $createCloudRecordingArray['host_id'] = $host_id;
          
	  return $this->sendRequest('mc/recording/list', $createCloudRecordingArray);
    	}
        
        function getRecording($meeting_id){
          $createCloudRecordingArray = array();
          $createCloudRecordingArray['meeting_id'] = $meeting_id;
          
	  return $this->sendRequest('recording/get', $createCloudRecordingArray);
    	}
        
        function deleteRecording($meeting_id){
          $createCloudRecordingArray = array();
          $createCloudRecordingArray['meeting_id'] = $meeting_id;
          
	  return $this->sendRequest('recording/delete', $createCloudRecordingArray);
    	}
    }

?> 