<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Redirect;

//use App\LibForm;

class AccountController extends Controller {
	//=================================== HƯỚNG DẪN VẼ FORM ==============================================

	//	Bước 1: Tạo bộ Rule cho form
	// Bước 2: gọi hàm drawForm($rule)

	/*
			Định dạng bộ rule:

				$ruleName[

					//-- vị trí $runName[0] lưu thông tin form như action, method, form name, id
					(object)
					[
						'type' => 'form',
						'name' =>'acountForm',
						'id'=>'acountForm',
						'action' => "/blank",
						'method'=>"post",
						'title'=>'Thêm mới account',
					]
					// -- các vị trí phía sau sẽ lưu thông tin các input trong form, mỗi input là 1 object có dạng tổng quát như sau

					(object)
					[
						// các thuộc tính chung bắt buộc phải có
						'type'		=> 'text',			--  text | number | date | textarea | checkbox | radio button |button
						'name'		=>'txtFirstName',	-- name
						'id'		=>'txtFirstName',	-- id
						'rowId'		=>1,				-- Vị trí hàng trong form
						'label'=>"First name:",			-- Title
						'width'=> 4,					-- Chiều rộng của input, tính theo bootstrap 1->12

						// Tiếp dưới là các thuộc tính riêng của từng loại input, xem ví dụ bên dưới để thấy rõ hơn, ví dụ dưới đây alf các thuộc tính của input dạng text

						'value'		=>"",				-- Value
						'readonly'	=>true,				-- Thuộc tính readonly - chỉ đọc
						'disabled'	=>false,			-- Khóa input
						'placeholder' => "first name"	-- placehoder gợi ý

					],

				]
		*/

	// =========================================== EXAMPLE 1: FULL INPUT TYPE =================================
	/*
			Hàm vẽ Form mẫu, sẽ bao gồm hầu hết các input
			-	Input text
			-	Input number
			-	Input date
			-	Select box
			-	Radio button
			-	Check box
			-	Text Area
	*/

	// 		public function FormCreat(){
	// 			require_once "LibForm.php";

	// 	/*
	// 		- Giả sử sử cần tạo 1 form để insert UserObject có dạng
	// 		- objUser gồm các thông tin:
	// 			+ Fist name (string)
	// 			+ Last name (string)
	// 			+ Email (string format Email)
	// 			+ Phone number (number)
	// 			+ Address (string)
	// 			+ Sex Male / Female (0/1)
	// 			+ Job (string)
	// 			+ Another infor
	// 		- Xây dựng luật cho các trường trên và gọi hàm creatFormAdd($luật)
	// 	*/
	// 		$ruleCreat  =
	// 		[
	// 		// Form infor
	// 			(object)
	// 			[
	// 				'type' => 'form',
	// 				'name' =>'acountForm',
	// 				'id'=>'acountForm',
	// 				'action' => "/blank",
	// 				'method'=>"post",
	// 				'title'=>'Thêm mới account',
	// 				'tibleName'=>'tbl_item'
	// 			],

	// 		//text input
	// 			(object)
	// 			[
	// 				'type'		=> 'text',
	// 				'name'		=>'txtFirstName',
	// 				'id'		=>'txtFirstName',
	// 				'rowId'		=>1,
	// 				'value'		=>"",
	// 				'readonly'	=>true,
	// 				'disabled'	=>false,
	// 				'placeholder' => "Enter first name",
	// 				'label'=>"First name:",
	// 				'width'=> 4
	// 			],
	// 			(object)
	// 			[
	// 				'type'		=> 'text',
	// 				'name'		=>'txtMidleName',
	// 				'id'		=>'txtMidleName',
	// 				'rowId'		=>1,
	// 				'value'		=>"",
	// 				'readonly'	=>false,
	// 				'disabled'	=>false,
	// 				'placeholder' => "Enter midle name name",
	// 				'label'=>"Midle  name:",
	// 				'width'=> 4
	// 			],
	// 		//text input
	// 			(object)
	// 			[
	// 				'type'		=> 'text',
	// 				'name'		=>'txtLastName',
	// 				'id'		=>'txtLastName',
	// 				'rowId'		=>1,
	// 				'value'		=>"",
	// 				'readonly'	=>false,
	// 				'disabled'	=>false,
	// 				'placeholder' => "Enter last name",
	// 				'label'=>"Last name:",
	// 				'width'=> 4
	// 			],

