<?php

namespace App\Http\Controllers;

use App\Metadata;
use DB;
use Illuminate\Http\Request;

class AccountantController extends Controller
{
    public function index(Request $request)
    {
        $select = DB::table('tbl_template')->select('partner_id', 'partner_name')->get();
        if ($request->get('partner')) {
            $id = DB::table('tbl_template')->where('partner_name', $request->get('partner'))->first();
            $partner_id = DB::table('tbl_partner')->where('partner_id', $id->partner_id)->first();
            $partner = DB::table('tbl_form')->where('partner_id', $partner_id->partner_id)->where('goods_type', $id->goods_type)->first();
            $accountant_template = Metadata::getGroupList('accountant_template');
            $colname = null;
            $showcol1 = null;
            $showcol2 = null;
            $colnamefor = null;
            // Lấy tên col tiếng anh và tiếng việt trong bảng metadata
            foreach ($accountant_template as $value) {
                $array = array(
                    'order' => $value['value3'],
                    'en' => $value['meta_name'],
                    'vi' => $value['value1'],
                    'parent' => $value['value2'],
                    'canedit' => $value['value4'],
                );
                data_set($colname, $value['meta_id'], $array);
            }
            asort($colname); // sort lại thứ tự hiển thị ra ngoài
            foreach ($partner as $key => $value) {
                if ($value == 1 && $key != 'form_id' && $key != 'partner_id' && $key != 'goods_type') {
                    foreach ($colname as $key2 => $value2) {
                        if ($key == $value2['en'] && $value2['parent'] == '') {
                            data_set($showcol1, $value2['vi'], 'rowspan');
                        } elseif ($key == $value2['en'] && $value2['parent'] == '0') {
                            $idcol = $key2; // xác định id cần đếm
                            $numcol = array_count_values(array_column($colname, 'parent'))[$idcol]; // đếm xem trong cột cha có bao nhiêu cột con
                            data_set($showcol1, $value2['vi'], $numcol);
                        }
                        if ($key == $value2['en'] && $value2['parent'] != '0') {
                            data_set($colnamefor, $value2['en'], $value2['canedit']); // thiết lập dữ liệu đổ ra view cho chính xác
                        }
                    }
                }
            } // Lọc lại cột cần hiện thị ở tr đầu tiền bên view
            foreach ($partner as $key => $value) {
                if ($value == 1 && $key == 'form_type') {
                    if ($value == 1 && $key != 'form_id' && $key != 'partner_id' && $key != 'goods_type') {
                        foreach ($colname as $key2 => $value2) {
                            if ($value2['parent'] != '' && $value2['parent'] != 0) {
                                data_set($showcol2, $key2, $value2['vi']);
                            }
                        }
                        break; // chỉ cần duyệt 1 lần là đc
                    }
                }
            } // Lọc lại cột cần hiển thị ở tr thứ 2 bên view
            $dieuphoi = DB::table('tbl_pool_operating')
                ->leftJoin('tbl_receipt_delivery_place as delivery_place', 'tbl_pool_operating.delivery_place_id', '=', 'delivery_place.place_id')
                ->leftJoin('tbl_receipt_delivery_place as receipt_place', 'tbl_pool_operating.receipt_place_id', '=', 'receipt_place.place_id')
                ->leftJoin('tbl_user as driver', 'tbl_pool_operating.driver_id', '=', 'driver.user_id')
                ->leftJoin('tbl_user as assistant', 'tbl_pool_operating.assistant_driver_id', '=', 'assistant.user_id')
                ->leftJoin('tbl_partner as partner', 'tbl_pool_operating.owner_id', '=', 'partner.partner_id')
                ->leftJoin('tbl_trailer as trailer', 'tbl_pool_operating.trailer_id', '=', 'trailer.trailer_id')
                ->leftJoin('tbl_car as car', 'tbl_pool_operating.car_id', '=', 'car.car_id')
                ->leftJoin('tbl_accountant as accountant', 'tbl_pool_operating.pool_id', '=', 'accountant.pool_id')
                ->leftJoin('tbl_goods as goods', 'tbl_pool_operating.goods_id', '=', 'goods.goods_id')
                ->select(
                    'tbl_pool_operating.operating_date as operating_date',
                    'car.car_num as car_num',
                    'goods.sort_name as goods_name',
                    'receipt_place.name as receipt_name',
                    'delivery_place.name as delivery_name',
                    'driver.nick_name as driver_nick_name',
                    'assistant.nick_name as assistant_nick_name',
                    'partner.partner_short_name as partner_short_name',
                    'trailer.trailer_num as trailer_num',
                    'accountant.standard_loss as standard_loss',
                    'accountant.actual_loss as actual_loss',
                    'accountant.amount_delivery as quantity_real',
                    'accountant.quantity_real_phuy as quantity_real_phuy',
                    'accountant.amount_delivery as amount_delivery',
                    'accountant.amount_received as amount_received',
                    'accountant.price_accountant as price_accountant',
                    'accountant.sum_money_accountant as sum_money_accountant',
                    'accountant.num_kg as num_kg',
                    'accountant.price_transport as price_transport',
                    'accountant.sum_money_transport as sum_money_transport',
                    'accountant.penalty_loss as penalty_loss',
                    'accountant.price_value_loss as price_value_loss',
                    'accountant.sum_money_value_loss as sum_money_value_loss',
                    'accountant.payment_amount as payment_amount'
                )
                ->where('tbl_pool_operating.owner_id', $id->partner_id)
                ->where('tbl_pool_operating.goods_type', $id->goods_type)
                ->get();
            foreach ($dieuphoi as $item) {
                $date = date_create($item->operating_date);
                $date = date_format($date, 'd/m/Y');
                data_set($item, 'operating_date', $date);
            }
            // dd($dieuphoi);
        }
        return view('LenhTong.BangKe.index', compact('select', 'partner', 'dieuphoi', 'showcol1', 'showcol2', 'colnamefor'));
    }

