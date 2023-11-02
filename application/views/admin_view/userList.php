
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
            <div class="dt-entry__heading">
                <h3 class="dt-page__title">Users List</h3>
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
                                <th>Profile</th>
                                <th>User name</th>
                                <th>Email</th>
                                <th>Register Date</th>
                                <th>Status</th>
                                <th>Action</th>
                                <!-- <th>Post Status</th> -->
                                <th>View Post</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php 
                            if(!empty($userList))
                            {
                              $i=1;
                              foreach($userList as $listData)
                              {

                          ?>
                            <tr class="gradeX">
                                <td><?php echo $i; ?></td>
                                <td>
                                	<?php if(!empty($listData['profile_pic'])) { ?>
                                		<img src="<?php echo base_url('uploads/users_profile/'.$listData['profile_pic']); ?>" style="width: 100px;">
                                	<?php }else{ ?>
                                		<img src="<?php echo base_url('uploads/users_profile/thumbnail.png'); ?>" style="width: 100px;">
                                	<?php } ?>
                                </td>
                                <td><?php echo $listData['full_name']; ?></td>
                                <td><?php echo $listData['email']; ?></td>
                                <td><?php echo date('d M, Y', strtotime($listData['datetime'])); ?></td>
                              <?php 
                                if($listData['userstatusid'] == '1')
                                {
                              ?>
                                <td><span style="color: green;"> Active</span></td>
                                <td>
                                  <a onclick="return confirm('Are you sure ?');" href="<?php echo base_url('admin/change_user_status/'.base64_encode($listData['id'])); ?>" class="btn btn-danger btn-sm">Block</a>
                                </td>
                              <?php }else{ ?>
                                <td><span style="color: red;">Blocked</span></td>
                                <td>
                                  <a onclick="return confirm('Are you sure ?');" href="<?php echo base_url('admin/change_user_status/'.base64_encode($listData['id'])); ?>" class="btn btn-danger btn-sm">Unblock</a>
                                </td>
                              <?php } ?>
                              <td>
                              	<a href="<?php echo base_url('admin/userPost/'.base64_encode($listData['id'])); ?>" class="btn btn-primary btn-sm">View&nbsp;Post</a>
                              </td>
                              <!-- <?php 
                                if($listData['hide_post'] == '1')
                                {
                              ?>
                                <td><span style="color: green;"> Show</span></td>
                                <td>
                                  <a onclick="return confirm('Are you sure ?');" href="<?php echo base_url('admin/change_post_view_status/'.base64_encode($listData['id'])); ?>" class="btn btn-primary btn-sm">Hide</a>
                                </td>
                              <?php }else{ ?>
                                <td><span style="color: red;">Hide</span></td>
                                <td>
                                  <a onclick="return confirm('Are you sure ?');" href="<?php echo base_url('admin/change_post_view_status/'.base64_encode($listData['id'])); ?>" class="btn btn-primary btn-sm">Unhide</a>
                                </td>
                              <?php } ?> -->
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