	// 		// input email
	// 			(object)
	// 			[
	// 				'type'		=> 'email',
	// 				'name'		=>'txtEmail',
	// 				'id'		=>'txtEmail',
	// 				'rowId'		=>2,
	// 				'value'		=>"",
	// 				'readonly'	=>false,
	// 				'disabled'	=>false,
	// 				'placeholder' => "Enter email",
	// 				'label'=>"Email:",
	// 				'width'=> 6
	// 			],

	// 		//input password
	// 			(object)
	// 			[
	// 				'type'		=> 'password',
	// 				'name'		=>'txtPassword',
	// 				'id'		=>'txtPassword',
	// 				'rowId'		=>2,
	// 				'value'		=>"",
	// 				'readonly'	=>false,
	// 				'disabled'	=>false,
	// 				'placeholder' => "Enter pass word",
	// 				'label'=>"Pass word:",
	// 				'width'=> 6
	// 			],

	// 		//input date
	// 			(object)
	// 			[
	// 				'type'		=> 'date',
	// 				'name'		=>'txtBirthDAte',
	// 				'id'		=>'txtBirthDAte',
	// 				'rowId'		=>3,
	// 				'value'		=>"",
	// 				'readonly'	=>false,
	// 				'disabled'	=>false,
	// 				'min'	=> '2000-01-01',
	// 				'max'=>'2020-31-12',
	// 				'placeholder' => "Enter birth date",
	// 				'label'=>"Birth date:",
	// 				'width'=> 6
	// 			],

	// 		//input number
	// 			(object)
	// 			[
	// 				'type'		=> 'number',
	// 				'name'		=>'txtBirthDAte',
	// 				'id'		=>'txtBirthDAte',
	// 				'rowId'		=>3,
	// 				'value'		=>"",
	// 				'readonly'	=>false,
	// 				'disabled'	=>false,
	// 				'min'	=> '1',
	// 				'max'=>'9999999999',
	// 				'placeholder' => "Enter phone number",
	// 				'label'=>"Phone number:",
	// 				'width'=> 6
	// 			],

	// 		//text area
	// 			(object)
	// 			[
	// 				'type' => 'textarea',
	// 				'name'=>'txtAddress',
	// 				'id'=>'txtAddress',
	// 				'rowId'		=>3,
	// 				'value'=>'',
	// 				'placeholder' => "Enter address",
	// 				'status'=>"readonly",
	// 				'rows'=>7,
	// 				'cols'=>10,
	// 				'label'=>"Address:",
	// 				'width'=> 12
	// 			],

	// 		//radio button
	// 			(object)
	// 			[
	// 				'type' => 'radio',
	// 				'name'=>'radSex',
	// 				'id'=>'radSex',
	// 				'rowId'		=>4,
	// 				'label'=>"Male/ Female:",
	// 				'width'=> 6,
	// 				'options' =>[
	// 					(object)[
	// 						'value'=>0,
	// 						'disabled'=>false,
	// 						'checked'=>true,
	// 						'text'=>'Male'
	// 					],
	// 					(object)[
	// 						'value'=>1,
	// 						'disabled'=>false,
	// 						'checked'=>false,
	// 						'text'=>'Female'

	// 					],
	// 					(object)[
	// 						'value'=>2,
	// 						'disabled'=>true,
	// 						'checked'=>false,
	// 						'text'=>'Unknow'

	// 					]
	// 				]
	// 			],

	// 		//check box group
	// 			(object)
	// 			[
	// 				'type' => 'checkbox',
	// 				'name'=>'checkboxGroup',
	// 				'id'=>'checkboxGroup',
	// 				'rowId'		=>4,
	// 				'label'=>"Another infor:",
	// 				'width'=> 6,
	// 				'options' =>[
	// 					(object)[
	// 						'name'=>'chkHandSome',
	// 						'id'=>'chkHandSome',
	// 						'value'=>0,
	// 						'disabled'=>false,
	// 						'checked'=>false,
	// 						'text'=>'Hand Some'
	// 					],
	// 					(object)[
	// 						'name'=>'chkRich',
	// 						'id'=>'chkRich',
	// 						'value'=>1,
	// 						'disabled'=>false,
	// 						'checked'=>true,
	// 						'text'=>'Rich'