    public function all(Request $request)
    {
        $select = DB::table('tbl_template')->select('partner_id', 'partner_name')->get();
        $allpartner = DB::table('tbl_pool_operating')
            ->leftJoin('tbl_receipt_delivery_place as delivery_place', 'tbl_pool_operating.delivery_place_id', '=', 'delivery_place.place_id')
            ->leftJoin('tbl_receipt_delivery_place as receipt_place', 'tbl_pool_operating.receipt_place_id', '=', 'receipt_place.place_id')
            ->leftJoin('tbl_user as driver', 'tbl_pool_operating.driver_id', '=', 'driver.user_id')
            ->leftJoin('tbl_user as assistant', 'tbl_pool_operating.assistant_driver_id', '=', 'assistant.user_id')
            ->leftJoin('tbl_user as curator', 'tbl_pool_operating.curator_id', '=', 'curator.user_id')
            ->leftJoin('tbl_partner as partner', 'tbl_pool_operating.owner_id', '=', 'partner.partner_id')
            ->leftJoin('tbl_trailer as trailer', 'tbl_pool_operating.trailer_id', '=', 'trailer.trailer_id')
            ->leftJoin('tbl_car as car', 'tbl_pool_operating.car_id', '=', 'car.car_id')
            ->leftJoin('tbl_goods as goods', 'tbl_pool_operating.goods_id', '=', 'goods.goods_id')
            ->leftJoin('tbl_accountant as accountant', 'tbl_pool_operating.pool_id', '=', 'accountant.pool_id')
            ->select(
                'tbl_pool_operating.pool_id as pool_id',
                'tbl_pool_operating.operating_date as operating_date',
                'tbl_pool_operating.num as num',
                'curator.nick_name as curator_nick_name',
                'car.car_num as car_num',
                'goods.sort_name as goods_name',
                'receipt_place.name as receipt_name',
                'delivery_place.name as delivery_name',
                'driver.nick_name as driver_nick_name',
                'assistant.nick_name as assistant_nick_name',
                'partner.partner_short_name as partner_short_name',
                'trailer.trailer_num as trailer_num',
                'accountant.month_bill as month_bill',
                'accountant.user_enter as user_enter',
                'accountant.amount_received as amount_received',
                'accountant.amount_delivery as amount_delivery',
                'accountant.amount_received_phuy as amount_received_phuy',
                'accountant.amount_delivery_phuy as amount_delivery_phuy',
                'accountant.price_in_kg as price_in_kg',
                'accountant.standard_loss as standard_loss',
                'accountant.actual_loss as actual_loss',
                'accountant.diff as diff',
                'accountant.weight as weight',
                'accountant.explain_accountant as explain_accountant',
                'accountant.money_accountant as money_accountant',
                'accountant.price_accountant as price_accountant',
                'accountant.debt as debt',
                'accountant.note_accountant as note_accountant',
                'accountant.quantity_real as quantity_real',
                'accountant.quantity_real_phuy as quantity_real_phuy',
                'accountant.price_accountant as price_accountant',
                'accountant.sum_money_accountant as sum_money_accountant',
                'accountant.num_kg as num_kg',
                'accountant.price_transport as price_transport',
                'accountant.sum_money_transport as sum_money_transport',
                'accountant.penalty_loss as penalty_loss',
                'accountant.price_value_loss as price_value_loss',
                'accountant.sum_money_value_loss as sum_money_value_loss',
                'accountant.payment_amount as payment_amount'
            )
            ->get();
        foreach ($allpartner as $item) {
            $date = date_create($item->operating_date);
            $date = date_format($date, 'd/m/Y');
            data_set($item, 'operating_date', $date);
        }
        return view('LenhTong.LenhTongDaChinhSua.allpartner', compact('select', 'allpartner'));
    }
}
