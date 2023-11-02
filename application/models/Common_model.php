<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Common_model extends CI_Model 
{

	
	function getSingleArrayByQuery($query)

	{
		$query = $this->db->query($query);

	    return $query->row_array();
	}
	
  public function curl_url_get($url){

	        $dx_curl = curl_init();

			curl_setopt_array($dx_curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_POSTFIELDS => "",
			  CURLOPT_HTTPHEADER => array(
			    "Postman-Token: e33f8e2c-7713-46cc-8b25-17ff6166e765",
			    "cache-control: no-cache"
			  ),
			));

			$dx_response = json_decode(curl_exec($dx_curl));
			$err = curl_error($dx_curl);
			curl_close($dx_curl);
			if ($err) {
			  return $err;
			} else {
			  return $dx_response;
			}
		}

	public function curl_url_post($url,$data_string){

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tx_response = json_decode(curl_exec($ch));
            $err = curl_error($ch);
            curl_close($ch);
            if ($err) {
              // return $err;
            } else {
            	return $tx_response;
    		}
	}


	public function admin_login($username, $password, $user_type = '1') {
		if($username && $password) {
			$sql = "SELECT * FROM users WHERE email = '$username' && user_type = '$user_type'";
			$query = $this->db->query($sql);

			if($query->num_rows() == 1) {
				$result = $query->row_array();

				$hash_password = md5($password);
				if($hash_password == $result['password']) {
					return $result;	
				}
				else {
					return false;
				}
			}
			else {
				return false;
			}
		}
	}

   /* Add new methods from Admin panel */

  public function checklogin($allow)
  {
       $f_name = $this->router->fetch_method();
       $user = $this->session->userdata('passzone_admin_data');

       // print_r($user);
       // die;
       // echo $f_name;
       // die;
       if(empty($user))
       {
      	  if(in_array($f_name, $allow))		
	      {
	      	return true;
	      }else
	      {
	      	redirect("admin");
	      }
       }		
  }

  public function updateData($tab,$data,$whr)
  {
    return $this->db->update($tab,$data,$whr);
    echo $this->db->last_query(); die();

    //return true;
  }

	public function getUserProfile($whr,$orderby) {
		$query="select 
		u.id,
		u.full_name,
		u.email,
		case when u.gender='Male' then 'Male' else 'Female' end as gender,
		case when u.profile_pic is not null then concat('http://espsofttechnologies.com/freedomcell/uploads/users_profile/', u.profile_pic) else 'http://espsofttechnologies.com/freedomcell/uploads/users_profile/avatar.jpg' end as profile_pic,
		api_key,
		is_enable_google_auth_code
	from 
		users as u ".$whr." ".$orderby."";
	//echo $query;die;
	$query = $this->db->query($query);
	

	return $query->result_array();		
	}


	public function getCertificationtype($whr) {
	$query = $this->db->query("
		SELECT 
			ct.id,
			ct.name,
			e.id as eventtypeid,
			e.name as eventtypename 
		FROM 
			certificationtype as ct 
		left join 
			eventtype as e on e.id=ct.eventtypeid 
		$whr");
	return $query->result_array();		
	}

	public function getUserCertifications($whr) {
	$query = "SELECT uc.id as id, uc.userid,et.name as eventtype,ct.name as certificationtype,  
	case when uc.level=0 then 'Beginner' when uc.level=1 then 'Intermediate' when uc.level=2 then 'Advance' end as level,et.logo FROM usercertification as uc
left join certificationtype as ct on ct.id=uc.certificationtypeid
left join eventtype as et on et.id=uc.eventtypeid
 $whr";

	$query=$this->db->query($query);
	return $query->result_array();		
	}

	public function getUsereventtype($whr) {
	$query = $this->db->query("
		SELECT 
			ue.id,
			u.fullname,
			et.name as eventtype,
			case when level=1 then'Beginner' when level=2 then 'Intermediate' when level=3 then 'Advance' end as level
		FROM 
			usereventtype as ue 
		left join 
			userss as u on u.id=ue.userid 
		$whr");
	return $query->result_array();		
	}


		public function getEventDetail($whr,$orderby) {
	$query = "SELECT 
			e.id,
			e.eventname,
			cg.name as chatgroupname,
			e.chatgroupid,
			e.eventdetail,
			e.eventdate,
			e.eventtypeid,
			geteventlikecount(e.id) as likecount,
			et.name as eventtype,
			es.id as eventstatusid,
			case when e.eventdate<now() then 'Hosting dive' else  es.name end as eventstatus,
			u.id as userid,
			u.fullname,
			u.profile_pic,
			e.latitude,
			e.longitude,
			getdistance(e.latitude,e.longitude,u.latitude,u.longitude) as distance,
			e.minmembersize,
			e.maxmembersize,
			case when e.participentskill=0 then 'Beginner' when e.participentskill=1 then 'Intermediate' when e.participentskill=2 then 'Advance' end as participentskill,
			case when e.isprivate=1 then 'Private' else 'Public' end as isprivate,
			e.isforinvite
		FROM 
			event as e 
		left join 
			eventtype as et on et.id=e.eventtypeid 
		left join 
			eventstatus as es on es.id=e.eventstatusid 
		left join 
			users as u on u.id=e.userid 
		left join 
			chatgroup as cg on cg.id=e.chatgroupid
		left join 
			userprofile as up on up.userid=u.id
		$whr $orderby";
		//echo $query;die;
		$query=$this->db->query($query);
	
			return $query->result_array();		
	}

	public function getChatgroupDetail($whr,$orderby) {
		//echo $whr;die;
	$query = "
		SELECT 
			cg.id,
			cg.name,
			cg.description,
			cg.logo,
			getchatgroupmembercount(cg.id) as membercount,
			et.name as eventtype,
			et.id as eventtypeid,
			u.fullname as createdby,
			u.id as userid,
			u.firebaseid,
			cg.firebaseid as chatgroupid,
			u.profile_pic,
			cg.latitude,
			cg.longitude,
			case when cg.jointype=0 then 'Anyone can join' else 'Request for join' end as jointype,
			cg.datetime as createdate
		FROM 
			chatgroup as cg 
		left join 
			eventtype as et on et.id=cg.eventtypeid
		left join 
			users as u on u.id=cg.userid 
		$whr and cg.isdeleted=false $orderby ";
		//echo $query;
		$query=$this->db->query($query);
		
			return $query->result_array();		
	}


	public function getCommunity($whr) {
	$query = $this->db->query("
		SELECT 
			e.eventname,
			e.eventdetail,
			et.name as eventtype,
			es.name as eventstatus,
			u.first_name,
			u.last_name,
			u.nickname,
			c.name as country,
			u.city,
			e.event_icon,
            count(em.id) as membercount,
            count(el.id) as likecount,
            count(ec.id) as commentcount
		FROM 
			event as e 
		left join 
			eventtype as et on et.id=e.eventtypeid 
		left join 
			eventstatus as es on es.id=e.eventstatusid 
		left join 
			users as u on u.id=e.userid 
		left join 
			userprofile as up on up.userid=u.id
		left join 
			country as c on c.id=up.countryid
        left join 
             eventmember as em on em.eventid=e.id and em.isapproved and em.isblocked=0
        left join 
        	 eventlike as el on el.eventid=e.id
        left join eventcomment as ec on ec.eventid=e.id and ec.isdeleted=0
		WHERE e.id in (select distinct eventid from eventmember as em $whr)
        group by e.eventname,e.eventdetail,et.name,es.name,u.first_name,u.last_name,u.nickname,c.name,u.city,e.event_icon");
			return $query->result_array();		
	}
	

			public function calander($userid,$eventtypeid,$city,$proximity) {
	$sql="SELECT 
			eventdate,
			count(id) as count 
		
		FROM 
			event as e 
		where eventdate>CURRENT_DATE AND eventtypeid=$eventtypeid 
		AND CAST(getusercity(userid) AS CHAR(50)) like '%$city%' and getdistance(cast(getuserlatitude($userid)  AS DECIMAL(10,6)),cast(getuserlongitude($userid) as DECIMAL(10,6)),CAST(getuserlatitude(userid) AS DECIMAL(10,6)) ,CAST(getuserlongitude(userid) AS DECIMAL(10,6)))<$proximity and e.isdeleted=false
		group by eventdate
		order by eventdate";
		
	$query = $this->db->query($sql);
			return $query->result_array();		
	}
 
		
	

			public function getEventMemberList($whr){
	$query = $this->db->query("
		SELECT 
			u.fullname,
			u.nickname,
			u.profile_pic,
			u.city,
			case when up.show_mobile<>0  then u.mobile else '' end as mobile,
			case when em.isapproved<>0  then 'Approved' else 'Approval Pending' end as isapproved
		FROM 
			eventmember as em 
		left join 
			users as u on u.id=em.memberid 
		left join 
			userprofile as up on up.userid=u.id 
		$whr");
			return $query->result_array();		
	}
		

	public function getChatgroupMemberList($whr){
		$query = $this->db->query("
		SELECT 
			u.fullname,
			u.nickname,
			u.profile_pic,
			u.city,
			case when up.show_mobile<>0  then u.mobile else '' end as mobile,
			case when cgm.isapproved<>0  then 'Approved' else 'Approval Pending' end as isapproved
		FROM 
			chatgroupmember as cgm 
		left join 
			users as u on u.id=cgm.memberid 
		left join 
			userprofile as up on up.userid=u.id 
		$whr");
			return $query->result_array();		
	}

public function getArrayByQuery($query)
	{
		$result =  $this->db->query($query);
		return $result->result_array();
	}



/*	
  public function userInfo($user_id)
  {
    
	    $this->db->where('id', $user_id );
		$query = $this->db->get('students');
	    $result = $query->row_array();


	    // Get student formal results
	    $this->db->select("results.result_class, results.result_time, results.rank, results.result_date ,cities.city_name,categories.cat_title as category ,sub_cats.cat_title as subcategory ,students.first_name, students.last_name");
	    $this->db->from("results");
	    $this->db->join("cities","results.city_id = cities.id","left");
	    $this->db->join("categories","results.category_id = categories.id","left");
	    $this->db->join("sub_cats","results.subcategory_id = sub_cats.id","left");
	    $this->db->join("students","results.student_id = students.id","left");
	    $this->db->where("results.student_id",$user_id);
	    $this->db->where("results.type", 1);
	    $query = $this->db->get();   
	    $result['formal_results'] = $query->result_array();	


	    // Get student In-formal results...
	    $this->db->select("results.result_class, results.result_time, results.rank, results.result_date ,cities.city_name,categories.cat_title as category ,sub_cats.cat_title as subcategory ,students.first_name, students.last_name");
	    $this->db->from("results");
	    $this->db->join("cities","results.city_id = cities.id","left");
	    $this->db->join("categories","results.category_id = categories.id","left");
	    $this->db->join("sub_cats","results.subcategory_id = sub_cats.id","left");
	    $this->db->join("students","results.student_id = students.id","left");
	    $this->db->where("results.student_id",$user_id);
	    $this->db->where("results.type", 2);
	    $query = $this->db->get();   
	    $result['informal_results'] = $query->result_array();	
    
	    return $result;
  }
  public function walletInfo()
  { 
	    $this->db->select("wallet.*,users.username");
	    $this->db->from("wallet");
	    $this->db->join("users","wallet.user_id = users.id");
	    $query = $this->db->get();   
	    return $query->result_array();
  }

  public function insertRecord($table,$post_data)
  {
    $this->db->insert($table,$post_data);
    return $this->db->insert_id();
  }
*/
	public function do_delete($table,$id)
	{
		$this->db->where('id', $id);
		$this->db->delete($table);
		return ($this->db->affected_rows() != 1) ? false : true;
	}  
/*
    public function allclub()
  { 
	    $query = $this->db->query("SELECT id,club_image,club_title,club_description FROM clubs where status!=2 ");
	    return $query->result_array();
  }
  
  public function wallet_transactionsInfo()
  { 
	    $this->db->select("wallet_transactions.*,users.username");
	    $this->db->from("wallet_transactions");
	    $this->db->join("users","wallet_transactions.user_id = users.id");
	    $query = $this->db->get();   
	    return $query->result_array();
  }*/
  public function getalldata($table)
  {
        $query = $this->db->get($table);
        return $query->result_array();
  }

  public function getSigleData($table)
  {
        $query = $this->db->get($table);
        return $query->row_array();
  }


   /* End */ 

	public function getWhereData($tab,$whr)
    {

    	$result = $this->db->get_where($tab,$whr)->result_array();
    	return $result;
    } 

    function getAllRecords($table)

	{

		$query = $this->db->get($table);

		return $query->result_array();

	}

	

    function getSingleRecordById($table,$conditions)

	{

	   $query = $this->db->get_where($table,$conditions);

	   return $query->row_array();

	}

	 

	function getAllRecordsById($table,$conditions)

	{

	   $query = $this->db->get_where($table,$conditions);

		return $query->result_array();

	}


/*	function getAllStudentRecords()

	{

	    $this->db->select("students.*,cities.city_name");
	    $this->db->from("students");
	    $this->db->join("cities","students.city = cities.id","left");
	    $query = $this->db->get();   
	    return $query->result_array();		
	}
*/
	function getAllRecordsOrderById($table, $field, $short, $conditions)

	{

	   $this->db->order_by($field, $short);

	   $query = $this->db->get_where($table,$conditions);

	   return $query->result_array();

	}



    function addRecords($table,$post_data)

	{

		$this->db->insert($table,$post_data); 

		return $this->db->insert_id(); 

	}



	function addRecordsReturnId($table,$post_data)

	{

		$this->db->insert($table,$post_data);

		return $this->db->insert_id(); 

	}

	
 
	function updateRecords($table, $post_data, $where_condition)

	{

		$this->db->where($where_condition);

		$this->db->update($table, $post_data);

		return true;  

	}

	

	function deleteRecords($table,$where_condition)

	{		

	    $this->db->where($where_condition);

		$this->db->delete($table);

		//echo $this->db->last_query(); die();
		return true; 

	}	

	/*

	function getPaginateRecords($table, $result, $offset = 0)

	{

		$query = $this->db->get($table,$result,$offset);

	    return $query->result_array();

	}



	function getPaginateRecordsByConditions($table, $result, $offset=0, $condition)

	{

		$query = $this->db->get_where($table, $condition, $result, $offset);

	    return $query->result_array();

	}



	function getPaginateRecordsByLikeConditions($table, $result, $offset=0, $condition, $like_field, $like_value)

	{

		$this->db->like($like_field, $like_value);

		$query = $this->db->get_where($table, $condition, $result, $offset);

	    return $query->result_array();

	}

	function multiple_insert($tab,$data)
	{
      $this ->db-> insert_batch($tab,$data);
		return $this->db->insert_id();
	}



	function getTotalRecords($table)

	{

		$query = $this->db->get($table);

		return $query->num_rows();

	}

	function getTotalRecordsByIdLike($table, $condition, $like_field, $like_value)

	{

	    $this->db->like($like_field, $like_value);

	    $query = $this->db->get_where($table, $condition);

		return $query->num_rows();

	}

	

	function getPaginateRecordsByCondition($table,$result,$offset=0,$where_condition,$condition)

	{

	    $this->db->where($where_condition,$condition);

		$query = $this->db->get($table,$result,$offset);

	    return $query->result_array();

	}



	function getPaginateRecordsByOrderByCondition($table, $field, $short, $result, $offset=0, $condition)

	{

	    $this->db->where($condition);

	    $this->db->order_by($field, $short);

		$query = $this->db->get($table,$result,$offset);

	    return $query->result_array();

	}

/*	function getAllOrders($whr){



     $this->db->select('o.*,u.reg_id as user_reg_id ,c.name as college_name,c.college_address as college_address,c.state as college_state,c.city as college_city,c.zipcode as college_zipcode,u.first_name,u.last_name,u.email,u.mobile');

     $this->db->from('orders  as o');

     $this->db->join('users as u','o.user_id = u.id');

     $this->db->join('college as c','u.college_id = c.id');

     $this->db->order_by('o.create_date','desc');

     $this->db->where($whr);

     $this->db->last_query();

     $query = $this->db->get();

     return $query->result_array();

  }

*/

	function getTotalRecordsByCondition($table, $condition)

	{

	    $this->db->where($condition);

		$query = $this->db->get($table);

		return $query->num_rows();

	}


	function fetchMaxRecord($table,$field)

	{

		$this->db->select_max($field,'max');

        $query = $this->db->get($table);

		return $query->row_array();	

	}



	function fetchRecordsByOrder($table,$field,$sort)

	{

	    $this->db->order_by($field,$sort);

		$query = $this->db->get($table);

		return $query->result_array();

	}			

			

	function getAllRecordsByLimitId($table,$conditions,$limit)

	{

	    $this->db->limit($limit);

		$query = $this->db->get_where($table,$conditions);

		return $query->result_array();

	}

	

	function getLatestRecords($table,$date,$limit)

	{

	    $this->db->order_by($date,'desc');

	    $this->db->limit($limit);

		$query = $this->db->get($table);

		return $query->result_array();

	}

	

	function getRelatedRecords($table,$date,$conditions)

	{

	    $this->db->order_by($date,'desc');

	    $this->db->limit(4);

		$query = $this->db->get_where($table,$conditions);

		return $query->result_array();

	}

	

	function getAscLatestRecords($table,$date,$limit)

	{

	    $this->db->order_by($date,'asc');

	    $this->db->limit($limit);

		$query = $this->db->get($table);

		return $query->result_array();

	}

	

	function getLimitedRecords($table,$limit)

	{

	    $this->db->limit($limit);

		$query = $this->db->get($table);

		return $query->result_array();

	}


	function getwherebycondition($table, $where_condition)

	{

	    $this->db->where($where_condition);

		$query = $this->db->get($table);

		return $query->result_array();

	}
	function getRecordCount($table, $where_condition)

	{
		$this->db->where($where_condition);

		$query = $this->db->get($table);

		return $query->num_rows();

	}
	function getTotalRecordCount($table)

	{
		$query = $this->db->get($table);

		return $query->num_rows();

	}


/*
	public function gettansactiondetail()
    {
    	$sql ="SELECT 
				`user_account`.*,
				`users`.`firstname`,
				user_account.txn_id as txnid,
		 
				user_account.txn_type as txnt,
				if(user_account.payment_method = 'wallet',(SELECT users.firstname as to_name FROM wallet_txn INNER JOIN `users` ON `users`.`id` =  wallet_txn.from_id

		                WHERE wallet_txn.id = txnid), (SELECT users.firstname as to_name FROM user_txn INNER JOIN `users` ON `users`.`id` = user_txn.user_id  WHERE user_txn.id = txnid)) as  to_name

				FROM `user_account`
		             LEFT JOIN `users` ON `users`.`id` = `user_account`.`user_id`
		             
		             ORDER BY `create_date` DESC";
		  $result = $this->db->query($sql)->result_array();
    	 $this->db->last_query(); die();
    	return $result;
    }

    function getclubcategries()
    {
    	$sql = "SELECT sub_cats.*,categories.cat_title as category_title
    			FROM sub_cats 
    			LEFT JOIN categories ON sub_cats.cat_id=categories.id
    			WHERE sub_cats.status != '2'
    			ORDER BY sub_cats.id DESC";
    	$result = $this->db->query($sql)->result_array();
    	//echo $this->db->last_query(); die();
    	return $result;

    }

    public function getwhrcategories($whr,$orderby)
    {
    	$sql = "SELECT *
    			FROM categories
    			$whr
    			$orderby";
    	$result = $this->db->query($sql)->result_array();
    	// $this->db->last_query(); die();
    	return $result;
    }

        

    function processOrderPayment($dataArr)

    {

        // prep the bundle

        $url = "https://api.paystack.co/transaction/charge_token";

        $apiKey = "sk_test_f6b3799048ee24455714bbe6f13be7f5d2cbda8a";

        

        $requestArr = array();

        $requestArr['token'] = $dataArr['token'];

        $requestArr['amount'] = $dataArr['amount'];

        $requestArr['email'] = $dataArr['email'];        

        $headers = array("Content-Type:" . "application/json", "Authorization:" . "Bearer " . $apiKey);

        // Open connection

        $ch = curl_init();

        // Set the url, number of POST vars, POST data

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);



        // Disabling SSL Certificate support temporarly

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestArr));



        // Execute post

        $result = curl_exec($ch);

        if ($result === FALSE) {

            die('Curl failed: ' . curl_error($ch));

        }

        //echo "<pre>";print_r($result);die;

        // Close connection

        curl_close($ch);  

        

        $resultArr = json_decode($result);

        return $resultArr;

    }
*/

    public function getwherecount($tab,$col,$whr)
    {
		$sql = "SELECT COUNT($col) as total_count
		FROM $tab
		$whr";
		$result = $this->db->query($sql)->row_array();
		// echo $this->db->last_query(); die();
		return $result['total_count'];
    }

    public function getwheresum($tab,$col,$whr)
    {
		$sql = "SELECT SUM($col) as total_price
		FROM $tab
		$whr";
		$result = $this->db->query($sql)->row_array();
		return $result['total_price'];
    }

// 	function getAllCity($table)
// 	{
// 	   $query = $this->db->get($table);
//        return $query->result_array();
// 	}
// 	function getAllRegion()
// 	{
// 	   $query = $this->db->query("SELECT regions.*, group_cats.cat_title, groups.group_name, students.first_name, students.last_name,students.dob FROM regions,group_cats, students, groups WHERE regions.category_id=group_cats.id AND regions.student_id=students.id AND groups.id=regions.group_id AND regions.status!=2 ");

// 	   // $sql = 	"SELECT 
// 	   // 				results.*, 
// 	   // 				categories.cat_title as category,
// 	   // 				cities.city_name, 
// 	   // 				students.first_name, 
// 	   // 				students.last_name,
// 	   // 				students.dob, 
// 	   // 				sub_cats.cat_title 
// 	   // 			FROM results 
// 	   // 			LEFT JOIN categories
// 	   // 			ON results.category_id=categories.id 
// 	   // 			LEFT JOIN students 
// 	   // 			ON results.student_id=students.id 
// 	   // 			LEFT JOIN sub_cats 
// 	   // 			ON results.subcategory_id=sub_cats.id 
// 	   // 			LEFT JOIN cities 
// 	   // 			ON cities.id=results.city_id
// 	   // 			WHERE results.status!=2 ";

// 	   // $query = $this->db->query($query);
//        return $query->result_array();
// 	}

	
// 	function getRegionDataApi($student_id)
// 	{
// 	    $this->db->select("regions.result_class, regions.result_time, regions.rank, regions.result_date ,groups.group_name, group_cats.cat_title,regions.first_name, students.last_name, students.club_id");
// 	    $this->db->from("regions");
// 	    $this->db->join("groups","regions.group_id = groups.id","left");
// 	    $this->db->join("group_cats","regions.category_id = group_cats.id","left");
// 	    $this->db->join("students","regions.student_id = students.id","left");
// 	    $this->db->where("regions.student_id",$student_id);
// 	    // $this->db->where("results.category_id",$category_id);
// 	    // $this->db->where("results.subcategory_id",$subcategory_id);
// 	    $this->db->where("regions.type", 1);
// 	    $this->db->order_by("regions.result_time", "asc");
// 	    $query = $this->db->get();   
// 	    return $query->result_array();	
// 	}

// 	function searchRegionDataApi($student_id,$category_id ,$year)
// 	{
// 	    $this->db->select("regions.id,regions.result_class, regions.result_time, regions.rank, regions.result_date,regions.group_id ,groups.group_name,group_cats.cat_title as category ,group_cats.id as category_id ,students.first_name, students.last_name,students.id as studentid, students.club_id, regions.type ");
// 	    $this->db->from("regions");
// 	    $this->db->join("groups","regions.group_id = groups.id","left");
// 	    $this->db->join("group_cats","regions.category_id = group_cats.id","left");
// 	    $this->db->join("students","regions.student_id = students.id","left");
// 	    $this->db->where("regions.student_id",$student_id);
// 	    $this->db->where("regions.category_id",$category_id);
// 	    // $this->db->where("results.type", 2);
// 	    $this->db->like('students.dob', $year);
// 	    $query = $this->db->get();   
// 	    return $query->result_array();	
// 	}

	
// 	function getAllResult()
// 	{
// 	   $query = $this->db->query("SELECT results.*, categories.cat_title as category,cities.city_name, students.first_name, students.last_name,students.dob, sub_cats.cat_title FROM results,categories, students, sub_cats, cities WHERE results.category_id=categories.id AND results.student_id=students.id AND cities.id=results.city_id AND results.subcategory_id=sub_cats.id AND results.status!=2 ");

// 	   // $sql = 	"SELECT 
// 	   // 				results.*, 
// 	   // 				categories.cat_title as category,
// 	   // 				cities.city_name, 
// 	   // 				students.first_name, 
// 	   // 				students.last_name,
// 	   // 				students.dob, 
// 	   // 				sub_cats.cat_title 
// 	   // 			FROM results 
// 	   // 			LEFT JOIN categories
// 	   // 			ON results.category_id=categories.id 
// 	   // 			LEFT JOIN students 
// 	   // 			ON results.student_id=students.id 
// 	   // 			LEFT JOIN sub_cats 
// 	   // 			ON results.subcategory_id=sub_cats.id 
// 	   // 			LEFT JOIN cities 
// 	   // 			ON cities.id=results.city_id
// 	   // 			WHERE results.status!=2 ";

// 	   // $query = $this->db->query($query);
//        return $query->result_array();
// 	}



// 	function getResultDataApi($student_id)
// 	{
// 	    $this->db->select("results.result_class, results.result_time, results.rank, results.result_date ,cities.city_name,categories.cat_title as category ,sub_cats.cat_title as subcategory ,students.first_name, students.last_name, students.club_id");
// 	    $this->db->from("results");
// 	    $this->db->join("cities","results.city_id = cities.id","left");
// 	    $this->db->join("categories","results.category_id = categories.id","left");
// 	    $this->db->join("sub_cats","results.subcategory_id = sub_cats.id","left");
// 	    $this->db->join("students","results.student_id = students.id","left");
// 	    $this->db->where("results.student_id",$student_id);
// 	    // $this->db->where("results.category_id",$category_id);
// 	    // $this->db->where("results.subcategory_id",$subcategory_id);
// 	    $this->db->where("results.type", 1);
// 	    $this->db->order_by("results.subcategory_id", "asc");
// 	    $query = $this->db->get();   
// 	    return $query->result_array();	
// 	}

// 	function searchResultDataApi($student_id,$category_id,$subcategory_id,$year)
// 	{
// 	    $this->db->select("results.id,results.result_class, results.result_time, results.rank, results.result_date,results.city_id, results.subcategory_id ,cities.city_name,categories.cat_title as category ,categories.id as category_id ,sub_cats.cat_title as subcategory ,students.first_name, students.last_name,students.id as studentid, students.club_id, results.type ");
// 	    $this->db->from("results");
// 	    $this->db->join("cities","results.city_id = cities.id","left");
// 	    $this->db->join("categories","results.category_id = categories.id","left");
// 	    $this->db->join("sub_cats","results.subcategory_id = sub_cats.id","left");
// 	    $this->db->join("students","results.student_id = students.id","left");
// 	    $this->db->where("results.student_id",$student_id);
// 	    $this->db->where("results.category_id",$category_id);
// 	    $this->db->where("results.subcategory_id",$subcategory_id);
// 	    // $this->db->where("results.type", 2);
// 	    $this->db->like('students.dob', $year);
// 	    $query = $this->db->get();   
// 	    return $query->result_array();	
// 	}
	
// 	function getWordRanksApi($cat_id,$cinsiyet_id,$klasman_id) {
// 	    $this->db->select("world_rank.isim,world_rank.yer,world_rank.zaman,world_rank.tarih,world_rank.sitil,world_rank.havuz_id");
// 	    $this->db->from("world_rank");
// 		$this->db->join("rank_cinsiyet","world_rank.cinsiyet_id = rank_cinsiyet.id","left");
// 	    $this->db->join("rank_cat","world_rank.cat_id = rank_cat.id","left");
// 	    $this->db->join("rank_klasman","world_rank.klasman_id = rank_klasman.id","left");
// 	    $this->db->where("world_rank.cat_id",$cat_id);
// 	    $this->db->where("world_rank.cinsiyet_id",$cinsiyet_id);
// 	    $this->db->where("world_rank.klasman_id",$klasman_id);
// 	    // $this->db->where("results.type", 1);
// 		$this->db->order_by("world_rank.zaman", "asc");
// 	    $query = $this->db->get();
// 	    return $query->result_array();	
// 	}
	
// 	function getStudentlist($city_id,$category_id,$subcategory_id,$year,$date)
// 	{
// 	    $this->db->select("students.id, clubs.club_title as club_id, students.cat_id, students.first_name, students.last_name, students.student_id, students.email,students.phone, students.dob, students.gender, students.city , students.year,  students.license_number, students.img_url, students.password, students.user_type ,students.status ,students.device_type ,students.device_id ,students.fcm_token ,students.created_at, results.result_time as time");
// 	    $this->db->from("results");
// 	    $this->db->join("cities","results.city_id = cities.id","left");
// 	    $this->db->join("categories","results.category_id = categories.id","left");
// 	    $this->db->join("sub_cats","results.subcategory_id = sub_cats.id","left");
// 	    $this->db->join("students","results.student_id = students.id","left");
// 	    $this->db->join("clubs","clubs.id = students.club_id","left");
// 	    $this->db->where("students.city",$city_id);
// 	    $this->db->where("results.category_id",$category_id);
// 	    $this->db->where("results.subcategory_id",$subcategory_id);
// 	    $this->db->where("results.result_date",$date);
// 	    $this->db->where("students.student_type",1);
// 	    $this->db->order_by("results.result_time", "asc");
// 	    // $this->db->where("results.type", 1);
// 	    $this->db->like('students.dob', $year);
// 	    $query = $this->db->get();   
// 	    return $query->result_array();	
// 	}

// 		function getGroupStudentlist($category_id,$year,$date)
// 	{
// 	    $this->db->select("students.id, clubs.club_title as club_id, cities.city_name as city, students.cat_id, students.first_name, students.last_name, students.student_id, students.email,students.phone, students.dob, students.gender, students.year,  students.license_number, students.img_url, students.password, students.user_type ,students.status ,students.device_type ,students.device_id ,students.fcm_token ,students.created_at, regions.result_time as time");
// 	    $this->db->from("regions");
// 	    $this->db->join("group_cats","regions.category_id = group_cats.id","left");
// 	    $this->db->join("students","regions.student_id = students.id","left");
// 	    $this->db->join("clubs","clubs.id = students.club_id","left");
// 		$this->db->join("cities","cities.id = students.city","left");	
// 	    $this->db->where("regions.category_id",$category_id);
// 	    $this->db->where("regions.result_date",$date);
// 	    $this->db->where("students.student_type",1);
// 	    $this->db->order_by("regions.result_time", "asc");
// 	    // $this->db->where("results.type", 1);
// 	    $this->db->like('students.dob', $year);
// 	    $query = $this->db->get();   
// 	    return $query->result_array();	
// 	}
	
	
// 		function getAllGrouplist($group_id,$category_id,$year,$date)
// 	{
// 	    $this->db->select("students.id, clubs.club_title as club_id, students.cat_id, students.first_name, students.last_name, students.student_id, students.email,students.phone, students.dob, students.gender, students.city , students.year,  students.license_number, students.img_url, students.password, students.user_type ,students.status ,students.device_type ,students.device_id ,students.fcm_token ,students.created_at, regions.result_time as time");
// 	    $this->db->from("regions");
// 		 $this->db->join("groups","regions.group_id = groups.id","left");
// 	    $this->db->join("group_cats","regions.category_id = group_cats.id","left");
// 	    $this->db->join("students","regions.student_id = students.id","left");
// 	    $this->db->join("clubs","clubs.id = students.club_id","left");
// 		 $this->db->where("regions.group_id",$group_id);
// 	    $this->db->where("regions.category_id",$category_id);
// 	    $this->db->where("regions.result_date",$date);
// 	    $this->db->where("students.student_type",1);
// 	    $this->db->order_by("regions.result_time", "asc");
// 	    // $this->db->where("results.type", 1);
// 	    $this->db->like('students.dob', $year);
// 	    $query = $this->db->get();   
// 	    return $query->result_array();	
// 	}

// 	function weekly_result($city_id,$category_id,$subcategory_id,$year)
// 	{
// 	    $this->db->select("results.result_date as weekly_date");
// 	    $this->db->from("results");
// 	    $this->db->join("cities","results.city_id = cities.id","left");
// 	    $this->db->join("categories","results.category_id = categories.id","left");
// 	    $this->db->join("sub_cats","results.subcategory_id = sub_cats.id","left");
// 	    $this->db->join("students","results.student_id = students.id","left");
// 	    $this->db->where("results.city_id",$city_id);
// 	    $this->db->where("results.category_id",$category_id);
// 	    $this->db->where("results.subcategory_id",$subcategory_id);
// 	    $this->db->where("results.type != ", 2);
// 	    $this->db->like('students.dob', $year);
// 	    $this->db->group_by('results.result_date');
// 	    // $this->db->having('results.type != ', 2);
// 	    $query = $this->db->get();   
// 	    return $query->result_array();	
// 	}


// 	function group_result($category_id,$year)
// 	{
// 	    $this->db->select("regions.result_date as weekly_date");
// 	    $this->db->from("regions");
// 	    $this->db->join("group_cats","regions.category_id = group_cats.id","left");
// 	    $this->db->join("students","regions.student_id = students.id","left");
// 	    $this->db->where("regions.category_id",$category_id);
// 	    $this->db->like('students.dob', $year);
// 	    $this->db->group_by('regions.result_date');
// 	    // $this->db->having('results.type != ', 2);
// 	    $query = $this->db->get();   
// 	    return $query->result_array();	
// 	}



// 	function getAllCategory($table)
// 	{
// 	   $query = $this->db->get($table);
//        return $query->result_array();
// 	}

// 	function student_list($city,$year){

// 		$this->db->select('students.* , clubs.club_title');
// 		$this->db->from('students');
// 		$this->db->join('clubs', 'clubs.id = students.club_id' , 'left');
// 		$this->db->where('students.city', $city);
// 		$this->db->like('students.dob', $year);
// 		return $this->db->get()->result_array();
// 	}

// 	function search_student($search_keyword, $user_id){
// 		$this->db->select('students.id, students.first_name, students.last_name, students.student_id, students.email, students.phone,students.dob,students.gender,students.license_number,students.img_url,students.created_at,clubs.club_title');

// 		$this->db->from('students');
// 	    $this->db->join("clubs","students.club_id = clubs.id","left");
// 	    $this->db->where('students.id !=' , $user_id );	
// 		$this->db->like('first_name', $search_keyword);
// 		$this->db->or_like('last_name', $search_keyword);
// 		return $this->db->get()->result_array();
// 	}

// 	function getall_students(){
// 		$this->db->select('students.id, clubs.club_title, students.cat_id , students.first_name, students.last_name, students.student_id, students.email, students.phone,students.dob,students.gender, students.city, students.year,students.license_number,students.img_url,students.password,students.user_type,students.status,students.device_type,students.device_id,students.fcm_token,students.membership_status,students.created_at');
// 		$this->db->from('students');
// 	    $this->db->join("clubs","students.club_id = clubs.id","left");		
// 		return $this->db->get()->result_array();
// 	}

// 	function comparisonApi($first_studentid,$second_studentid)
// 	{

// 		$firstStudentArray = array();
// 		$secondStudentArray = array();

// 		$get_subcategory= $this->db->get('sub_cats');
// 		$subcategoryData = $get_subcategory->result_array();
// 		foreach ($subcategoryData as $key => $subcat_value) {
// 		$subcategory_id = $subcat_value['id'];

// 		// Check subcategory in result table for first student...
// 	    $this->db->where('subcategory_id', $subcategory_id);
// 	    $this->db->where('student_id', $first_studentid);
// 		$query = $this->db->get('results');
// 		$check_subcategoryid = $query->result_array();

// 		if($check_subcategoryid){

// 			    $get_first_stu=$this->db->query("SELECT rs.*, stu.first_name, stu.last_name, sc.cat_title FROM results rs, students stu, sub_cats sc WHERE rs.student_id=$first_studentid and rs.subcategory_id =$subcategory_id and rs.student_id = stu.id and rs.subcategory_id = sc.id AND rs.type !=2  order by rs.result_time ASC limit 1");
// 			    $first_stu = $get_first_stu->result_array();

// 			    @$firstStudentArray[] = array('student_id' => $first_stu[0]['student_id'], 'result_time' => $first_stu[0]['result_time'], 'subcategory_id' => $first_stu[0]['subcategory_id'],'first_name' => $first_stu[0]['first_name'],'last_name' => $first_stu[0]['last_name'],'sucategory_name' => $first_stu[0]['cat_title']); 
// 			    $first_stu = '';	
// 			}

// 		// Check subcategory in result table for second student...
// 	    $this->db->where('subcategory_id', $subcategory_id);
// 	    $this->db->where('student_id', $second_studentid);
// 		$query = $this->db->get('results');
// 		$check_subcategoryidSecond = $query->result_array();

// 		if($check_subcategoryidSecond){

// 			    $get_second_stu=$this->db->query("SELECT * FROM results rs WHERE rs.student_id=$second_studentid and rs.subcategory_id =$subcategory_id AND rs.type !=2 order by rs.result_time ASC limit 1");
// 			    $second_stu = $get_second_stu->result_array();
// 			    $secondStudentArray[] = $second_stu[0]['subcategory_id']; 
// 			    $second_stu = '';			
// 			}

// 	}

// 		// Mearge both array first student detials and second student detials...
// 		$final_array = array();
// 		foreach ($firstStudentArray as $key => $fvalue) {

// 			// check subcategory if exist or not both student detials...
// 			 if(in_array($fvalue['subcategory_id'], $secondStudentArray)){

// 			 	$subCatId = $fvalue['subcategory_id'];

// 			    $get_second_stu1=$this->db->query("SELECT rs.*, stu.first_name, stu.last_name, sc.cat_title FROM results rs, students stu, sub_cats sc WHERE rs.student_id=$second_studentid and rs.subcategory_id =$subCatId and rs.student_id = stu.id and rs.subcategory_id = sc.id and rs.type !=2 order by rs.result_time ASC limit 1");
// 			    $second_stu1 = $get_second_stu1->result_array(); 	

// 			    $arrayOfVal  = array('first_student_name' => $fvalue['first_name'].' '.$fvalue['last_name'] ,  'first_student_time' => $fvalue['result_time'], 'subcategory_id' =>  $fvalue['sucategory_name'], 'second_student_name' => $second_stu1[0]['first_name'].' '.$second_stu1[0]['last_name'] ,  'second_student_time' => $second_stu1[0]['result_time'] );

// 			 	$final_array[] = $arrayOfVal;


// 			 	$arrayOfVal = '';
// 			 }
// 		}
// 		return $final_array;
// 	}


// 	public function getStudentOtherData($stuid){
// 		$get_second_stu=$this->db->query("SELECT * FROM results rs WHERE rs.student_id=$stuid order by rs.result_time ASC limit 1");
// 	    return $second_stu = $get_second_stu->row_array();
// 	}

// 	public function getStudentOtherData1($stuid){
// 		$qry = $this->db->query("SELECT cities.city_name, clubs.club_title FROM students stu, cities, clubs WHERE stu.club_id = clubs.id AND stu.city = cities.id AND stu.id = $stuid ");
// 	    return $qry->row_array();
// 	}

// 	public function getStudentfeild($stuid){
// 		$get_second_stu=$this->db->query("SELECT students.*, clubs.club_title , cities.city_name FROM students, clubs, cities WHERE students.id=$stuid and students.city = cities.id and students.club_id = clubs.id ");
// 	    return $get_second_stu->row_array();
// 	}

// 	public function getcatandsubcat($stuid){
// 		$get_second_stu=$this->db->query("SELECT results.*,categories.cat_title,sub_cats.cat_title as subcat_title FROM results,categories,sub_cats WHERE results.category_id = categories.id and results.subcategory_id = sub_cats.id and results.id = $stuid ");
// 	    return $get_second_stu->row_array();
// 	}


// 	public function getbestRankstudent($year,$category_id,$gender){

// 				$finalStudentData 		= array();

// 				/* Get Subcategory by Category id  */
// 				$this->db->where('cat_id', $category_id );
// 				$getSubcatQuery = $this->db->get('sub_cats');
// 				$getDataOfSubcategory  = $getSubcatQuery->result_array();				

// 				foreach ($getDataOfSubcategory as $key => $value) {
// 					$subcategory_id = $value['id'];

// 					for($i=1; $i<=3; $i++ ){
// 						/* Get Second Student Of Best Rank  */
// 						if($i==1){
// 							    $get_bestrankstudnet=$this->db->query("SELECT rs.*, stu.first_name, stu.last_name, sc.cat_title as subcategory FROM results rs, students stu, sub_cats sc WHERE subcategory_id = $subcategory_id AND category_id= $category_id and rs.student_id = stu.id and rs.subcategory_id = sc.id and stu.dob LIKE '%$year%' AND stu.gender = '$gender' and rs.type !=2  ORDER BY result_time ASC limit 1,1 ");
// 						}
// 						/* Get First Student Of Best Rank  */
// 						if($i==2){
// 							    $get_bestrankstudnet=$this->db->query("SELECT rs.*, stu.first_name, stu.last_name, sc.cat_title as subcategory FROM results rs, students stu, sub_cats sc WHERE subcategory_id = $subcategory_id AND category_id= $category_id and rs.student_id = stu.id and rs.subcategory_id = sc.id and stu.dob LIKE '%$year%' AND stu.gender = '$gender' and rs.type !=2  ORDER BY result_time ASC limit 0,1 ");
// 						}
// 						/* Get Third Student Of Best Rank  */
// 						if($i==3){
// 							    $get_bestrankstudnet=$this->db->query("SELECT rs.*, stu.first_name, stu.last_name, sc.cat_title as subcategory FROM results rs, students stu, sub_cats sc WHERE subcategory_id = $subcategory_id AND category_id= $category_id and rs.student_id = stu.id and rs.subcategory_id = sc.id and stu.dob LIKE '%$year%' AND stu.gender = '$gender' and rs.type !=2 ORDER BY result_time ASC limit 2,1 ");
// 						}

// 						$getData = $get_bestrankstudnet->result_array();
// 						foreach ($getData as $key => $value) {
// 						$finalStudentData[] = array('student_name'=>$value['first_name'].' '. $value['last_name'] ,'subcategory_name'=>$value['subcategory'],'result_time'=>$value['result_time'],'result_class'=>$value['result_class'],'rank'=>$value['rank']);
// 						}
// 				    }

// 				}

// 		return $finalStudentData;
// 	}

// 	//  query of get random 3 news data..
// 	public function getRandomnews(){
// 	    $this->db->order_by('rand()');
// 	    $this->db->limit(3);
// 	    $query = $this->db->get('news');
// 	    return $query->result_array();
// 	}


// // 	public function studentbestRank($studentid){

// // 			$student = array();
// // 			$getDataBySubcategory = array();
// // 			$getDataByYear = array();
// // 			$myFinalRankbyClub = array();

// // 			/*  Get city year and club ID in student table  */
// // 		    $this->db->where('id', $studentid );
// // 			$getYearQuery = $this->db->get('students');
// // 		    $getYearData  = $getYearQuery->row_array();

// // 		    $clubid = $getYearData['club_id'];
// // 		    $cityid = $getYearData['city'];
// // 		    $year = date('Y', strtotime($getYearData['dob']));

// // 			// get all sucategory.....
// // 			$get_subcategory= $this->db->get('sub_cats');
// // 			$subcategoryData = $get_subcategory->result_array();
// // 			foreach ($subcategoryData as $key => $subcat_value) {
// // 			$subcategory_id = $subcat_value['id'];

// // 			// check subcategory in result table....
// // 		    $this->db->where('subcategory_id', $subcategory_id);
// // 		    $this->db->where('student_id', $studentid);
// // 			$query = $this->db->get('results');
// // 			$check_subcategoryid = $query->result_array();

// // 			if($check_subcategoryid){

// // /* Get Students By City wise...............................................................................  */
// // 			    $getStudentid=$this->db->query("SELECT student_id FROM results WHERE city_id = $cityid GROUP BY student_id");
// // 			    $getDataStudentid = $getStudentid->result_array();

// // 				foreach ($getDataStudentid as $key => $stuID) {
// // 					$studId = $stuID['student_id'];

// // 					/* Get Result By every Student wise.  */
// // 					$getRankBySubcategory=$this->db->query("SELECT * FROM results WHERE subcategory_id = '$subcategory_id' AND student_id = '$studId' ORDER BY result_time ASC LIMIT 1 ");
// // 					if($getRankBySubcategory->result_array()){
// // 						$getRanksubcat = $getRankBySubcategory->row_array();
// // 						$getDataBySubcategory[] = array('resulttime' => $getRanksubcat['result_time'],  'student_id' => $getRanksubcat['student_id'] );
// // 					}else{
// // 						$myFinalRankbysubcat = 0;
// // 					}
// // 				}
				
// // 				sort($getDataBySubcategory);
// // 				/* which My Rank in subcategory  */
// // 				foreach ($getDataBySubcategory as $key => $value) {
// // 					if($value['student_id']==$studentid){
// // 						$myFinalRankbysubcat = $key+1;
// // 					}
// // 				}
// // 				// print_r($myFinalRankbysubcat); exit();
// // 				// $getDataBySubcategory = '';
// // /* End Students By City wise...............................................................................*/



// // /* Get Students By Year wise...............................................................................  */
// // 			    $getStudentidby_year=$this->db->query("SELECT id FROM students WHERE dob LIKE '%$year%' ");
// // 			    $getDataStudentidby_year = $getStudentidby_year->result_array();

// // 				foreach ($getDataStudentidby_year as $key => $stuID_year) {
// // 					$studId_year = $stuID_year['id'];

// // 					/* Get Result By every Student wise.  */
// // 					$getRankByYear=$this->db->query("SELECT * FROM results WHERE subcategory_id = '$subcategory_id' AND student_id = '$studId_year' ORDER BY result_time ASC LIMIT 1 ");
// // 					if($getRankByYear->result_array()){
// // 						$getRankyear = $getRankByYear->row_array();
// // 						$getDataByYear[] = array( 'resulttime' => $getRankyear['result_time'],  'student_id' => $getRankyear['student_id'] );
// // 					}else{
// // 						$myFinalRankbyYear = 0;
// // 					}
// // 				}

// // 				sort($getDataByYear);
				
// // 				foreach ($getDataByYear as $key_year => $valueYear) {
// // 					if($valueYear['student_id']==$studentid){
// // 						$myFinalRankbyYear = $key_year+1;
// // 					}
// // 				}
// // 				// $getDataByYear = '';

// // /* End Students By Year wise...............................................................................*/

// // /* Get Students By Club wise...............................................................................  */
// // 			    $getStudentidby_club=$this->db->query("SELECT id FROM students WHERE club_id = $clubid ");
// // 			    $getDataStudentidby_club = $getStudentidby_club->result_array();

// // 				foreach ($getDataStudentidby_club as $key => $stuID_club) {
// // 					$studId_club = $stuID_club['id'];

// // 					/* Get Result By every Student wise.  */
// // 					$getRankByClub=$this->db->query("SELECT * FROM results WHERE subcategory_id = '$subcategory_id' AND student_id = '$studId_club' ORDER BY result_time ASC LIMIT 1 ");
// // 					if($getRankByClub->result_array()){
// // 						$getRankclub = $getRankByClub->row_array();
// // 						$getDataByClub[] = array( 'resulttime' => $getRankclub['result_time'],  'student_id' => $getRankclub['student_id'] );
// // 					}else{
// // 						$myFinalRankbyClub = 0;
// // 					}
// // 				}

// // 				sort($getDataByClub);
				
// // 				foreach ($getDataByClub as $key_year => $valueClub) {
// // 					if($valueClub['student_id']==$studentid){
// // 						$myFinalRankbyClub = $key_year+1;
// // 					}
// // 				}
// // 				// $getDataByClub = '';
				
// // /* End Students By Club wise...............................................................................*/

  

// // 				// get best ranker students in all subcategory...... 
// // 			    $get_bestrankstudnet=$this->db->query("SELECT rs.*, stu.first_name, stu.last_name, sc.cat_title as subcategory, categories.cat_title as category_name FROM results rs, students stu, sub_cats sc, categories WHERE subcategory_id =$subcategory_id and rs.student_id = stu.id and rs.subcategory_id = sc.id AND rs.category_id = categories.id AND rs.student_id=$studentid ORDER BY result_time ASC limit 1 ");
// // 			    @$getData = $get_bestrankstudnet->result_array();

// // 			    @$student[] = array('category'=>$getData[0]['category_name'], 'subcategory'=>$getData[0]['subcategory'], 'club_rank' => $myFinalRankbyClub, 'city_rank' => $myFinalRankbysubcat,'year_rank' => $myFinalRankbyYear ,'result_time'=>$getData[0]['result_time'] );

// // 			    $getData = '';
// // 			    $myFinalRankbysubcat = '';
// // 			    $myFinalRankbyClub = '';
// // 			}
// // 		}

// // 		return $student;
// // 	}


// 	public function studentbestRank($studentid){

// 			$student = array();
// 			$getDataBySubcategory = array();
// 			$getDataByYear = array();
// 			$myFinalRankbyClub = array();

// 			/*  Get city year and club ID in student table  */
// 		    $this->db->where('id', $studentid );
// 			$getYearQuery = $this->db->get('students');
// 		    $getYearData  = $getYearQuery->row_array();

// 		    $clubid = $getYearData['club_id'];
// 		    $cityid = $getYearData['city'];
// 		    $year = date('Y', strtotime($getYearData['dob']));

// 			// get all sucategory.....
// 			$get_subcategory= $this->db->get('sub_cats');
// 			$subcategoryData = $get_subcategory->result_array();
// 			foreach ($subcategoryData as $key => $subcat_value) {
// 			$subcategory_id = $subcat_value['id'];

// 			// check subcategory in result table....
// 		    $this->db->where('subcategory_id', $subcategory_id);
// 		    $this->db->where('student_id', $studentid);
// 			$query = $this->db->get('results');
// 			$check_subcategoryid = $query->result_array();

// 			if($check_subcategoryid){

// /* Get Students By City wise...............................................................................  */
// 			    $getStudentid=$this->db->query("SELECT `student_id`, `type` , MIN(`result_time`) FROM `results` WHERE `city_id`=$cityid and type =1 and subcategory_id = '$subcategory_id' GROUP BY student_id having type = 1 ORDER BY MIN(`result_time`) ASC ");
// 			    $getDataStudentid = $getStudentid->result_array();

// 			    $myFinalRankbysubcat = array_search($studentid , array_column($getDataStudentid, 'student_id'))+1; 
// /* End Students By City wise...............................................................................*/

// /* Get Students By Year wise...............................................................................  */
// 			    $gegetstudentYear=$this->db->query("SELECT results.student_id, results.type , MIN(results.result_time) FROM results INNER JOIN students ON results.student_id = students.id WHERE subcategory_id = '$subcategory_id' and results.type =1 AND  students.dob LIKE '%2008%' GROUP BY results.student_id having results.type = 1 ORDER BY MIN(results.result_time) ASC ");
// 			    $getDataStudentyear = $gegetstudentYear->result_array();

// 			    $myFinalRankbyyearwise = array_search($studentid , array_column($getDataStudentyear, 'student_id'))+1; 
// /* End Students By Year wise...............................................................................*/

// /* Get Students By Club wise...............................................................................  */
// 			    $getStudentclub=$this->db->query("SELECT results.student_id, results.type , MIN(results.result_time) FROM results INNER JOIN students ON results.student_id = students.id WHERE students.club_id= $clubid  and results.type =1 and subcategory_id = '$subcategory_id' GROUP BY results.student_id having results.type = 1 ORDER BY MIN(results.result_time) ASC ");
// 			    $getDataStudentclubwise = $getStudentclub->result_array();

// 			    $myFinalRankbyclub = array_search($studentid , array_column($getDataStudentclubwise, 'student_id'))+1; 
// /* End Students By Club wise...............................................................................*/


// 			    $get_bestrankstudnet=$this->db->query("SELECT rs.result_time , sc.cat_title as subcategory, categories.cat_title as category_name FROM results rs, students stu, sub_cats sc, categories WHERE subcategory_id =$subcategory_id and rs.student_id = stu.id and rs.subcategory_id = sc.id AND rs.category_id = categories.id AND rs.student_id=$studentid ORDER BY result_time ASC limit 1 ");
// 			    @$getData = $get_bestrankstudnet->result_array();

// 			    @$student[] = array('category'=>$getData[0]['category_name'], 'subcategory'=>$getData[0]['subcategory'], 'club_rank' => $myFinalRankbyclub, 'city_rank' => $myFinalRankbysubcat,'year_rank' => $myFinalRankbyyearwise ,'result_time'=>$getData[0]['result_time']);

// 			}
// 		}

// 		return $student;
// 	}


// 	function studentPaymentdetials($studentid){

// 		$this->db->select('students.* , cities.city_name');
// 		$this->db->from('students');
// 		$this->db->join('cities', 'cities.id = students.city' , 'left');
// 		$this->db->where('students.id', $studentid);
// 		return $this->db->get()->row_array();
// 	}

// 	function geRandomString($length = 6) {
// 	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
// 	    $charactersLength = strlen($characters);
// 	    $randomString = '';
// 	    for ($i = 0; $i < $length; $i++) {
// 	        $randomString .= $characters[rand(0, $charactersLength - 1)];
// 	    }
// 	    return $randomString;
// 	}

  }