	// 					],
	// 					(object)[
	// 						'name'=>'chkGay',
	// 						'id'=>'chkGay',
	// 						'value'=>1,
	// 						'disabled'=>true,
	// 						'checked'=>false,
	// 						'text'=>'Gay'

	// 					]
	// 				]
	// 			],

	// 		//select box
	// 			(object)
	// 			[
	// 				'type' => 'select',
	// 				'name'=>'selJob',
	// 				'id'=>'selJob',
	// 				'rowId'		=>5,
	// 				'disabled'=> false,
	// 				'width'=> 12,
	// 				'label'=>"Job:",
	// 				'options' =>[
	// 					(object)[
	// 						'value'=>0,
	// 						'disabled'=>false,
	// 						'selected'=>false,
	// 						'text'=>'Developer'
	// 					],
	// 					(object)[
	// 						'value'=>1,
	// 						'disabled'=>false,
	// 						'selected'=>true,
	// 						'text'=>'IT'

	// 					],
	// 					(object)[
	// 						'value'=>2,
	// 						'disabled'=>true,
	// 						'selected'=>false,
	// 						'text'=>'Head room'

	// 					]
	// 				]
	// 			],

	// 		//BUTTON
	// 			(object)
	// 			[
	// 				'type' => 'button',
	// 				'name'=>'',
	// 				'id'=>'',
	// 				'rowId'		=>6,
	// 				'disabled'=> false,
	// 				'width'=> 12,
	// 				'label'=>"",
	// 				'buttons' =>[
	// 					(object)[
	// 						'name'=>'btnOK',
	// 						'id'=>'btnOK',
	// 						'disabled'=>false,
	// 					'type' => "submit", // button | submit
	// 					'style' => "success", // success | danger| infor | warning
	// 					'size' => "md", // lg | md | sm | xs
	// 					'block' =>false,
	// 					'text'=>'OK'
	// 				],
	// 				(object)[
	// 					'name'=>'btnCancel',
	// 					'id'=>'btnCancel',
	// 					'disabled'=>false,
	// 					'type' => "submit", // button | submit
	// 					'style' => "danger", // success | danger| infor | warning
	// 					'size' => "md", // lg | md | sm | xs
	// 					'block' =>false,
	// 					'text'=>'Cancle'

	// 				]
	// 			]
	// 		],
	// 	];

	// 	// LibForm::countRow($ruleCreat);

	// 	$formCreat =   LibForm::drawForm($ruleCreat);

	// 	return view('form', compact('formCreat'));
	// }

