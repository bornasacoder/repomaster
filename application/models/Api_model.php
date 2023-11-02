<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model 
{
	function updatePostingLikeDislike($table, $data) {
		$where_condition = array('posting_id' => $data['posting_id'], 'user_id' => $data['user_id']);
		$post_data = array('like_type' => $data['like_type'], 'like_date' => $data['like_date']);

		$this->db->where($where_condition);
		$this->db->update($table, $post_data); 
		return TRUE;
	}
}