<?php
ob_start();
	header('Access-Control-Allow-Origin: *');
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');
// $GLOBALS['url'] = 'https://freedomcells.net/freedomcell/';
// $GLOBALS['url'] = 'https://localhost/backend/';
$GLOBALS['url'] = 'https://api.victus.club/';





class Admin extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		if($_SERVER["HTTPS"] != "on")
			{
			    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
			    exit();
			}
	}
/////////////////////////////////////////////////////////////////////////////////////
	

	public function change_password()
	{
		$this->data['title'] = 'Change Password';
		$user_id = $this->session->userdata('admin_id');
		if(isset($_POST['update']))
		{
			if($this->input->post('new_password') == $this->input->post('confirm_password'))
			{
				$current_password = md5($this->input->post('current_password'));
				$user_info = $this->common_model->getSingleRecordById('users', array('id' => $user_id));
				if($current_password == $user_info['password'])
				{
					$data_arr = array(
		                'password' => md5($this->input->post('new_password'))
		              );
			    $response = $this->common_model->updateRecords('users', $data_arr, array('id' => $user_id));
					if($response)
					{
						$this->session->set_flashdata('success','Password changed successfully.');
					}
					else{
						$this->session->set_flashdata('error','Some internal issue occure. Please try again.');
					}
				}else{
					$this->session->set_flashdata('error','Current password dose not metch. Please enter correct password.');
				}
			}
			else{
				$this->session->set_flashdata('error','Confirm password dose not metch. Please enter correct password.');	
			}
			redirect('admin/change_password', 'refresh');
		}
		$this->render_template('admin_view/change_password', $this->data);
	}

	public function setting()
	{
		$data['title'] = 'Manage Setting ';
		$query = "SELECT * FROM setting limit 1";
		$data['setting_data'] = $setting_data = $this->common_model->getSingleArrayByQuery($query);

		if(isset($_POST['update']))
		{
			$id = $this->input->post('requestId');
			$post_data = array(
							'fcell_usd_price' => $this->input->post('fcell_usd_price'),
							'eth_public_key' => $this->input->post('eth_public_key'),
							'eth_private_key' => $this->input->post('eth_private_key'),
							'fcell_contract_address' => $this->input->post('fcell_contract_address'),
							'btc_private_key' => $this->input->post('btc_private_key'),
							'btc_public_key' => $this->input->post('btc_public_key'),
			);
			$this->common_model->updateRecords('setting', $post_data, array('id' => $id));
			$this->session->set_flashdata('success', 'Setting updated successfully.');
			redirect('admin/setting');
		}
		$this->render_template('admin_view/setting', $data);
	}

	public function project_status_update()
	{
		$project_id = base64_decode($this->uri->segment(3));
		$project_info = $this->common_model->getSingleRecordById('groups', array('id'=>$project_id));
		if($project_info)
		{
			if($project_info['is_blocked'] == '0')
			{
				$status = '1';
			}
			elseif($project_info['is_blocked'] == '1')
			{
				$status = '0';
			}
			else{
				$this->session->set_flashdata('error', 'Warning ! Something went wrong. Please try again.');
	 			redirect('admin/project_list');
			}
			$post_data = array(
					'is_blocked' => $status,
			);
			$this->common_model->updateRecords('groups', $post_data, array('id'=>$project_id));
			$this->session->set_flashdata('success', 'Success ! Project status updated succesfully.');
		}
		else{
			$this->session->set_flashdata('error', 'Warning ! Something went wrong. Please try again.');
		}
		redirect('admin/project_list');
	}


