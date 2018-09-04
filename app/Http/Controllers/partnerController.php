<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Input;
use Response;

class partnerController extends Controller
{
    public function show()
    {
        $partner = DB::table('tbl_partner')->select('partner_id', 'partner_full_name', 'partner_short_name', 'address', 'note')->orderBy('partner_short_name', 'ASC')->get();
        $partner_all = DB::table('tbl_partner')->select('partner_id', 'partner_full_name', 'partner_short_name', 'address', 'note')->orderBy('partner_short_name', 'ASC')->get();

        return view('Partner.index', compact('partner', 'partner_all'));
    }

    public function editPartner($id)
    {
        $partner = DB::table('tbl_partner')->where('partner_id', $id)->first();
        $goods = DB::table('tbl_goods')->select('goods_id', 'sort_name')->orderBy('sort_name', 'ASC')->get();
        $receipt = DB::table('tbl_receipt_delivery_place')->where('place_type', 0)->orderBy('name', 'ASC')->get();
        $delivery = DB::table('tbl_receipt_delivery_place')->where('place_type', 1)->orderBy('name', 'ASC')->get();
        $assistant = DB::table('tbl_user')->where('user_type', 15)->orderBy('nick_name', 'ASC')->get();

        return view('Partner.UpdatePartner', compact('partner', 'goods', 'receipt', 'delivery', 'assistant'));
    }

