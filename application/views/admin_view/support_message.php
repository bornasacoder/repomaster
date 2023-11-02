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
                <h3 class="dt-page__title">Support Details</h3>
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
<style type="text/css">
  .container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%; padding:
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 100%;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}
</style>
        

<h3 class=" text-center">Messaging</h3>
<div class="messaging">
      <div class="inbox_msg">
        <div class="mesgs">
          <div class="msg_history">
            <?php foreach ($support as $key => $v) {
              if($v['send_by']==0){?>
            <div class="incoming_msg">
              <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
              <div class="received_msg">
                <div class="received_withd_msg">
                  <p><?php echo $v['description']?></p>
                  <span class="time_date"><?php echo date_format(date_create($v['datetime']),'h:i A  |  M d')?></span></div>
              </div>
            </div>
          <?php }else{?>
            <div class="outgoing_msg">
              <div class="sent_msg">
                <p><?php echo $v['description']?></p>
                  <span class="time_date"><?php echo date_format(date_create($v['datetime']),'h:i A  |  M d')?></span></div>
            </div>
          <?php } }?>
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <form method="post" action="<?php echo base_url('admin/send_support_msg') ?>">
              <input type="text" name="msg" class="write_msg" placeholder="Type a message" />
              <input type="hidden" value="<?php echo base64_decode($this->uri->segment(3))?>" name="support_id">
              <button class="msg_send_btn" type="submit"><i class="icon icon-send" aria-hidden="true"></i></button>
              </form>
            </div>
          </div>
        </div>
      </div>
      
      
    </div>
                


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