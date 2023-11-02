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
            <h3 class="dt-page__title">Group List</h3>
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
                <th>Image</th>
                <th>Group Name</th>
                <th>User Name</th>
                <th>Member</th>
                <th>Create Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if(!empty($project_list))
              {
              $i=1;
              foreach($project_list as $listData)
              {
              ?>
              <tr class="gradeX">
                <td><?php echo $i; ?></td>
                <td><img src="<?php echo $listData['vatar']; ?>" alt="" width="100px" height="100px;"></td>
                <td><?php echo $listData['group_name']; ?></td>
                <td><?php echo $listData['full_name']; ?></td>
                <td><?php echo $listData['member_count']; ?></td>
                <td><?php echo date('d M, Y', strtotime($listData['datetime'])); ?></td>
                
                <?php if($listData['is_blocked'] == '1')
                {
                ?>
                <td><span style="color: red;">Blocked</span></td>
                <td>
                  <a title="Click to unblock" onclick="return confirm('Are you sure?');" href="<?php echo base_url('admin/group_status_update/'.base64_encode($listData['id'])); ?>" class="btn btn-success btn-sm">Unblock</a>
                </td>
                <?php }else{ ?>
                <td><span style="color: green;">Unblock</span></td>
                <td>
                   <a title="Click to block" onclick="return confirm('Are you sure?');" href="<?php echo base_url('admin/group_status_update/'.base64_encode($listData['id'])); ?>" class="btn btn-danger btn-sm">Block</a>
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
 $('#group_list').addClass('selected');
  $('#group_list a').addClass('active');
  });
  </script>