<?php

namespace App\Http\Controllers;
use DateTime;
use Illuminate\Support\Facades\DB;

class LibForm {
	public static function drawForm($rules) {
		// ============================================ GET ARRAY ROW - START =====================================

		$arrRow = [];
		foreach ($rules as $key => $element) {
			if (isset($element->rowId) && trim($element->rowId) !== '' && filter_var($element->rowId, FILTER_VALIDATE_INT)) {
				if (count($arrRow) > 0) {
					$flagExist = false;
					for ($i = 0; $i < count($arrRow); $i++) {
						if ($element->rowId == $arrRow[$i]) {
							$flagExist = true;
							break;
						}
					}
					if ($flagExist == false) {
						array_push($arrRow, $element->rowId);
					}

				} else {
					array_push($arrRow, $element->rowId);
				}
			}
		}
		sort($arrRow);

		//============================================== GET ARRAY ROW - END====================================

		//============================================== DRAW FORM - START =============================================
		$formHTML = '';
		// ==Form infor - START
		$frmName = $rules[0]->name;
		$frmId = $rules[0]->id;
		$frmAction = $rules[0]->action;
		$data = null; // type creat thì data = null, Còn update hay search data != null
		if (!isset($rules[0]->method) || trim($rules[0]->method) === '') {
			return "Thiếu form method";
		} else {
			$frmMethod = $rules[0]->method;
		}

		// Get DATA If form type = edit or search
		if ((isset($rules[0]->tableName) && trim($rules[0]->tableName) !== '') && (isset($rules[0]->filterColumn))) {
			$tableName = $rules[0]->tableName;
			$columnNameQuery = null;
			$columnValueQuery = null;

			foreach ($rules[0]->filterColumn as $columnName => $columnValue) {
				// echo $key." ".$value;
				$columnNameQuery = $columnName;
				$columnValueQuery = $columnValue;
			}
			$data = DB::table($tableName)->select('*')->where($tableName . '.' . $columnName, '=', $columnValue)->get(1);
			$data = $data[0];
			// echo "<pre>";
			// var_dump($data);
			// echo "</pre>";
		}

		// == form infor - END

		$formHTML .= "<form action='$frmAction'  method= '$frmMethod' name = '$frmName' id = '$frmId'>";
		$formHTML .= '<h1>' . $rules[0]->title . '</h1>';
		$formHTML .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';

		for ($i = 0; $i < count($arrRow); $i++) {
			$formHTML .= "<div class ='row'>"; // start row
			// START - check type input and add input to form
			foreach ($rules as $element) {
				switch ($element->type) {
				// ============================ CASE TEXT ========================================================
					case "text":
					if ($element->rowId == $arrRow[$i]) {
						$readonly = "";
						if (isset($element->readonly) && trim($element->readonly) !== '' && $element->readonly = true) {
							$readonly = "readonly";
						}

						$disabled = "";
						if (isset($element->disabled) && trim($element->disabled) !== '' && $element->disabled = true) {
							$disabled = "disabled";
						}

						$value = "";
						if (isset($element->filterColumn)) {
							$filterColumnInput = $element->filterColumn;
							// check exists $data->$filterColumnInput => có tồn tại biến data => trường hợp edit => Gán value input = biến value tìm dc bên dưới
							if (isset($data->$filterColumnInput)) {
								$value = $data->$filterColumnInput;
							}

						}
						$formHTML .= "<div class='form-group col-md-$element->width'>
						<label for='email'>$element->label</label>
						<input type=$element->type class='form-control' name = $element->name id = $element->id placeholder = '$element->placeholder'  $readonly $disabled value = '$value'>
						</div>";
					}
					break;

				// =========================== CASE PASS WORD ====================================================
					case "password":
					if ($element->rowId == $arrRow[$i]) {
						$readonly = "";
						if (isset($element->readonly) && trim($element->readonly) !== '' && $element->readonly = true) {
							$readonly = "readonly";
						}

						$disabled = "";
						if (isset($element->disabled) && trim($element->disabled) !== '' && $element->disabled = true) {
							$disabled = "disabled";
						}

						$value = "";
						if (isset($element->filterColumn)) {
							$filterColumnInput = $element->filterColumn;
							// check exists $data->$filterColumnInput => có tồn tại biến data => trường hợp edit => Gán value input = biến value tìm dc bên dưới
							if (isset($data->$filterColumnInput)) {
								$value = $data->$filterColumnInput;
							}

						}
						$formHTML .= "<div class='form-group col-md-$element->width'>
						<label for='email'>$element->label</label>
						<input type=$element->type class='form-control' name = $element->name id = $element->id placeholder = '$element->placeholder'  $readonly $disabled value = '$value'>
						</div>";
					}
					break;

				// =========================== CASE EMAIL ====================================================
					case "email":
					if ($element->rowId == $arrRow[$i]) {
						$readonly = "";
						if (isset($element->readonly) && trim($element->readonly) !== '' && $element->readonly = true) {
							$readonly = "readonly";
						}

						$disabled = "";
						if (isset($element->disabled) && trim($element->disabled) !== '' && $element->disabled = true) {
							$disabled = "disabled";
						}

						$value = "";
						if (isset($element->filterColumn)) {
							$filterColumnInput = $element->filterColumn;
							// check exists $data->$filterColumnInput => có tồn tại biến data => trường hợp edit => Gán value input = biến value tìm dc bên dưới
							if (isset($data->$filterColumnInput)) {
								$value = $data->$filterColumnInput;
							}

						}
						$formHTML .= "<div class='form-group col-md-$element->width'>
						<label for='email'>$element->label</label>
						<input type=$element->type class='form-control' name = $element->name id = $element->id placeholder = '$element->placeholder'  $readonly $disabled value = '$value'>
						</div>";
					}
					break;
				// =========================== CASE DATE ====================================================
					case "date":
					if ($element->rowId == $arrRow[$i]) {
						$readonly = "";
						if (isset($element->readonly) && trim($element->readonly) !== '' && $element->readonly = true) {
							$readonly = "readonly";
						}

						$disabled = "";
						if (isset($element->disabled) && trim($element->disabled) !== '' && $element->disabled = true) {
							$disabled = "disabled";
						}

						$minDate = "";
						if (isset($element->min) && trim($element->min) !== '') {
							$minDate = "min='$element->min'";
						}

						$maxDate = "";
						if (isset($element->max) && trim($element->max) !== '') {
							$maxDate = "max = '$element->max'";
						}

						$value = "";
						if (isset($element->filterColumn)) {
							$filterColumnInput = $element->filterColumn;
							// check exists $data->$filterColumnInput => có tồn tại biến data => trường hợp edit => Gán value input = biến value tìm dc bên dưới
							if (isset($data->$filterColumnInput)) {
								$tmpDate = new DateTime($data->$filterColumnInput);
								$value = $tmpDate->format('Y-m-d');
							}

						}

						$formHTML .= "<div class='form-group col-md-$element->width'>
						<label for='email'>$element->label</label>
						<input type=$element->type class='form-control' name = $element->name id = $element->id placeholder = '$element->placeholder'  $readonly $disabled  $minDate $maxDate  value = '$value'>
						</div>";
					}
					break;

				// =========================== CASE NUMBER ====================================================
					case "number":
					if ($element->rowId == $arrRow[$i]) {
						$readonly = "";
						if (isset($element->readonly) && trim($element->readonly) !== '' && $element->readonly = true) {
							$readonly = "readonly";
						}

						$disabled = "";
						if (isset($element->disabled) && trim($element->disabled) !== '' && $element->disabled = true) {
							$disabled = "disabled";
						}

						$minNum = "";
						if (isset($element->min) && trim($element->min) !== '') {
							$minNum = "min='$element->min'";
						}

						$maxNum = "";
						if (isset($element->max) && trim($element->max) !== '') {
							$maxNum = "max = '$element->max'";
						}
						$value ="";
						if (isset($element->filterColumn)) {
							$filterColumnInput = $element->filterColumn;
							// check exists $data->$filterColumnInput => có tồn tại biến data => trường hợp edit => Gán value input = biến value tìm dc bên dưới
							if (isset($data->$filterColumnInput)) {
								$value = $data->$filterColumnInput;
							}

						}

						$formHTML .= "<div class='form-group col-md-$element->width'>
						<label for='email'>$element->label</label>
						<input type=$element->type class='form-control' name = $element->name id = $element->id placeholder = '$element->placeholder'  $readonly $disabled  $minNum $maxNum  value = '$value'>
						</div>";
					}
					break;

				//========================= CASE TEXTAREA ========================================================
					case "textarea":
					if ($element->rowId == $arrRow[$i]) {
						$readonly = "";
						if (isset($element->readonly) && trim($element->readonly) !== '' && $element->readonly = true) {
							$readonly = "readonly";
						}

						$disabled = "";
						if (isset($element->disabled) && trim($element->disabled) !== '' && $element->disabled = true) {
							$disabled = "disabled";
						}

						if (isset($element->filterColumn)) {
							$filterColumnInput = $element->filterColumn;
							// check exists $data->$filterColumnInput => có tồn tại biến data => trường hợp edit => Gán value input = biến value tìm dc bên dưới
							if (isset($data->$filterColumnInput)) {
								$value = $data->$filterColumnInput;
							}

						}
						$formHTML .= "<div class='form-group col-md-$element->width'>
						<label for='comment'>$element->label</label>
						<textarea class='form-control' rows=$element->rows cols = $element->cols id= $element->id name = $element->name $readonly $disabled placeholder = '$element->placeholder'>$value</textarea>
						</div>";
					}
					break;

				//=================================== CASE RADIO RADIO ===========================================
					case "radio":
					if ($element->rowId == $arrRow[$i]) {
						$formHTML .= "<div class='form-group col-md-$element->width'> <label for='email'>$element->label</label>";
						if (count($element->options) > 0) {
							for ($j = 0; $j < count($element->options); $j++) {
								$disabled = "";
								if (isset($element->options[$j]->disabled) && trim($element->options[$j]->disabled) !== '' && $element->options[$j]->disabled = true) {
									$disabled = "disabled";
								}

								$checked = "";
								if (isset($element->options[$j]->checked) && trim($element->options[$j]->checked) !== '' && $element->options[$j]->checked = true) {
									$checked = "checked='checked'";
								}

								$optionText = $element->options[$j]->text;
								$optionValue = $element->options[$j]->value;
								$formHTML .= "<div class='radio'>
								<label><input type=$element->type name=$element->name value = '$optionValue' $checked $disabled >$optionText</label>
								</div>";
							}
						}
						$formHTML .= "</div>";
					}
					break;
				//=================================== CASE CHECK BOX ===========================================
					case "checkbox":
					if ($element->rowId == $arrRow[$i]) {
						$formHTML .= "<div class='form-group col-md-$element->width'> <label for='email'>$element->label</label>";
						if (count($element->options) > 0) {
							for ($j = 0; $j < count($element->options); $j++) {
								$disabled = "";
								if (isset($element->options[$j]->disabled) && trim($element->options[$j]->disabled) !== '' && $element->options[$j]->disabled = true) {
									$disabled = "disabled";
								}

								$checked = "";
								if (isset($element->options[$j]->checked) && trim($element->options[$j]->checked) !== '' && $element->options[$j]->checked = true) {
									$checked = "checked='checked'";
								}

								$optionText = $element->options[$j]->text;
								$optionValue = $element->options[$j]->value;
								$formHTML .= "<div class='radio'>
								<label><input type=$element->type name=$element->name value = '$optionValue' $checked $disabled >$optionText</label>
								</div>";
							}
						}
						$formHTML .= "</div>";
					}
					break;

				//=================================== CASE SELECT BOX ===========================================
					case "select":
					if ($element->rowId == $arrRow[$i]) {
						$formHTML .= "<div class='form-group col-md-$element->width'> <label for='email'>$element->label</label>";
						$disabled = "";
						if ($element->disabled == true) {
							$disabled = "disabled";
						}

						$formHTML .= "<select class='form-control' id= $element->id name = $element->name $disabled>";
						//set tien` to'
						$prefix="";
						if(isset($element->prefix))
							$prefix = $element->prefix;
						if (isset($element->DB)) {
							// echo $element->DB->tableName;
							$items = DB::table($element->DB->tableName)->select("*")->get();
							$valueColumn = $element->DB->option->value; // tên cột cần xuất giá trị là value cho option
							
							$textColumn = $element->DB->option->text; //tên cột cần xuất giá trị text cho option

							$numberOfOption = count($items);
							for ($k = 0; $k < $numberOfOption; $k++) {
								$valueOption = "value = " . $items[$k]->$valueColumn;
								$textOption = $prefix.$items[$k]->$textColumn;
								$selected = "";
								if (isset($element->DB->partnerFilterColumn)) {
									$partnerFilterColumn = $element->DB->partnerFilterColumn;
									//check has isset($data->$partnerFilterColumn) tức đang tồn tại biến data => thuộc trường hợp edit. Xác định option selected
									if (isset($data->$partnerFilterColumn) && $data->$partnerFilterColumn == $items[$k]->$valueColumn) {
										$selected = "selected='selected'";
									}

								}
								$formHTML .= "<option $valueOption  $disabled $selected>$textOption</option>";
							}
						}
						// static DB
						else{
							if(isset($element->staticDB) && count($element->staticDB) >0){
								if(count($element->staticDB) == 1){
									$valueOption = "value = " . $element->staticDB[0]->value;
									$textOption = $prefix.$element->staticDB[0]->text;
									$formHTML .= "<option $valueOption  $disabled >$textOption</option>";
								}else{
									$countOption1 = count($element->staticDB);
									// echo $countOption;
									// exit();
									for($i1 = 0; $i1 < $countOption1; $i1++){
										$valueOption1 = "value = " . $element->staticDB[$i1]->value;
										$textOption1 = $prefix.$element->staticDB[$i1]->text;
										$selected="";
										if(isset($element->staticDB[$i1]->selected) && ($element->staticDB[$i1]->selected) != null && $element->staticDB[$i1]->selected == true)
											$selected = "selected='selected'";

										$formHTML .= "<option $valueOption1  $disabled $selected>$textOption1</option>";

									}
									// exit();
								}
							}
							// Mix DB
							else{
								if(isset($element->mixDB->tableName) && isset($element->mixDB->filterColumn)){
									$tbN = $element->mixDB->tableName;
									$fColumn = $element->mixDB->filterColumn;
									$arrOption = DB::table($tbN)->select($fColumn)->groupBy($fColumn)->get()->toArray();
									if(count($arrOption) > 0){
										for($r = 0 ; $r < count($arrOption); $r++){
											$valueOption = "value = " . $arrOption[$r]->$fColumn;
											$textOption = $prefix.$arrOption[$r]->$fColumn;
											$formHTML .= "<option $valueOption  $disabled >$textOption</option>";
										}

									}
								}
							}
						}
						$formHTML .= "</select>";
						$formHTML .= "</div>";
					}
					break;

				//============================ CASE BUTTON ========================================================
					case "button":
					if ($element->rowId == $arrRow[$i]) {
						$formHTML .= "<div class='form-group col-md-$element->width'> <label for='email'>$element->label</label>";
						if (count($element->buttons) > 0) {
							$disabled = "";
							if ($element->disabled == true) {
								$disabled = "disabled";
							}

							for ($j = 0; $j < count($element->buttons); $j++) {
								$disabled = "";
								if (isset($element->buttons[$j]->disabled) && trim($element->buttons[$j]->disabled) !== '' && $element->buttons[$j]->disabled = true) {
									$disabled = "disabled";
								}

								$selected = "";
								if (isset($element->buttons[$j]->selected) && trim($element->buttons[$j]->selected) !== '' && $element->buttons[$j]->selected = true) {
									$selected = "selected='selected'";
								}

								$btnType = $element->buttons[$j]->type;
								$btnStyle = $element->buttons[$j]->style;
								$btnSize = $element->buttons[$j]->size;
								$btnText = $element->buttons[$j]->text;
								$btnName = $element->buttons[$j]->name;
								$btnId = $element->buttons[$j]->id;
								$formHTML .= "<button type='$btnType' name = '$btnName' id= '$btnId' class='btn btn-$btnStyle btn-$btnSize'>$btnText</button> &nbsp";
							}
						}
						$formHTML .= "</div>";
					}
					break;
				};
			}
			$formHTML .= "</div>"; //close row div
		}
		$formHTML .= '</form>';
		return $formHTML;

	}

