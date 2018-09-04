<div id="sidebar">
    <div id='cssmenu'>  
        <ul>
            <li class='has-sub'><a href='#'><p style="line-height: 0;font-size: 14px;margin-bottom: 0;">Danh sách xe</p></a>
                <ul>
                    <li class='last' style="height:700px;">
                        <table class="table text-center table-hover" style="margin: 2px;cursor: pointer; white-space: nowrap;" >
                            <thead class="header-table">
                            <tr class="">
                                <th>Icon</th>
                                <th>Biển số</th>
                                <th>Ngày giờ</th>
                                <th>Km/h</th>
                                <th>Ngày giờ</th>
                                <th>Vị trí</th>
                                <th>Số ĐT</th>
                            </tr>
                            </thead>
                            <tbody >
                                <?php 
                                    $car = DB::table('tbl_location')
                                        ->join('tbl_car','tbl_car.car_id','=','tbl_location.car_id')    
                                        ->groupby('tbl_car.car_id')
                                        ->get();
                                    
                                ?>
                                @foreach ($car as $c )
                                    <tr class="context-menu-one car-{{ $c->car_id }}" id="test" input="2"  onmouseover="car='{{ $c->car_id }}';"  onclick="hientai({{ $c->car_id }})">
                                        <td><img src="{{ asset('img/car1.png') }}" alt=""  ></td>
                                        <td>{{ $c->car_num }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </li>
                </ul>
            </li>
            <li class='has-sub'><a href='#'><p style="line-height: 0;font-size: 14px;margin-bottom: 0;">Lộ trình </p></a>
                <ul>
                    <li><a href='#'><p style="line-height: 0;font-size: 14px;margin-bottom: 0;">Company</p></a></li>
                    <li class='last'><a href='#'><p>Contact</p></a></li>
                </ul>
            </li>         
            <li class='has-sub'><a href='#'><p style="line-height: 0;font-size: 14px;margin-bottom: 0;">Lộ trình </p></a>
                <ul>
                    <li><a href='#'><p>Company</p></a></li>
                    <li class='last'><a href='#'><p>Contact</p></a></li>
                </ul>
            </li>   
        </ul>
    </div>
    <div class="footer-menu">
            <img src="{{ asset('img/car1.jpg') }}" alt="" width="30px" height="40px">
            <img src="{{ asset('img/car2.jpg') }}" alt="" width="30px" height="40px">
            <img src="{{ asset('img/car3.jpg') }}" alt="" width="30px" height="40px">
            <img src="{{ asset('img/car4.jpg') }}" alt="" width="30px" height="40px">
            <img src="{{ asset('img/car5.png') }}" alt="" width="40px" height="40px">
    </div>
</div>