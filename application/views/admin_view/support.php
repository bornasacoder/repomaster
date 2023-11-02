
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
                <h3 class="dt-page__title">Support Request</h3>
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
                                <th>Ticket ID</th>
                                <th>User name</th>
                                <th>Subject</th>
                                <th>Start Date</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Message</th>
                                <!-- <th>View Post</th> -->
                            </tr>
                        </thead>
                        <tbody>
                          <?php 
                            if(!empty($support))
                            {
                              $i=1;
                              foreach($support as $listData)
                              {

                          ?>
                            <tr class="gradeX">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $listData['ticket_id']; ?></td>
                                <td><?php echo $listData['full_name']; ?></td>
                                <td><?php echo $listData['subject']; ?></td>
                                <td><?php echo date('d M, Y', strtotime($listData['start_date'])); ?></td>
                              
                              <?php if($listData['status'] == '1' || $listData['status'] == '0')
                                {
                              ?>
                                <td><span style="color: lightblue;">Under Process</span></td>
                                <td>
                                  <a onclick="return confirm('Are you sure completed this request?');" href="<?php echo base_url('admin/support_completed/'.base64_encode($listData['id'])); ?>" class="btn btn-success btn-sm">Complete</a>
                                </td>
                               <td>
                                <a href="<?php echo base_url('admin/support_message/'.base64_encode($listData['id'])); ?>" class="btn btn-primary btn-sm">Message</a>
                              </td>
                              <?php }else{ ?>
                                <td><span style="color: green;">Completed</span></td>
                                <td>
                                  -
                                </td>
                                <td>
                                  -
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