	// public static  function countRow($rules){
	// 	$arrRow =[];
	// 	foreach ($rules as $key => $element) {
	// 		if(isset($element->rowId) && trim($element->rowId)!=='' && filter_var($element->rowId, FILTER_VALIDATE_INT)){
	// 			if(count($arrRow) > 0){
	// 				$flagExist = false;
	// 				for($i=0; $i< count($arrRow); $i++){
	// 					if($element->rowId == $arrRow[$i]){
	// 						$flagExist = true;
	// 						break;
	// 					}
	// 				}
	// 				if($flagExist == false)
	// 					array_push($arrRow,$element->rowId);
	// 			}else{
	// 				array_push($arrRow,$element->rowId);
	// 			}
	// 		}

	// 	}
	// 	return $arrRow;
	// }

	// public static function creatFormAdd($rules){
	// 	$formHTML 	= '<form action="/action_page.php">';
	// 	$formHTML 	.= '<h1>'.$rules[0]->title.'</h1>';
	// 	// START - check type input and add input to form
	// 	foreach ($rules as $element) {
	// 		switch ($element->type) {
	// 			// ============================ CASE TEXT ========================================================
	// 			case "text":
	// 			$readonly="";
	// 			if($element->readonly !== null)
	// 				$readonly="readonly";
	// 			$disabled="";
	// 			if(isset($element->disabled) && trim($element->disabled)!=='' && $element->disabled = true)
	// 				$disabled="disabled";
	// 			$formHTML .="<div class='form-group col-md-$element->width'>
	// 			<label for='email'>$element->label</label>
	// 			<input type=$element->type class='form-control' name = $element->name id = $element->id placeholder = '$element->placeholder'  $readonly $disabled value = '$element->value'>
	// 			</div>";
	// 			break;