	//======================================== EXAMPLE 2: SHOW ITEM DETAIL USING DATABASE ===============================
	public function itemDetail($item_id) {
		require_once "LibForm.php";
		// $partners = Partner::all();
		// $item_table = 'tbl_item';
		// $item = DB::table($item_table)->select('tbl_item.*')->where('tbl_item.item_id','=',$item_id)->get();
		// $items = Item::all();
		// echo "<pre>";
		// var_dump($item);
		// echo "</pre>";
		$ruleCreat =
			[
			// Form infor
			(object)
			[
				'type' => 'form',
				'name' => 'itemForm',
				'id' => 'acountForm',
				'action' => "/blank",
				'method' => "post",
				'title' => 'Thông tin sản phẩm',

				// nếu update thì cần có 2 trường này
				'tableName' => 'tbl_item',
				'filterColumn' => [
					'item_id' => $item_id,
				],

			],

			// select box partner
			(object)
			[
				'type' => 'select',
				'name' => 'selCustomer',
				'id' => 'selCustomer',
				'rowId' => 1,
				'disabled' => false,
				'width' => 6,
				'label' => "Công ty:",
				// 'options' =>$optionsPartner,

				'DB' => (object) [
					'partnerFilterColumn' => 'partner_id',
					'tableName' => 'tbl_partner',
					'option' => (object) [
						'value' => 'partner_id',
						'text' => 'partner_full_name',
					],
				],
			],

			// input item name
			(object)
			[
				'type' => 'text',
				'name' => 'txtItemName',
				'id' => 'txtItemName',
				'rowId' => 1,
				'filterColumn' => 'item_name',
				'readonly' => false,
				'disabled' => false,
				'placeholder' => "Enter last name",
				'label' => "Tên thiết bị:",
				'width' => 6,
			],
			//text area description
			(object)
			[
				'type' => 'textarea',
				'name' => 'txtDescription',
				'id' => 'txtDescription',
				'rowId' => 2,
				// 'value'=>($item[0]->description),
				'filterColumn' => 'description',
				'placeholder' => "Note",
				// 'status'=>"readonly",
				'readonly' => false,
				'rows' => 7,
				'cols' => 10,
				'label' => "Ghi chú:",
				'width' => 12,
			],
			//input number price
			(object)
			[
				'type' => 'number',
				'name' => 'txtPrice',
				'id' => 'txtPrice',
				'rowId' => 3,
				// 'value'		=>$item[0]->price,
				'filterColumn' => 'price',
				'readonly' => false,
				'disabled' => false,
				'min' => '1',
				'max' => '9999999999',
				'placeholder' => "Enter phone number",
				'label' => "Giá:",
				'width' => 6,
			],

			//input date
			(object)
			[
				'type' => 'date',
				'name' => 'txtWarrantyDate',
				'id' => 'txtWarrantyDate',
				'rowId' => 3,
				// 'value'		=>$warranty_date,
				'filterColumn' => 'warranty_date',
				'readonly' => false,
				'disabled' => false,
				'min' => '2000-01-01',
				'max' => '2020-31-12',
				'placeholder' => "Enter birth date",
				'label' => "Hạn bảo hành:",
				'width' => 6,
			],
			// select box sub item1
			(object)
			[
				'type' => 'select',
				'name' => 'selSubItem1',
				'id' => 'selSubItem1',
				'rowId' => 4,
				'disabled' => false,
				'width' => 4,
				'label' => "Thiết bị con:",

				'DB' => (object) [
					'partnerFilterColumn' => 'sub_item_id_1',
					'tableName' => 'tbl_sub_item',
					'option' => (object) [
						'value' => 'sub_item_id',
						'text' => 'sub_item_name',
					],
				],

			],
			//input number price sub item 1
			(object)
			[
				'type' => 'number',
				'name' => 'txtPriceSubItem1',
				'id' => 'txtPriceSubItem1',
				'rowId' => 4,
				// 'value'		=>$item[0]->sub_item_price_1,
				'filterColumn' => 'sub_item_price_1',
				'readonly' => false,
				'disabled' => false,
				'min' => '1',
				'max' => '9999999999',
				'placeholder' => "Enter phone number",
				'label' => "Giá:",
				'width' => 4,
			],

			//in put date txtWarrantyDate sub item 1
			(object)
			[
				'type' => 'date',
				'name' => 'txtWarrantyDate',
				'id' => 'txtWarrantyDate',
				'rowId' => 4,
				// 'value'		=>$warranty_date_1,
				'filterColumn' => 'warranty_date_1',
				'readonly' => false,
				'disabled' => false,
				'min' => '2000-01-01',
				'max' => '2020-31-12',
				'placeholder' => "Enter birth date",
				'label' => "Hạn bảo hành:",
				'width' => 4,
			],
			//BUTTON
			(object)
			[
				'type' => 'button',
				'name' => '',
				'id' => '',
				'rowId' => 6,
				'disabled' => false,
				'width' => 12,
				'label' => "",
				'buttons' => [
					(object) [
						'name' => 'btnOk',
						'id' => 'btnOk',
						'disabled' => false,
						'type' => "submit", // button | submit
						'style' => "success", // success | danger| infor | warning
						'size' => "md", // lg | md | sm | xs
						'block' => false,
						'text' => 'OK',
					],
					(object) [
						'name' => 'btnCancel',
						'id' => 'btnCancel',
						'disabled' => false,
						'type' => "submit", // button | submit
						'style' => "danger", // success | danger| infor | warning
						'size' => "md", // lg | md | sm | xs
						'block' => false,
						'text' => 'Cancle',

					],
				],
			],
		];
		$formCreat = LibForm::drawForm($ruleCreat);
		return view('form', compact('formCreat'));
	}

