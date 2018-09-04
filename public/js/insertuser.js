$(document).ready(function(){
		$("#save").click(function(e) {

		e.preventDefault();
		var password = $('#txtPassword').val();
		if(!$('#txtUsername').val() || !$('#txtNickname').val() || !$('#txtFullname').val() || password.length < 6 || $('#txtConfpassword').val() != $('#txtPassword').val() )
		{
			if(!$('#txtUsername').val())
				$('#msg_username').html("Thiếu thông tin tên đăng nhập của người dùng");
			else $('#msg_username').html("");

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
			getData.append('username', $('input[name=txtUsername]').val());
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
	
			$.ajax('/user/postinsert',{
				type:'POST',
				dataType:'JSON',
				contentType: false,
				processData: false,
				async:false,
				data:getData,
				success: function(result){
					if(result.success)
						window.location = '/user';
					if(result.errors)
						if(result.errors.username){
							$('#msg_username').html(result.errors.username);
							swal("Lỗi", "Vui lòng kiểm tra lại thông tin!", "error");
						}
						else $('#msg_username').html("");
				}
			});
		}
	});

	function delete_symbol(str) {
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        str = str.replace(/đ/g, "d");
        str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "a");
        str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "e");
        str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "i");
        str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "o");
        str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "u");
        str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "y");
        str = str.replace(/Đ/g, "d");
        str = str.replace(/[^0-9a-zàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ\s]/gi, '');
        str = str.replace(/ /g,'');
        str = str.toLowerCase()
        return str;
    }

    $('#txtFullname').on('change',function(){
        if(!$('#txtUsername').val()){
              let currentName = $('#txtFullname').val();
              let autoUsername = delete_symbol(currentName);
              $('#txtUsername').val(autoUsername);
              // swal("Username tự dộng:+" autoUsername+"_tnk");
              };

    });
});