	// 			//========================= CASE TEXTAREA ========================================================
	// 			case "textarea":
	// 			$readonly ="";
	// 			if(isset($element->readonly) && trim($element->readonly)!=='' && $element->readonly = true)
	// 				$readonly="readonly";
	// 			$disabled="";
	// 			if(isset($element->disabled) && trim($element->disabled)!=='' && $element->disabled = true)
	// 				$disabled="disabled";
	// 			$formHTML .="<div class='form-group col-md-$element->width'>
	// 			<label for='comment'>$element->label</label>
	// 			<textarea class='form-control' rows=$element->rows cols = $element->cols id= $element->id name = $element->name $readonly $disabled >$element->value</textarea>
	// 			</div>";
	// 			break;

	// 			//=================================== CASE RADIO BUTTON ===========================================
	// 			case "radio":
	// 			$formHTML .= "    <div class='radio'>
	// 			<label><input type='radio' name='optradio'>Option 1</label>
	// 			</div>
	// 			<div class='radio'>
	// 			<label><input type='radio' name='optradio'>Option 2</label>
	// 			</div>
	// 			<div class='radio disabled'>
	// 			<label><input type='radio' name='optradio' disabled>Option 3</label>
	// 			</div>";
	// 			break;

	// 			//============================ CASE BUTTON ========================================================
	// 			case "button":
	// 			$formHTML .="<input type = $element->typeSubmit value = $element->value>";

