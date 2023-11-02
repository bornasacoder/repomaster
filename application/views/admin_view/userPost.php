<!-- Site Content Wrapper -->
<div class="dt-content-wrapper">
  <!-- Site Content -->
  <div class="dt-content">
    <!-- Page Header -->
    <!-- Grid -->
    <div class="row">
      <!-- Grid Item -->
      <div class="col-xl-12">
        <!-- Entry Header -->
        <div class="dt-entry__header">
          <!-- Entry Heading -->
        <?php 
          $user_info = $this->common_model->getSingleRecordById('users', array('id'=>base64_decode($this->uri->segment(3))));
        ?>
          <div class="dt-entry__heading">
            <h3 class="dt-page__title">User Post ( <?php echo $user_info['full_name']; ?> ) </h3>
          </div>
          <!-- /entry heading -->
        </div>
        <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php elseif($this->session->flashdata('error')): ?>
        <div class="alert alert-error alert-dismissible" role="alert">
          <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php endif; ?>
        <!-- /entry header -->
        <!-- Tables -->
        <div class="table-responsive">
          <table id="data-table" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>Sno.</th>
                <th>Image / Vedio</th>
                <th>Message</th>
                <th>Duration</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if(!empty($userPost))
              {
              $i=1;
              foreach($userPost as $listData)
              {
              ?>
              <tr class="gradeX">
                <td><?php echo $i; ?></td>
                <?php 
                  if(!empty($listData['file'])) 
                  {
                    if($listData['file_type'] == "image")
                    { 
                ?>
                <td>
                  <img src="<?php echo $listData['file']; ?>" width="300" height="200">
                </td>
              <?php }else{ ?>
                <td>
                  <!-- <embed type="video/webm" src="<?php echo $listData['file']; ?>" width="300" height="200" autoplay="false" autostart="false"> -->
                    <video width="300" height="200" controls autoplay="false">
                      <source src="<?php echo $listData['file']; ?>" type="video/mp4"> Your browser does not support the video tag.
                      </video>
                  </td>
              <?php } }else{ ?>
                  <td>
                    
                  </td>
              <?php } ?>
                <td><?php echo $listData['message']; ?></td>
                <td><?php echo $listData['duration']; ?></td>
                <?php
                if($listData['isdeleted'] == '0')
                {
                ?>
                <td>
                  <a onclick="return confirm('Are you sure ?');" href="<?php echo base_url('admin/delete_user_post/'.base64_encode($listData['post_id'])); ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
                <?php }else{ ?>
                <td>
                  <a href="javascript:void(0);">Deleted</a>
                </td>
                <?php } ?>
              </tr>
              <?php $i++; } } ?>
              
            </tbody>
          </table>
        </div>
        <!-- /tables -->
      </div>
      <!-- /grid item -->
    </div>
    <!-- /grid -->
  </div>
  <script type="text/javascript">
  $(document).ready(function(){
  $('#userList').addClass('selected');
  $('#userList a').addClass('active');
  });
  </script>