public function group_status_update()
	{
		$project_id = base64_decode($this->uri->segment(3));
		$project_info = $this->common_model->getSingleRecordById('groups', array('id'=>$project_id));
		if($project_info)
		{
			if($project_info['is_blocked'] == '0')
			{
				$status = '1';
			}
			elseif($project_info['is_blocked'] == '1')
			{
				$status = '0';
			}
			else{
				$this->session->set_flashdata('error', 'Warning ! Something went wrong. Please try again.');
	 			redirect('admin/group_list');
			}
			$post_data = array(
					'is_blocked' => $status,
			);
			$this->common_model->updateRecords('groups', $post_data, array('id'=>$project_id));
			$this->session->set_flashdata('success', 'Success ! Group status updated succesfully.');
		}
		else{
			$this->session->set_flashdata('error', 'Warning ! Something went wrong. Please try again.');
		}
		redirect('admin/group_list');
	}

	public function project_list()
	{
		$data['title'] = 'Project List ';
		$url = $GLOBALS['url'];
		$query = "SELECT 
          g.id,g.user_id,
          g.group_name,
          u.full_name,
          concat('".$url."uploads/group_avatar/',g.avatar) as vatar,
          g.description,
          case when g.is_closed_group=0 then 'Public' else 'Private' end as type,
          count(gm.id) as member_count,
          g.is_blocked,
          g.datetime
         FROM `groups` as g 
         left join users as u on u.id=g.user_id
         left join group_member as gm on gm.group_id=g.id 
         where g.isdeleted=0 and g.is_project=1
         group by g.id,g.user_id,g.group_name,g.avatar,g.description,g.is_closed_group";
		$data['project_list'] = $project_list = $this->common_model->getArrayByQuery($query);
		
		$this->render_template('admin_view/project_list', $data);
	}

	public function group_list()
	{
		$data['title'] = 'Group List ';
		$url = $GLOBALS['url'];
		$query = "SELECT 
          g.id,g.user_id,
          g.group_name,
          u.full_name,
          concat('".$url."uploads/group_avatar/',g.avatar) as vatar,
          g.description,
          case when g.is_closed_group=0 then 'Public' else 'Private' end as type,
          count(gm.id) as member_count,
          g.is_blocked,
          g.datetime
         FROM `groups` as g 
         left join users as u on u.id=g.user_id
         left join group_member as gm on gm.group_id=g.id 
         where g.isdeleted=0 and g.is_project=0
         group by g.id,g.user_id,g.group_name,g.avatar,g.description,g.is_closed_group";
		$data['project_list'] = $project_list = $this->common_model->getArrayByQuery($query);
		$this->render_template('admin_view/group_list', $data);
	}

	public function delete_nsfw()
	{
		$requestId = base64_decode($this->uri->segment(3));
	  if(!empty($requestId))
	  {
	  	$responce = $this->common_model->deleteRecords('nsfw_type', array('id' => $requestId));
	    $this->session->set_flashdata('success','Nsfw type deleted successfully.');
	  }
	  else{
	    $this->session->set_flashdata('error','Some internal issue occure. Please try again.');
	  }
	  redirect('admin/nsfw_manage');
	}

	public function get_nsfw_detail()
	{
		$id = $this->input->post('nsfw_id');
		$query = "SELECT * FROM nsfw_type WHERE id='$id'";
		$data = $this->common_model->getSingleArrayByQuery($query);
		echo '<div class="row">
							<input type="hidden" value="'.$id.'" name="requestId">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Type name</label>
                  <input type="text" value="'.$data['nsfw'].'" class="form-control" name="nsfw">
                </div>
              </div>
            </div>';
	}
	
	public function nsfw_manage()
	{
		$data['title'] = 'Manage NSFW ';
		$query = "SELECT * FROM nsfw_type ORDER BY id DESC";
		$data['data'] = $this->common_model->getArrayByQuery($query);
		if(isset($_POST['adddata']))
		{
			$post_data = array(
							'nsfw' => $this->input->post('nsfw')
			);
			$this->common_model->addRecords('nsfw_type', $post_data);
			$this->session->set_flashdata('success', 'Nsfw type added successfully.');
			redirect('admin/nsfw_manage');
		}
		if(isset($_POST['update']))
		{
			$id = $this->input->post('requestId');
			$post_data = array(
							'nsfw' => $this->input->post('nsfw')
			);
			$this->common_model->updateRecords('nsfw_type', $post_data, array('id' => $id));
			$this->session->set_flashdata('success', 'Nsfw type updated successfully.');
			redirect('admin/nsfw_manage');
		}
		$this->render_template('admin_view/nsfw_manage', $data);
	}

	public function get_transaction_detail()
	{
		$trx_id = $this->input->post('trx_id');
		$query = "SELECT transaction.*, users.full_name, trx_type.name as trx_type FROM transaction LEFT JOIN users ON users.id=transaction.user_id LEFT JOIN trx_type ON trx_type.id=transaction.trx_type_id WHERE transaction.id='$trx_id'";
		$transaction_detail = $this->common_model->getSingleArrayByQuery($query);
		echo '<div class="row">
              <div class="col-md-12">
                <table class="table table-bordered">
                  <tr>
                    <th>Transaction no.</th>
                    <td>'.$transaction_detail["trx_number"].'</td>
                  </tr>
                  <tr>
                    <th>User name</th>
                    <td>'.$transaction_detail["full_name"].'</td>
                  </tr>
                  <tr>
                    <th>Transaction type</th>
                    <td>'.$transaction_detail["trx_type"].'</td>
                  </tr>
                  <tr>
                    <th>From address</th>
                    <td>'.$transaction_detail["from_wallet"].'</td>
                  </tr>
                  <tr>
                    <th>To address</th>
                    <td>'.$transaction_detail["to_wallet"].'</td>
                  </tr>
                  <tr>
                    <th>Amount</th>
                    <td>'.$transaction_detail["trx_amount"].'</td>
                  </tr>
                  <tr>
                    <th>Hash</th>
                    <td>'.$transaction_detail["hash"].'</td>
                  </tr>
                  <tr>
                    <th>Description</th>
                    <td>'.$transaction_detail["description"].'</td>
                  </tr>
                  <tr>
                    <th>Transaction date</th>
                    <td>'.date("d M, Y", strtotime($transaction_detail['trx_date'])).'</td>
                  </tr>
                </table>
              </div>
            </div>';
	}

	public function transactions()
	{
		$data['title'] = 'Users Wallet';
		$query = "SELECT transaction.*, users.full_name, trx_type.name as trx_type FROM transaction LEFT JOIN users ON users.id=transaction.user_id LEFT JOIN trx_type ON trx_type.id=transaction.trx_type_id ORDER BY transaction.id DESC";
		$data['transaction_list'] = $this->common_model->getArrayByQuery($query);
		$this->render_template('admin_view/transactions', $data);
	}

	public function usersWallet()
	{
		$data['title'] = 'Users Wallet';
		$query = "SELECT users_wallet.*, users.full_name FROM users_wallet LEFT JOIN users ON users.id=users_wallet.user_id ORDER BY id DESC";
		$data['usersWallet'] = $this->common_model->getArrayByQuery($query);
		$this->render_template('admin_view/usersWallet', $data);
	}
	public function support()
	{
		$data['title'] = 'Support';
		$query = "SELECT support.*, users.full_name FROM support LEFT JOIN users ON users.id=support.user_id ORDER BY id DESC";
		$data['support'] = $this->common_model->getArrayByQuery($query);
		$this->render_template('admin_view/support', $data);

	}
	public function support_message()
	{
		
		$id = base64_decode($this->uri->segment(3));
		$data['title'] = 'Support-Message';		
		$query = "SELECT supportdetail.*, users.full_name FROM supportdetail  LEFT JOIN support ON support.id=supportdetail.supprot_id LEFT JOIN users ON users.id=support.user_id WHERE support.id=$id ORDER BY id ASC";
		$data['support'] = $this->common_model->getArrayByQuery($query);
		$this->render_template('admin_view/support_message', $data);

	}
	public function support_completed()
	{
		$id = base64_decode($this->uri->segment(3));
		$this->common_model->updateRecords('support',array('status'=>2),array('id'=>$id));
        $this->session->set_flashdata('success','The support request has been successfully completed.');
      	redirect('admin/support');

	}
	public function send_support_msg()
	{
		$supprot_id = $this->input->post('support_id');
		$arr = array(
			'supprot_id'=>$supprot_id,
			'description'=>$this->input->post('msg'),
			'send_by'=>1
		);
		$this->common_model->addRecords('supportdetail',$arr);
        $this->session->set_flashdata('success','Message sent successfully.');
      	redirect('admin/support_message/'.base64_encode($supprot_id));
	}
	public function logout()
	{
		session_destroy();
		redirect('admin');
	}

	public function profile()
	{
		$data['title'] = 'Profile';
		$admin_id = $this->session->userdata('admin_id');
    $data['login_user_info'] = $login_user_info = $this->common_model->getSingleRecordById('users', array('id'=>$admin_id));

		if(isset($_POST['update']))
		{
			$oldimage = $login_user_info['profile_pic'];
        if(!empty($_FILES['profile_pic']['name']))
          {
            $img_name = $_FILES['profile_pic']['name'];
            $tmp_name = $_FILES['profile_pic']['tmp_name'];
            $path = 'uploads/users_profile/';
            $image = time().$img_name;
            if($oldimage != "avatar.jpg")
            {
            	@unlink('uploads/users_profile/'.$oldimage);
            }
            move_uploaded_file($tmp_name,$path.$image);
          }
          else{
            $image = $oldimage;
          }
        $data_arr = array(
                  'full_name' => $this->input->post('full_name'),
                  'email' => $this->input->post('email'),
                  'mobile' => $this->input->post('mobile'),
                  'profile_pic' => $image,
                );
        $response = $this->common_model->updateRecords('users', $data_arr, array('id' => $admin_id));
          if($response)
          {
            $this->session->set_flashdata('success','Profile updated successfully.');
          }
          redirect('admin/profile');
		}

		$this->render_template('admin_view/profile', $data);
	}

	public function change_post_view_status()
	{
		$user_id = base64_decode($this->uri->segment(3));
		$user_info = $this->common_model->getSingleRecordById('users', array('id'=>$user_id));
		if($user_info)
		{
			if($user_info['hide_post'] == '1')
			{
				$status = '0';
			}
			elseif($user_info['hide_post'] == '0')
			{
				$status = '1';
			}
			else{
				$this->session->set_flashdata('error', 'Warning ! Something went wrong. Please try again.');
	 			redirect('admin/userList');
			}
			$post_data = array(
					'hide_post' => $status,
			);
			$this->common_model->updateRecords('users', $post_data, array('id'=>$user_id));
			$this->session->set_flashdata('success', 'Success ! User post status updated succesfully.');
		}
		else{
			$this->session->set_flashdata('error', 'Warning ! Something went wrong. Please try again.');
		}
		redirect('admin/userList');
	}


	public function change_user_status()
	{
		$user_id = base64_decode($this->uri->segment(3));
		$user_info = $this->common_model->getSingleRecordById('users', array('id'=>$user_id));
		if($user_info)
		{
			if($user_info['userstatusid'] == '1')
			{
				$status = 2;
			}
			elseif($user_info['userstatusid'] <> '1')
			{
				$status = 1;
			}
			else{
				$this->session->set_flashdata('error', 'Warning ! Something went wrong. Please try again.');
	 			redirect('admin/userList');
			}
			$post_data = array(
					'userstatusid' => $status,
			);
			$this->common_model->updateRecords('users', $post_data, array('id'=>$user_id));
			$this->session->set_flashdata('success', 'Success ! User status updated succesfully.');
		}
		else{
			$this->session->set_flashdata('error', 'Warning ! Something went wrong. Please try again.');
		}
		redirect('admin/userList');
	}

	public function delete_user_post()
	{
		$post_id = base64_decode($this->uri->segment(3));
		$post_info = $this->common_model->getSingleRecordById('post', array('id'=>$post_id));
		$post_data = array(
											'isdeleted'=>1,
		);
		$this->common_model->updateRecords('post', $post_data, array('id'=>$post_id));
		$this->session->set_flashdata('success', 'User post deleted successfully.');
		$user_id = base64_encode($post_info['user_id']);
		redirect('admin/userPost/'.$user_id);
	}

	public function userPost()
	{
		$data['title'] = 'User Post';
		$url = $GLOBALS['url'];
		// unset($_SESSION['post_user_id']);
		$user_id=base64_decode($this->uri->segment(3));
		$query="SELECT
		p.id as post_id,
		p.user_id,
		u.full_name,
		case when u.profile_pic is null then '".$url."uploads/users_profile/avatar.jpg' else concat('".$url."uploads/users_profile/',u.profile_pic) end as profile_pic,
              p.message,
              concat('".$url."uploads/',p.file) as file,
              p.file_type,
		p.isdeleted as isdeleted,
		get_duration(p.datetime) as duration,
		get_likes(p.id) as like_count,
		get_dislikes(p.id) as dislike_count,
		case when pl.id is null then 0 else 1 end as user_like,
		case when pd.id is null then 0 else 1 end as user_dislike,
		get_comments(p.id) as comments_count,
		case when f.id is null then 0 else 1 end as is_following
		FROM post as p
		left join users as u on u.id=p.user_id
		left join post_like as pl on pl.post_id=p.id and pl.user_id=$user_id
		left join post_dislike as pd on pd.post_id=p.id and pd.user_id=$user_id
		left join follow as f on f.following_id=p.user_id and f.follower_id=$user_id
		where p.user_id=$user_id 
		order by p.id desc";
		$data['userPost']= $this->common_model->getArrayByQuery($query);
		$this->render_template('admin_view/userPost', $data);
	}

	public function userList()
	{
		$data['title'] = 'Users';
		$data['userList'] = $this->common_model->getAllRecordsOrderById('users', 'id', 'DESC', array('user_type'=>'0'));
		$this->render_template('admin_view/userList', $data);
	}

	public function dashboard()
	{
		$data['title'] = 'Dashboard';
		$url = $GLOBALS['url'];

		$data['total_user'] = $this->common_model->getRecordCount('users', array('user_type'=>'0'));
		$data['total_post'] = $this->common_model->getTotalRecordCount('post');
		$data['total_support_req'] = $this->common_model->getTotalRecordCount('support');
		$data['total_like'] = $this->common_model->getTotalRecordCount('post_like');

		$q1 = "SELECT
		u.id as user_id,
		u.full_name,
		case when u.profile_pic is null then '".$url."uploads/users_profile/avatar.jpg' else concat('".$url."uploads/users_profile/',u.profile_pic) end as profile_pic,
		get_follower(u.id) as follower
		FROM users as u
		WHERE u.user_type=0
		order by u.id desc limit 20";
		$data['recent_user']= $u = $this->common_model->getArrayByQuery($q1);

		$query="SELECT
		p.id as post_id,
		p.user_id,
		u.full_name,
		case when u.profile_pic is null then '".$url."uploads/users_profile/avatar.jpg' else concat('".$url."uploads/users_profile/',u.profile_pic) end as profile_pic,
              p.message,
              concat('".$url."uploads/',p.file) as file,
              p.file_type,
		p.isdeleted as isdeleted,
		get_duration(p.datetime) as duration,
		get_likes(p.id) as like_count,
		get_dislikes(p.id) as dislike_count,
		case when pl.id is null then 0 else 1 end as user_like,
		case when pd.id is null then 0 else 1 end as user_dislike,
		get_comments(p.id) as comments_count,
		case when f.id is null then 0 else 1 end as is_following
		FROM post as p
		left join users as u on u.id=p.user_id
		left join post_like as pl on pl.post_id=p.id
		left join post_dislike as pd on pd.post_id=p.id
		left join follow as f on f.following_id=p.user_id
		order by p.id desc limit 20";
		$data['userPost']= $this->common_model->getArrayByQuery($query);

		$this->render_template('admin_view/dashboard', $data);
	}

	public function index()
	{
		if(isset($_POST['login_now']))
    {
      $login = $this->common_model->admin_login($this->input->post('email'), $this->input->post('password'));
      if($login)
      {
      	if($login['user_type'] == "1")
        {
	        $this->session->set_userdata('admin_id', $login['id']);
	        $this->session->set_userdata('user_type', $login['user_type']);
          redirect('admin/dashboard');
        }
        else
        {
          $this->session->set_flashdata('error','Incorrect username/password combination.');
          redirect('admin');
        }
      }
      else {
        $this->session->set_flashdata('error','Incorrect username/password combination.');
        redirect('admin');
      }
    }
		$this->load->view('admin_view/login');
	}

	public function render_template($page = null, $data = array())
	{
		$this->load->view('admin_view/header',$data);
		$this->load->view($page, $data);
		$this->load->view('admin_view/footer',$data);
	}

	public function test()
	{
		$this->load->view('admin_view/google_login');
	}
}
