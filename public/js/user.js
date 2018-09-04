function drawTable(getUser){
	var rowData = '';
	{
		$('.rowUser').remove();
		$('tbodyUser').html('');
		for(let i = 0; i < getUser.length; i++){
			let userName = "";
			if(getUser[i]['user_name'])
				userName = getUser[i]['user_name'];
			let fullName = "";
			if(getUser[i]['full_name'])
				fullName = getUser[i]['full_name'];
			let nickName = "";
			if(getUser[i]['nick_name'])
				nickName = getUser[i]['nick_name'];
			let numberPhone = "";
			if(getUser[i]['phone'])
				numberPhone = getUser[i]['phone'];
			let getNote = "";
			if(getUser[i]['note'])
				getNote = getUser[i]['note'];
		let getStt = i+1;
		let getRole = ""; 
		if (getUser[i]['user_type'] === 1) getRole = "Admin"; 
		if (getUser[i]['user_type'] === 10) getRole = "NVVP"; 
		if (getUser[i]['user_type'] === 11) getRole = "Người liên lạc"; 
		if (getUser[i]['user_type'] === 12) getRole = "Tài xế"; 
		if (getUser[i]['user_type'] === 13) getRole = "Lơ xe"; 
		if (getUser[i]['user_type'] === 14) getRole = "Chủ hàng"; 
		if (getUser[i]['user_type'] === 15) getRole = "Người phụ trách";
		if (getUser[i]['user_type'] === 16) getRole = "Điều phối 1";
		if (getUser[i]['user_type'] === 17) getRole = "Điều phối 2";
		if (getUser[i]['user_type'] === 18) getRole = "Văn phòng bãi xe"; 
 		rowData += '<tr role = "row" class = "odd rowUser" id = "row_' + getUser[i]['user_id'] + '">';
		rowData += '<td>' + getStt + '</td>';
		rowData += '<td>' + userName + '</td>';
		rowData += '<td>' + fullName + '</td>';
		rowData += '<td>' + nickName + '</td>';
		rowData += '<td>' + numberPhone + '</td>';
		rowData += '<td>' + getRole + '</td>';
		rowData += '<td>' + getNote + '</td>';
		rowData += '<td style="width: 80px"><a class="edit" title="Sửa" href="/user/edit/'+getUser[i]['user_id']+'"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;<a class="delete" href="#" data-id = "'+ getUser[i]['user_id'] +'" title="Xóa"><i class="glyphicon glyphicon-trash"></i></a></td>';		
		rowData += '</tr>';
		}
	$('#tbodyUser').append(rowData);
	}
}
var resData;
$(document).ready(function(){
	$.ajax('/user/getUser',{
		type:'GET',
		data: {},
		dataType: 'JSON',
		async: false,
		success: function (data){
			if(data.success){
				resData = data.success['getUser'];
			}else{
				swal("Lỗi", "Không tìm thấy thông tin người dùng!", "error");
			}
		}
	});

	var getUser = resData;
	drawTable(getUser);

	$("#btnSearch").click(function(e){
		e.preventDefault();
		if(!$('#txtOffice').val() && !$('#txtFullname').val() && !$('#txtUsername').val()){
    		location.reload();
		}
  		else{
  			var getInfo = {};
  			$.each($('form').serializeArray(),function(){
      			getInfo[this.name] = this.value;
    		});
  			$.ajax("/user/search",{
  				type:"GET",
  				data: getInfo,
  				dataType: "JSON",
  				async: true,
  				success:function(result){
  					if(result.success)
  					{
  						var userSearch = result.success['userSearch'];
  						drawTable(userSearch);
  					}
  				}
  			});
  			$('#tblUser_paginate').hide();
		}
	});

	$(document).on("click",".delete",function(){
		let deleteID = this.getAttribute("data-id");
		if(deleteID){
			swal({
				title: "Xóa thông tin người dùng ?",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if(willDelete) {
					$.ajax('/user/delete/'+deleteID,{
						type: 'GET',
						data: {},
						dataType: 'JSON',
						async: false,
						success: function(result){
							if(result.success)
							{
								swal("Xóa thành công!",{
								icon: "success",
								}).then(location.reload());
							}
						}
					});
				}
			});
		}
	});

	$("#btnReload").click(function(e){
		e.preventDefault();
		location.reload();
	});
	
	$("#btnCreate").click(function(){
		window.location = '/user/insert';
	})

	var oTable;
  	$(function () {
   	oTable=$('#tblUser').DataTable({
    	'paging'      : true,
    	'lengthChange': true,
    	'searching'   : false,
    	'ordering'    : true,
    	'info'        : false,
    	'autoWidth'   : false,
    	"bStateSave"  : true,
      	// recordsFiltered :20
    	});
 	});
});

