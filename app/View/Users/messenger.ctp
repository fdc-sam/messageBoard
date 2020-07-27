
<?php
	echo $this->Html->css('myStyle');
	echo $this->Html->css('select2.min');
	echo $this->Html->script('select2.min', FALSE);
	echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css');

?>

<div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form  class="" id="addContact" >
			<div class="modal-content">
			 <div class="modal-header">
				 <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					 <span aria-hidden="true">&times;</span>
				 </button>
			 </div>
			 <div class="modal-body">
				 <input type="" name="userId" id="userId" value="<?php echo $current_user['id'] ?>">
				 <select name="id" id="mySelect2" style="width:100%"></select>
			 </div>
			 <div class="modal-footer">
				 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				 <button type="" class="btn btn-primary">Add To Contact</button>
			 </div>
		 </div>
		</form>
	</div>
</div>

<div class="container">
	<input type="text" name="" id="contactLoadLimit" value="">
	<input type="text" name="" id="firstLoad" value="1">
	<section class="" id="contacts">
		<h3 class=" text-center">Messaging</h3>
		<div class="alertHandler"></div>
		<div class="messaging">
	    <div class="inbox_msg">
	      <div class="inbox_people">
	        <div class="headind_srch">
	          <div class="recent_heading">
	            <h4 id="addContactModalBtn" >
								<!-- data-toggle="modal" data-target="#addContactModal" -->
								<i class="fa fa-address-book-o" aria-hidden="true"> Add Contact</i>
							</h4>
	          </div>
	          <div class="srch_bar">
	            <div class="stylish-input-group">
	              <input type="text" class="search-bar"  placeholder="Search" >
	              <span class="input-group-addon">
	              <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
	              </span> </div>
	          </div>
	        </div>
	        <div class="inbox_chat">


	        </div>
	      </div>
	      <div class="mesgs">
	        <div class="msg_history">
						<!-- friend message -->
	          <!-- <div class="incoming_msg">
	            <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
	            <div class="received_msg">
	              <div class="received_withd_msg">
	                <p>Test, which is a new approach to have</p>
	                <span class="time_date"> 11:01 AM    |    Yesterday</span></div>
	            </div>
	          </div> -->
						<!-- user message -->
	          <!-- <div class="outgoing_msg">
	            <div class="sent_msg">
	              <p>Apollo University, Delhi, India Test</p>
	              <span class="time_date"> 11:01 AM    |    Today</span> </div>
	          </div> -->
	        </div>
	        <div class="type_msg">
						<form class="" id="messageForm" name="messageForm">
								<div class="input_msg_write">
			            <input type="text" name= "content"  class="write_msg" placeholder="Type a message" />
									<input type="text" id="friendId"  name="friendId" value="" />
			            <button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
			          </div>
						</form>
	        </div>
	      </div>
	    </div>
			<p class="text-center top_spac"> Design by <a target="_blank" href="#">Sunil Rajput</a></p>
		</div>
	</section>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		var base_url = '<?php echo $this->webroot; ?>';
		var currentUserEmail = $('#currentUserEmail').val();
		var limit = 0;

		$(document).on('submit', '#messageForm', function(e){
			e.preventDefault();
			var friendId = $('#friendId').val();
			if (friendId != '') {
				$.ajax({
					url: base_url+'/messages/sendMessage',
					type: 'post',
					data: new FormData(this),
					contentType: false,
					processData: false,
					success: function(data){
						if (data == 'messageSend') {
							$('.write_msg').val('');
							getMessages(friendId);
						}else{

						}
					}
				});
			}

		});

		function getMessages(friendId = ''){
			$.ajax({
				url:base_url+'/messages/getMessages',
				type: 'post',
				data: {friendId:friendId},
				dataType: 'json',
				success: function(data){
					$('.msg_history').empty();
					$('.msg_history').append(data);
					$('#friendId').val(friendId);
				}
			});
		}


		$(document).on('click','#myProf',function(e){
			e.preventDefault();
			var userId2 = $('#userId2').val();
			window.location.replace(base_url+'users/view/'+userId2);
		});

		function getContacts(num = null){
			var contactLoadLimit = parseInt($('#contactLoadLimit').val());
			var firstLoad = parseInt($('#firstLoad').val());
			$.ajax({
				url: base_url+'friends/getContact/'+num,
				type: 'post',
				dataType:'json',
				data: {contactLoadLimit:contactLoadLimit, firstLoad:firstLoad},
				success: function(data){
					console.log(data);
					$('.inbox_chat').append(data);
				},
				error: function (jqXhr, textStatus, errorMessage) {
					$('.alertHandler').html(`<div class="alert alert-warning alert-dismissible fade show" role="alert">
							<strong>Holy guacamole!</strong> You should check in on some of those fields below.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>`);
				}
			});
		}
		getContacts(num = 0);
		//infinity scroll
		$('.inbox_chat').bind('scroll', function(){
		   if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
				 limit = parseInt(limit + 10);
				 getContacts(limit);
		   }
		});

		$(document).on('submit','#addContact', function(e){
			e.preventDefault();
			$.ajax({
				url:base_url+'friends/addContact',
		    type: 'POST',  // http method
		    data: new FormData(this),  // data to submit
				contentType: false,
				processData: false,
		    success: function (data) {
					$('.alertHandler').html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
						 <strong>Holy guacamole!</strong> You should check in on some of those fields below.
						 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							 <span aria-hidden="true">&times;</span>
						 </button>
					 </div>`);
					getContacts();
		    },
		    error: function (jqXhr, textStatus, errorMessage) {
		      $('.alertHandler').html(`<div class="alert alert-warning alert-dismissible fade show" role="alert">
						  <strong>Holy guacamole!</strong> You should check in on some of those fields below.
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						  </button>
						</div>`);
		    }
			});
		});

		$(document).on('click','#addContactModalBtn', function(){
			$('#addContactModal').modal('show');
		});

		$('#mySelect2').select2({
			dropdownParent: $('#myModal'),
			placeholder: "Select a State",
			allowClear: true
		});

		$("#mySelect2").select2({
			ajax: {
				url: base_url+'users/getData',
				type: "post",
				dataType: 'json',
				data: function (params) {
					return {
					  searchTerm: params.term // search term
					};
				},
				processResults: function (response) {
				 	return {
				    results: response
				 	};
				},
			}
		});

		// selected friend jQuery(this).attr('sid');
		$(document).on('click', '.chat_list', function(){
			var friendId = jQuery(this).attr('friendId');
			$.ajax({
				url:base_url+'/messages/getMessages',
				type: 'post',
				data: {friendId:friendId},
				dataType: 'json',
				success: function(data){
					$('.msg_history').empty();
					$('.msg_history').append(data);
					$('#friendId').val(friendId);
				}
			});
		});

	});
</script>