    public function updatePartner(Request $request)
    {   
        
        Validator::extend('phone', function($attr, $value){
			return preg_match('/^[0-9-+.\s]{9,15}$/', $value);
        });

        $rules = [
            //'txtOwnerName' => 'required|unique:tbl_partner,partner_full_name,'.$request->partner_id.',partner_id',
            'txtOwnerName' => 'nullable|unique:tbl_partner,partner_full_name,'.$request->partner_id.',partner_id',
            'txtShortName' => 'required|unique:tbl_partner,partner_short_name,'.$request->partner_id.',partner_id',
            'txtMST' => 'numeric|unique:tbl_partner,tax_num,'.$request->partner_id.',partner_id|nullable',
            'txtEmail' => 'email|nullable',
            'txtPhone' => 'phone|nullable',     
        ];

        $messages = [
            //'txtOwnerName.required' => 'Trường này không được để trống',
            'txtOwnerName.unique' => 'Tên chủ hàng đã tồn tại',
            'txtShortName.required' => 'Tên viết tắt không được để trống',
            'txtShortName.unique' => 'Tên viết tắt đã tồn tại',
            'txtMST.numeric' => 'Mã số thuế phải là số',
            'txtMST.unique' => 'Mã số thuế trùng với người khác',
            'txtEmail.email' => 'Vui lòng nhập đúng định dạng email',
            'txtPhone.phone' =>'Không đúng định dạng',
        ];

        if($request->fileanh!='undefined'){
            $rules['fileanh'] = 'mimes:jpeg,jpg,png,gif,svg|max:2048|nullable';
            $messages['fileanh.mimes'] = 'Ảnh không đúng định dạng jpeg, jpg, png, gif, svg';
            $messages['fileanh.max'] = 'Ảnh không quá 2mb';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            if ($request->hasFile('fileanh')) {
                $anh = Input::file('fileanh')->getClientOriginalName();

				if(!preg_match("/^.*\.(jpg|jpeg|png|gif|svg)$/i" ,$anh, $matchs)){
					$error = (object)["fileanh"=>["Không đúng định dạng file"]];
					return Response::json(['errors'=>$error]);
				}

				$extension = pathinfo($anh, PATHINFO_EXTENSION);
				$anh = pathinfo($anh, PATHINFO_FILENAME);
                $anh = date('dmyhms'). "-".str_slug($anh).".".$anh;
                $file = $request->file('fileanh');
                $file->move('img/anhchuhang/', $anh);
                
                $partner = DB::table('tbl_partner')->where('partner_id', $request->partner_id)->first();
                $file1 = $partner->img;
                if (isset($file1)) {
                    if (file_exists(public_path().'/img/anhchuhang/'.$file1)) {
                        unlink(public_path().'/img/anhchuhang/'.$file1);
                    }
                }
                $partner = DB::table('tbl_partner')->where('partner_id', $request->partner_id)
                ->update(['partner_full_name' => $request->txtOwnerName,
                    'partner_short_name' => $request->txtShortName,
                    'tax_num' => $request->txtMST,
                    'phone' => $request->txtPhone,
                    'email' => $request->txtEmail,
                    'address' => $request->txtAddress,
                    'contact_note' => $request->txtContact,
                    'num' => $request->txtAmount,
                    'document1' => $request->txtDocument1,
                    'document2' => $request->txtDocument2,
                    'note' => $request->txtNote,
                    'suggest_note' => $request->txtSgNote,
                    'suggest_goods' => $request->selGoods,
                    'suggest_receipt' => $request->selReceipt,
                    'suggest_delivery' => $request->selDeliver,
                    'suggest_user' => $request->selAssistant,
                    'img' => $anh,
                    'email_contact' => $request->txtEmailContact
                ]);

                return response()->json(['success'=>'1']);
            } else {
                $partner = DB::table('tbl_partner')->where('partner_id', $request->partner_id)
                ->update(['partner_full_name' => $request->txtOwnerName,
                    'partner_short_name' => $request->txtShortName,
                    'tax_num' => $request->txtMST,
                    'phone' => $request->txtPhone,
                    'email' => $request->txtEmail,
                    'address' => $request->txtAddress,
                    'contact_note' => $request->txtContact,
                    'num' => $request->txtAmount,
                    'document1' => $request->txtDocument1,
                    'document2' => $request->txtDocument2,
                    'note' => $request->txtNote,
                    'suggest_note' => $request->txtSgNote,
                    'suggest_goods' => $request->selGoods,
                    'suggest_receipt' => $request->selReceipt,
                    'suggest_delivery' => $request->selDeliver,
                    'suggest_user' => $request->selAssistant,
                    'email_contact' => $request->txtEmailContact
                ]);
                return response()->json(['success'=>'1']);
            }
        }
        return response()->json(['errors'=>$validator->errors()],200,array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    public function getCreate()
    {
        $goods = DB::table('tbl_goods')->select('goods_id', 'sort_name')->orderBy('sort_name', 'ASC')->get();
        $receipt = DB::table('tbl_receipt_delivery_place')->where('place_type', 0)->orderBy('name', 'ASC')->get();
        $delivery = DB::table('tbl_receipt_delivery_place')->where('place_type', 1)->orderBy('name', 'ASC')->get();
        $assistant = DB::table('tbl_user')->where('user_type', 15)->orderBy('nick_name', 'ASC')->get();
        return view('Partner.createPartner', compact('partner', 'goods', 'receipt', 'delivery', 'assistant'));
    }

    public function postCreate(Request $request)
    {   

        Validator::extend('phone', function($attr, $value){
			return preg_match('/^[0-9-+.\s]{9,15}$/', $value);
        });
        
        $rules = [
            //'txtOwnerName' => 'required|unique:tbl_partner,partner_full_name',
            'txtOwnerName' => 'nullable|unique:tbl_partner,partner_full_name',
            'txtShortName' => 'required|unique:tbl_partner,partner_short_name',
            'txtMST' => 'numeric|unique:tbl_partner,tax_num|nullable',
            'txtEmail' => 'email|nullable',
            'txtPhone' => 'phone|nullable',
        ];

        $messages = [
            //'txtOwnerName.required' => 'Trường này không được để trống',
            'txtOwnerName.unique' => 'Tên chủ hàng đã tồn tại',
            'txtShortName.required' => 'Tên viết tắt không được để trống',
            'txtShortName.unique' => 'Tên viết tắt đã tồn tại',
            'txtMST.numeric' => 'Mã số thuế phải là số',
            'txtMST.unique' => 'Mã số thuế trùng với người khác',
            'txtEmail.email' => 'Vui lòng nhập đúng định dạng email',
            'txtPhone.phone' =>'Không đúng định dạng',
        ];

        if($request->fileanh!='undefined'){
            $rules['fileanh'] = 'mimes:jpeg,jpg,png,gif,svg|max:2048|nullable';
            $messages['fileanh.mimes'] = 'Ảnh không đúng định dạng jpeg, jpg, png, gif, svg';
            $messages['fileanh.max'] = 'Ảnh không quá 2mb';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            if ($request->hasFile('fileanh')) {
                $anh = Input::file('fileanh')->getClientOriginalName();

				if(!preg_match("/^.*\.(jpg|jpeg|png|gif|svg)$/i" ,$anh, $matchs)){
					$error = (object)["fileanh"=>["Không đúng định dạng file"]];
					return Response::json(['errors'=>$error]);
				}

				$extension = pathinfo($anh, PATHINFO_EXTENSION);
				$anh = pathinfo($anh, PATHINFO_FILENAME);
                $anh = date('dmyhms'). "-".str_slug($anh).".".$anh;
                $file = $request->file('fileanh');
                $file->move('img/anhchuhang/', $anh);
            } else {
                $anh = null;
            }
            $partner = DB::table('tbl_partner')
                ->insert(['partner_full_name' => $request->txtOwnerName,
                    'partner_short_name' => $request->txtShortName,
                    'tax_num' => $request->txtMST,
                    'phone' => $request->txtPhone,
                    'email' => $request->txtEmail,
                    'address' => $request->txtAddress,
                    'contact_note' => $request->txtContact,
                    'num' => $request->txtAmount,
                    'document1' => $request->txtDocument1,
                    'document2' => $request->txtDocument2,
                    'note' => $request->txtNote,
                    'suggest_note' => $request->txtSgNote,
                    'suggest_goods' => $request->selGoods,
                    'suggest_receipt' => $request->selReceipt,
                    'suggest_delivery' => $request->selDeliver,
                    'suggest_user' => $request->selAssistant,
                    'img' => $anh,
                    'email_contact' => $request->txtEmailContact,
                ]);

            return response()->json(['success'=>'1']);
        }
        return response()->json(['errors'=>$validator->errors()],200,array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    public function searchPartner(Request $req)
    {
        $partner_s = $req->tenpartner;
        $partner_sh = $req->shortpartner;

        if ($req->tenpartner == '' && $req->shortpartner == '') {
            return redirect('/partner');
        } else {
            if ($req->shortpartner == '') {
                $partner = DB::table('tbl_partner')->where('partner_id', 'LIKE', '%'.$req->tenpartner.'%')->orderBy('partner_full_name', 'ASC')->get();

                return view('Partner.index', compact('partner', 'partner_s'));
            } else {
                $partner = DB::table('tbl_partner')->where('partner_id', 'LIKE', '%'.$req->shortpartner.'%')->orderBy('partner_short_name', 'ASC')->get();

                return view('Partner.index', compact('partner', 'partner_s', 'partner_sh'));
            }
        }
    }

    public function delete($id)
    {
        $image = DB::table('tbl_partner')->where('partner_id', $id)->first();
        $file = $image->img;
        if (isset($file1)) {
            if (file_exists(public_path().'/img/anhchuhang/'.$file)) {
                unlink(public_path().'/img/anhchuhang/'.$file);
            }
        }

        $image = DB::table('tbl_partner')->where('partner_id', $id)->delete();

        return redirect('/partner');
    }

    public function getData()
    {
        $partner = DB::table('tbl_partner')->orderBy('partner_short_name', 'ASC')->orderBy('partner_full_name', 'ASC')->get()->toArray();
        $res = (object) [
            'partners' => $partner,
        ];

        return Response::json(['success' => $res]);
    }
}