	//================================== EXAMPLE 3: CREATE ITEM ===========================================

	public function createItem() {
		require_once "LibForm.php";
		$ruleCreat =
			[
			// Form infor
			(object)
			[
				'type' => 'form',
				'name' => 'itemForm',
				'id' => 'acountForm',
				'action' => "/blank",
				'method' => "post",
				'title' => 'Thông tin sản phẩm',

			],

			// select box partner
			(object)
			[
				'type' => 'select',
				'name' => 'selCustomer',
				'id' => 'selCustomer',
				'rowId' => 1,
				'disabled' => false,
				'width' => 6,
				'label' => "Công ty:",
				'DB' => (object) [
					// 'partnerFilterColumn'=>'partner_id',
					'tableName' => 'tbl_partner',
					'option' => (object) [
						'value' => 'partner_id',
						'text' => 'partner_full_name',
					],
				],
			],

			// input item name
			(object)
			[
				'type' => 'text',
				'name' => 'txtItemName',
				'id' => 'txtItemName',
				'rowId' => 1,
				'filterColumn' => 'item_name',
				'readonly' => false,
				'disabled' => false,
				'placeholder' => "Enter last name",
				'label' => "Tên thiết bị:",
				'width' => 6,
			],
			//text area description
			(object)
			[
				'type' => 'textarea',
				'name' => 'txtDescription',
				'id' => 'txtDescription',
				'rowId' => 2,
				// 'filterColumn'=>'description',
				'placeholder' => "Note",
				'readonly' => false,
				'rows' => 7,
				'cols' => 10,
				'label' => "Ghi chú:",
				'width' => 12,
			],
			//input number price
			(object)
			[
				'type' => 'number',
				'name' => 'txtPrice',
				'id' => 'txtPrice',
				'rowId' => 3,
				// 'filterColumn'=>'price',
				'readonly' => false,
				'disabled' => false,
				'min' => '1',
				'max' => '9999999999',
				'placeholder' => "Enter phone number",
				'label' => "Giá:",
				'width' => 6,
			],

			//input date
			(object)
			[
				'type' => 'date',
				'name' => 'txtWarrantyDate',
				'id' => 'txtWarrantyDate',
				'rowId' => 3,
				// 'filterColumn'=>'warranty_date',
				'readonly' => false,
				'disabled' => false,
				'min' => '2000-01-01',
				'max' => '2020-31-12',
				'placeholder' => "Enter birth date",
				'label' => "Hạn bảo hành:",
				'width' => 6,
			],
			// select box sub item1
			(object)
			[
				'type' => 'select',
				'name' => 'selSubItem1',
				'id' => 'selSubItem1',
				'rowId' => 4,
				'disabled' => false,
				'width' => 4,
				'label' => "Thiết bị con:",

				'DB' => (object) [
					// 'partnerFilterColumn'=>'sub_item_id_1',
					'tableName' => 'tbl_sub_item',
					'option' => (object) [
						'value' => 'sub_item_id',
						'text' => 'sub_item_name',
					],
				],

			],
			//input number price sub item 1
			(object)
			[
				'type' => 'number',
				'name' => 'txtPriceSubItem1',
				'id' => 'txtPriceSubItem1',
				'rowId' => 4,
				// 'filterColumn'=>'sub_item_price_1',
				'readonly' => false,
				'disabled' => false,
				'min' => '1',
				'max' => '9999999999',
				'placeholder' => "Enter phone number",
				'label' => "Giá:",
				'width' => 4,
			],

			//in put date txtWarrantyDate sub item 1
			(object)
			[
				'type' => 'date',
				'name' => 'txtWarrantyDate',
				'id' => 'txtWarrantyDate',
				'rowId' => 4,
				// 'filterColumn'=>'warranty_date_1',
				'readonly' => false,
				'disabled' => false,
				'min' => '2000-01-01',
				'max' => '2020-31-12',
				'placeholder' => "Enter birth date",
				'label' => "Hạn bảo hành:",
				'width' => 4,
			],
			//BUTTON
			(object)
			[
				'type' => 'button',
				'name' => '',
				'id' => '',
				'rowId' => 6,
				'disabled' => false,
				'width' => 12,
				'label' => "",
				'buttons' => [
					(object) [
						'name' => 'btnOk',
						'id' => 'btnOk',
						'disabled' => false,
						'type' => "submit", // button | submit
						'style' => "success", // success | danger| infor | warning
						'size' => "md", // lg | md | sm | xs
						'block' => false,
						'text' => 'OK',
					],
					(object) [
						'name' => 'btnCancel',
						'id' => 'btnCancel',
						'disabled' => false,
						'type' => "submit", // button | submit
						'style' => "danger", // success | danger| infor | warning
						'size' => "md", // lg | md | sm | xs
						'block' => false,
						'text' => 'Cancle',

					],
				],
			],
		];
		$formCreat = LibForm::drawForm($ruleCreat);
		return view('form', compact('formCreat'));
	}

//=========================================== EXXAMPLE 4: SHOW USER INFOR ========================================
	public function userDetail($user_id) {
		require_once "LibForm.php";
		$ruleCreat =
			[
			// Form infor
			(object)
			[
				'type' => 'form',
				'name' => 'itemForm',
				'id' => 'acountForm',
				'action' => "/blank",
				'method' => "post",
				'title' => 'Thông tin người dùng',

				// nếu update thì cần có 2 trường này
				'tableName' => 'tbl_user',
				'filterColumn' => [
					'user_id' => $user_id,
				],
			],

			// input user name
			(object)
			[
				'type' => 'text',
				'name' => 'txtFirstName',
				'id' => 'txtFirstName',
				'rowId' => 1,
				'filterColumn' => 'first_name',
				'readonly' => false,
				'disabled' => false,
				'placeholder' => "Enter first name",
				'label' => "First name:",
				'width' => 6,
			],
			// input last name
			(object)
			[
				'type' => 'text',
				'name' => 'txtLastName',
				'id' => 'txtLastName',
				'rowId' => 1,
				'filterColumn' => 'last_name',
				'readonly' => false,
				'disabled' => false,
				'placeholder' => "Enter last name",
				'label' => "First name:",
				'width' => 6,
			],

			// select box partner
			(object)
			[
				'type' => 'select',
				'name' => 'selCustomer',
				'id' => 'selCustomer',
				'rowId' => 2,
				'disabled' => false,
				'width' => 6,
				'label' => "Công ty:",
				// 'options' =>$optionsPartner,

				'DB' => (object) [
					'partnerFilterColumn' => 'partner_id',
					'tableName' => 'tbl_partner',
					'option' => (object) [
						'value' => 'partner_id',
						'text' => 'partner_full_name',
					],
				],
			],
			//text area description
			(object)
			[
				'type' => 'textarea',
				'name' => 'txtAddress',
				'id' => 'txtAddress',
				'rowId' => 3,
				// 'value'=>($item[0]->description),
				'filterColumn' => 'address',
				'placeholder' => "Note",
				// 'status'=>"readonly",
				'readonly' => false,
				'rows' => 7,
				'cols' => 10,
				'label' => "Ghi chú:",
				'width' => 12,
			],
			// input number price
			(object)
			[
				'type' => 'number',
				'name' => 'txtPhoneNumber',
				'id' => 'txtPhoneNumber',
				'rowId' => 2,
				// 'value'		=>$item[0]->price,
				'filterColumn' => 'phone',
				'readonly' => false,
				'disabled' => false,
				'min' => '1',
				'max' => '9999999999',
				'placeholder' => "Enter phone number",
				'label' => "Giá:",
				'width' => 6,
			],

			//BUTTON
			(object)
			[
				'type' => 'button',
				'name' => '',
				'id' => '',
				'rowId' => 6,
				'disabled' => false,
				'width' => 12,
				'label' => "",
				'buttons' => [
					(object) [
						'name' => 'btnOk',
						'id' => 'btnOk',
						'disabled' => false,
						'type' => "submit", // button | submit
						'style' => "success", // success | danger| infor | warning
						'size' => "md", // lg | md | sm | xs
						'block' => false,
						'text' => 'OK',
					],
					(object) [
						'name' => 'btnCancel',
						'id' => 'btnCancel',
						'disabled' => false,
						'type' => "submit", // button | submit
						'style' => "danger", // success | danger| infor | warning
						'size' => "md", // lg | md | sm | xs
						'block' => false,
						'text' => 'Cancle',

					],
				],
			],
		];
		$formCreat = LibForm::drawForm($ruleCreat);
		return view('form', compact('formCreat'));
	}
	//=========================================== EXXAMPLE 5: SHOW USER TABLE ========================================
	public function getaccount() {
		require_once "LibForm.php";
		$rule = array(
			//URL TƯƠNG ỨNG VỚI QUY ĐỊNH {url} TRONG ROUTE
			'url' => 'user',
			//CHỌN CỘT DỮ LIỆU CẦN HIỂN THỊ, TÊN CỘT TRÙNG VỚI TÊN CỘT TRONG DB
			'column' =>
			[
				'email',
				'first_name',
				'last_name',
			],
			//INDEX CỦA MỖI CỘT TƯƠNG ỨNG
			'column_show' => [
				'Email',
				'First name',
				'Last name'],
			//CHỌN TABLE CẦN XỬ LÝ
			'tableName' => 'tbl_user',
			//TITLE HIỂN THỊ
			'title' => 'tài khoản',
			//SỐ DÒNG SỮ LIỆU HIỂN THỊ TRONG 1 TRANG
			'pag' => 5,
			//CHỌN FIELD CẦN TÌM KIẾM
			'searchfield' => 'first_name',
			//TÊN KHÓA CHÍNH CỦA BẢNG
			'idtable' => 'user_id',
		);
		//echo "<pre>";
		//print_r($rule['column']);exit();
		list($url, $columns, $column_show, $table, $table_all, $title, $total_column, $total_row, $row_all, $searchfield, $idtable) = LibForm::drawTableconfig($rule);
		//echo "<pre>";
		//print_r($table[0]->id);exit();
		return view('table', compact('url', 'columns', 'column_show', 'table', 'table_all', 'title', 'total_column', 'total_row', 'row_all', 'searchfield', 'idtable'));
	}
	//=========================================== EXXAMPLE 6: SEARCH USER ========================================
	public function searchaccount(Request $req) {
		require_once "LibForm.php";
		//BỘ RULE ĐƯỢC QUY ĐỊNH TƯỚNG ỨNG FUNC HIỂN THỊ
		$rule = array(
			//URL TƯƠNG ỨNG VỚI QUY ĐỊNH {url} TRONG ROUTE
			'url' => 'user',
			//CHỌN CỘT DỮ LIỆU CẦN HIỂN THỊ, TÊN CỘT TRÙNG VỚI TÊN CỘT TRONG DB
			'column' =>
			[
				'Email',
				'First name',
				'Last name',
			],
			//INDEX CỦA MỖI CỘT TƯƠNG ỨNG
			'column_show' => [
				'email',
				'first_name',
				'last_name'],
			//CHỌN TABLE CẦN XỬ LÝ
			'tableName' => 'tbl_user',
			//TITLE HIỂN THỊ
			'title' => 'tài khoản',
			//SỐ DÒNG SỮ LIỆU HIỂN THỊ TRONG 1 TRANG
			'search' => $req->name,
			'pag' => 5,
			//CHỌN FIELD CẦN TÌM KIẾM
			'searchfield' => 'first_name',
			//TÊN KHÓA CHÍNH CỦA BẢNG
			'idtable' => 'user_id',
		);
		list($url, $columns, $column_show, $table, $table_all, $title, $total_column, $total_row, $row_all, $searchfield, $idtable) = LibForm::searchTableconfig($rule);

		return view('table', compact('url', 'columns', 'column_show', 'table', 'table_all', 'title', 'total_column', 'total_row', 'row_all', 'searchfield', 'idtable'));
	}
	//=========================================== EXXAMPLE 7: DELETE USER ========================================
	public function delaccount($id) {
		require_once "LibForm.php";
		//TÊN TABLE
		$tableName = 'tbl_user';
		//TÊN KHÓA CHÍNH CỦA TABLE
		$idtable = 'user_id';
		LibForm::delete($tableName, $idtable, $id);
		return redirect()->back();
	}

}