	// 			break;

	// 		};
	// 	}
	// 	$formHTML 	.= '</form>';
	// 	return $formHTML;

	// }

	public static function drawTableconfig($rule) {
		$url = $rule->url;
		$columns = array($rule->column);

		$column_show = array($rule->column_show);

		$table = DB::table($rule->tableName)->paginate($rule->pag);

		$table_all = DB::table($rule->tableName)->get();

		$title = $rule->title;
		$total_column = count($columns[0]);
		$total_row = count($table);
		$row_all = count($table_all);
		$numfield = $rule->numfield;
		$searchfield = array($rule->searchfield);
		$searchfieldindex = array($rule->searchfieldindex);
		$idtable = $rule->idtable;
		if ($numfield == 3) {
			$html = [
				'col' => 'col-md-3',
				'width' => '230px',
			];
		} else {
			$html = [
				'col' => 'col-sm-4',
				'width' => '310px',
			];
		}
		return [$url, $columns, $column_show, $table, $table_all, $title, $total_column, $total_row, $row_all, $numfield, $searchfield, $searchfieldindex, $idtable, $html];
	}

	public static function searchTableconfig($rule) {

		$url = $rule->url;
		$columns = array($rule->column);

		$searchfield = array($rule->searchfield);

		$column_show = array($rule->column_show);

		$table = DB::table($rule->tableName)->where($rule->searchfield, 'like', '%'.$rule->searchfield.'%')->paginate($rule->pag);

		$table_all = DB::table($rule->tableName)->get();

		$title = $rule->title;
		$total_column = count($columns[0]);
		$total_row = count($table);
		$row_all = count($table_all);
		$numfield = $rule->numfield;
		
		$searchfieldindex = array($rule->searchfieldindex);
		$idtable = $rule->idtable;
		if ($numfield == 3) {
			$html = [
				'col' => 'col-md-3',
				'width' => '230px',
			];
		} else {
			$html = [
				'col' => 'col-sm-4',
				'width' => '310px',
			];
		}
		return [$url, $columns, $column_show, $table, $table_all, $title, $total_column, $total_row, $row_all, $numfield, $searchfield, $searchfieldindex, $idtable, $html];
	}
	public static function delete($tableName, $idtable, $id) {

		$del = DB::table($tableName)->where($idtable, '=', $id)->delete();

	}

}