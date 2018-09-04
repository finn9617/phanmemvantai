$(document).ready(function(){
	$.ajax('/user/getedit/'+getID,{
		type:'GET',
		data:{},
		dataType:'JSON',
		async:false,
		success:function(result)
		{
			var getOffice;
			if(result.success)
				if(result.success.user_type === 1)
					getOffice = "Admin";
				else if(result.success.user_type === 10)
					getOffice = "NVVP";
				else if(result.success.user_type === 11)
					getOffice = "Người liên lạc";
				else if(result.success.user_type === 12)
					getOffice = "Tài xế";
				else if(result.success.user_type === 13)
					getOffice = "Lơ xe";
				else if(result.success.user_type === 14)
					getOffice = "Chủ hàng";
				else if(result.success.user_type === 15)
					getOffice = "Người phụ trách";
				else if(result.success.user_type === 16)
					getOffice = "Điều phối 1";
				else if(result.success.user_type === 17)
					getOffice = "Điều phối 2";
				else if(result.success.user_type === 18)
					getOffice = "Văn phòng bãi xe";				

				$("#profile_office").append(getOffice);
				$("#profile_phone").append(result.success.phone);
				$("#profile_address").append(result.success.address);
				$("#profile_note").append(result.success.note);
				$("#txtUsername").val(result.success.user_name);
				$("#txtEmail").val(result.success.email);
				$("#txtGender").val(result.success.gender_id);
				$("#txtFullname").val(result.success.full_name);
				$("#txtNickname").val(result.success.nick_name);
				$("#txtOffice").val(result.success.user_type);
				$("#txtIdentity").val(result.success.identity_id);
				$("#txtAddress").val(result.success.address);
				$("#txtPhone").val(result.success.phone);
				$("#txtNote").val(result.success.note);
				$("#txtWorkStatus").val(result.success.work_status);
		}
	});

	$("#save").click(function(e) {

		e.preventDefault();
		var password = $('#txtPassword').val();
		if(!$('#txtNickname').val() || !$('#txtFullname').val() || password.length < 6 || $('#txtConfpassword').val() != $('#txtPassword').val() )
		{
			if(!$('#txtNickname').val())
				$('#msg_nickname').html("Thiếu thông tin tên thường gọi của người dùng");
			else $('#msg_nickname').html("");

			if(!$('#txtFullname').val())
				$('#msg_fullname').html("Thiếu thông tin họ tên của người dùng");
			else $('#msg_fullname').html("");

			if(password.length < 6)
				$('#msg_password').html("Mật khẩu cần 6 ký tự trở lên");
			else $('#msg_password').html("");

			if($('#txtConfpassword').val() != $('#txtPassword').val())
				$('#msg_confpassword').html("Xác nhận mật khẩu không trùng nhau");
			else $('#msg_confpassword').html("");

			swal("Lỗi", "Thiếu thông tin, vui lòng kiểm tra lại!", "error");			
		}
		else
		{
			var getData = new FormData();
			getData.append('_token', $('input[name=_token]').val());
			getData.append('id', getID);
			getData.append('email', $('input[name=txtEmail]').val());
			getData.append('password', $('input[name=txtPassword]').val());
			getData.append('confpassword', $('input[name=txtConfpassword]').val());
			getData.append('gender', $('#txtGender :selected').val());
			getData.append('fullname', $('input[name=txtFullname]').val());
			getData.append('nickname', $('input[name=txtNickname]').val());
			getData.append('office', $('#txtOffice :selected').val());
			getData.append('identity', $('input[name=txtIdentity]').val());
			getData.append('address', $('textarea#txtAddress').val());
			getData.append('phone', $('input[name=txtPhone]').val());
			getData.append('note', $('textarea#txtNote').val());
			getData.append('workstatus', $('#txtWorkStatus :selected').val());
	
			$.ajax('/user/postedit/'+getID,{
				type:'POST',
				dataType:'JSON',
				contentType: false,
				processData: false,
				async:false,
				data:getData,
				success: function(result){
					if(result.success)
						window.location = '/user';
				}
			});
		}
	});
});