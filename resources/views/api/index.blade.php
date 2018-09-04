@extends('masterMap')
@section('main')
<div id="main">
    <div id="dragbar"></div>
    <div id="googleMap" style="height:916px;">
    </div> 
    <div id='seconds-counter'></div>
</div>


<div id="mymodal-custom" class="custom">
    <div class="modal-content-custom">
        <span class="close">&times;</span>
        <div class="container-fuild">
            <div class="row">
                {{-- ===============START-FORM-SEARCH====================== --}}
                <form  action = "" method="GET" style="">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                    <div class = "row" style="margin-top: 15px;">
                
                        {{-- =============================================== --}}
                        <div class = "col-md-2" style=" margin-bottom:15px;">
                            <div class='input-group date' style="font-size:18px">
                                <input type='text' class="form-control datetimepicker" id="dateStart" placeholder="Chọn ngày giờ ..." />
                                <span class="input-group-addon " ><span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div><br>
                        </div>
                        {{-- =============================================== --}}
                        {{-- =============================================== --}}
                        <div class = "col-md-2"  style=" margin-bottom:15px;">
                            <div class='input-group date' style="font-size:18px">
                                <input type='text' class="form-control datetimepicker" id="dateEnd" placeholder="Chọn ngày giờ ..." />
                                <span class="input-group-addon" ><span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div><br>
                        </div>
                        {{-- =============================================== --}}
                        <div class = "col-md-2"  style="">
                        <button type="submit" class="btn btn-success pull-left" style="height: 32px;  margin-bottom:15px;" id="submit"><i class="fa fa-search"></i>&nbsp&nbspTìm kiếm</button>
                        </div>
                    </div>
                </form>
                <div class="card col-sm-4">   
                        <table class="table " style="margin-bottom:0;border-bottom:1px solid #ddd;">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Biển số</th>
                                <th scope="col">Lat</th>
                                <th scope="col">Lng</th>
                                <th scope="col">Ngày giờ</th>
                            </tr>
                        </table>                         
                    <div class="card-body" style="height:700px;overflow: auto;">
                        <table class="table table-hover" id="car_move" style="overflow: auto;">
                            <tbody class="data" style="overflow: auto;">
                                
                            </tbody>
                        </table>
                        <div id="timthay" class="khontimthay text-center" style="font-size:18px;margin-bottom:30px;" >
                            <div id="add-search">  </div>
                        </div>
                        
                    </div>
                    <div onclick="myTimer()" class="btn btn-primary text-right">Chạy thử</div>
                </div>
                <div class="col-md-8">
                    <div id="Map" style="height:760px;">
                    </div> 
                    <div id="MapMoi"> 

                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>

@endsection




@section('script')
var start ='';
var end = '';
$('#dateStart').focusout(function(){
    start= $('#dateStart').val();
    start = start.split(' ');

    
})
$('#dateEnd').focusout(function(){
    end= $('#dateEnd').val();
    end = end.split(' ');

     oldDate1 = start[0];
     oldDate2 = end[0];


    
    var arrDate1  = oldDate1.split('-');
    var newDate1  = new Date(arrDate1[2], arrDate1[1] - 1, arrDate1[0]);
    var date1 = new Date(newDate1).getTime();

    var arrDate2  = oldDate2.split('-');
    var newDate2  = new Date(arrDate2[2], arrDate2[1] - 1, arrDate2[0]);
    var date2 = new Date(newDate2).getTime();

    var date = new Date()
    var newDate  = new Date( date.getFullYear(), date.getMonth(), date.getDate() );
    var Date1 = new Date(newDate).getTime();

    if(date1 > date2 || date2 > Date1){
        swal({
            title: "Error!",
            text: "Bạn cần kiểm tra lại ngày !",
            icon: "warning"
          });
    }
   
})

$(document).on('click','#submit',function(e){
    e.preventDefault(); // chặn submit reoad trang
    var dateStart = $('#dateStart').val();
    var dateEnd = $('#dateEnd').val()
    start = dateStart.split(' ');
    end = dateEnd.split(' ');

    var arrDate1  = start[0].split('-');
    var newDate1  = new Date(arrDate1[2], arrDate1[1] - 1, arrDate1[0]);
    var date1 = new Date(newDate1).getTime();

    var arrDate2  = end[0].split('-');
    var newDate2  = new Date(arrDate2[2], arrDate2[1] - 1, arrDate2[0]);
    var date2 = new Date(newDate2).getTime();

    var date = new Date()
    var newDate  = new Date( date.getFullYear(), date.getMonth(), date.getDate() );
    var Date1 = new Date(newDate).getTime();

    if(date1 - date2 <= 0 && date2 <= Date1 ){
        if(dateStart != "" && dateEnd != ""){
         $.ajax({
        url: '{{ url("/getInfo") }}',
        type:'get',
        data:{
            'id':car,
            'dateStart': dateStart,
            'dateEnd': dateEnd,
        },
        success: function(data){
            if(data.array == null || data.array == ""){
                $('.data').remove();
                document.getElementById("timthay").innerHTML = '<div id="add-search"> Không tìm thấy dữ liệu ngày giờ bạn cần ! </div>';
                console.log(data.array)

            }else{
                $('.removeRow').remove();
                $('#add-search').remove();
                if(!$('.data').length){
                    document.getElementById("car_move").innerHTML = '<tbody class="data" style="overflow: auto;"></tbody>';
                }
                $.each(data.array, function (key,value){
                    $('.data').append(`
                        <tr class = "removeRow"  >
                            <td scope="col">`+ (key+1) +`</td>
                            <td scope="col">`+ data.carnum +`</td>
                            <td scope="col">`+ value.lat +`</td>
                            <td scope="col">`+ value.lng +`</td>
                            <td scope="col">`+ moment(value.created_at).format('MM-DD-YYYY H:mm:ss ') +`</td>
                        </tr>
                            `)
                        })
                    }
                }
            })
            }else{
                swal({
                    title: "Error!",
                    text: "Bạn cần chọn ngày tìm kiếm !",
                    icon: "warning"
                });
            
            }
    }else{
        swal({
            title: "Error!",
            text: "Bạn cần kiểm tra lại ngày !",
            icon: "warning"
          });
    }
   
})



// onmouseover send
var car = "";
//end onmouseover

 // Get the modal
 var modal = document.getElementById('mymodal-custom');
 var span = document.getElementsByClassName("close")[0];
function modal_map($car) {
    modal.style.display = "block";
    popupMap(car)
    
 }

 span.onclick = function() {
     modal.style.display = "none";
     $('.removeRow').remove();
     $('#add-search').remove();
     if(!$('.data').length){
        document.getElementById("car_move").innerHTML = '<tbody class="data" style="overflow: auto;"></tbody>';
    }
    $('.mapFrame').remove();
    if(!$('#mapFrame').length){
        document.getElementById("MapMoi").innerHTML = '<iframe id="mapFrame"  width="100%" height="760" frameborder="0" style="border:0"></iframe>';
    }
 }
 window.onclick = function(event) {
     if (event.target == modal) {
        modal.style.display = "none";
        $('.removeRow').remove();
        $('#add-search').remove();
        if(!$('.data').length){
            document.getElementById("car_move").innerHTML = '<tbody class="data" style="overflow: auto;"></tbody>';
        }

        $('.mapFrame').remove();
        if(!$('#mapFrame').length){
            document.getElementById("MapMoi").innerHTML = '<iframe id="mapFrame"  width="100%" height="760" frameborder="0" style="border:0"></iframe>';
        }
     }
 }



// map popup  
function popupMap($id){
    var url='{{ url("/locationEndManyCar") }}/'+$id;
    var lat = '';
    var lng = '';
    $.ajax({
        url : url, 
        type : "get",
        async:false,
        success : function (car){
            $.each(car, function (key,value){
                lat = value.lat;
                lng = value.lng;
            });      
        }
    });

    var map = new google.maps.Map(document.getElementById("Map"), {
        center: new google.maps.LatLng(lat,lng)||map.setCenter(marker.getPosition()),
        zoom: 18,
        mapTypeId: 'roadmap'
      });
    
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat, lng),
        map: map,
        icon: icon
    });
    google.maps.event.addListener(marker, 'click', function () {
        map.panTo(marker.getPosition());
    });
    seconds = 15;
    setTimeout(incrementSeconds)
}
// end map popup

//time reload 
var seconds = 15;
var el = document.getElementById('seconds-counter');
function incrementSeconds() {
    if(seconds == 0 ){
        seconds = 15;
        el.innerText = "Đang tải..."
    }
    else{
        seconds -= 1;
        el.innerText = "Tải lại sau " + seconds + "s";
    }
    
} 

// end time reload
setTimeout(incrementSeconds)
setInterval(incrementSeconds, 1000);

// locatin car lat lng end 
function hientai($id){
    var url='{{ url("/locationEndManyCar") }}/'+$id;
    var lat = '';
    var lng = '';
    $.ajax({
        url : url , 
        type : "get",
        async:false,
        success : function (car){
            $.each(car, function (key,value){
                lat = value.lat;
                lng = value.lng;
            });      
        }
    });

    var map = new google.maps.Map(document.getElementById("googleMap"), {
        center: new google.maps.LatLng(lat,lng)||map.setCenter(marker.getPosition()),
        zoom: 18,
        mapTypeId: 'roadmap'
      });
    
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat, lng),
        map: map,
        icon: icon
    });
    google.maps.event.addListener(marker, 'click', function () {
        map.panTo(marker.getPosition());
    });
    seconds = 15;
    setTimeout(incrementSeconds)

}

// end location car
    
// live
function live($id){

    setTimeout(hientai(id))
    setInterval(hientai(id),15000)
}
// end live 

// ajax load mysql 
var locations = []
function load_ajax()
            {
                $.ajax({
                    url:'{{ url("/locationEnd") }}',
                    type : "get",
                    async:false, // chọn phương thức gửi là get
                    success : function (car){
                        $.each(car, function (key,value){
                            locations[key] = (['nguyen',Number(value.lat),Number(value.lng),key]);
                            
                        });      
                    }
                });
                markerEnd(locations)
            } 

// end ajaax
setTimeout(load_ajax,500)
setInterval(load_ajax,15000)


// click right
 $(function() {
    $.contextMenu({
        selector: '.context-menu-one',
        callback: function(key, options) {
            if(key == 'hientai'){
                hientai(car)
            }
            if(key == 'live'){
                hientai(car)
            }
            if(key == 'lotrinh'){
                modal_map()
            }
        },
        items: {
            "hientai": {
                name: "Hiện Tại",
                icon: "fa-map-marker"
            },
            "sep1": "---------",
            "live": {
                name: "LiveTime",
                icon: "fa-angle-double-right"
            },
            "sep2": "---------",
            "lotrinh": {
                name: "Lộ Trình",
                icon: "fa-play-circle"
            }                    
        }
    });

    $('.context-menu-one').on('click', function(e) {
    })
});  
//end click right



var map = new google.maps.Map(document.getElementById('googleMap'), {
    zoom: 6,
    center: new google.maps.LatLng(10.7652913, 106.6296893),
    mapTypeId: google.maps.MapTypeId.ROADMAP
});

var infowindow = new google.maps.InfoWindow();

var marker, i;
var car = "M17.402,0H5.643C2.526,0,0,3.467,0,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759c3.116,0,5.644-2.527,5.644-5.644 V6.584C23.044,3.467,20.518,0,17.402,0z M22.057,14.188v11.665l-2.729,0.351v-4.806L22.057,14.188z M20.625,10.773 c-1.016,3.9-2.219,8.51-2.219,8.51H4.638l-2.222-8.51C2.417,10.773,11.3,7.755,20.625,10.773z M3.748,21.713v4.492l-2.73-0.349 V14.502L3.748,21.713z M1.018,37.938V27.579l2.73,0.343v8.196L1.018,37.938z M2.575,40.882l2.218-3.336h13.771l2.219,3.336H2.575z M19.328,35.805v-7.872l2.729-0.355v10.048L19.328,35.805z";
var icon = {
    path: car,
    scale: .7,
    strokeColor: 'white',
    strokeWeight: .1,
    fillOpacity: 1,
    fillColor: '#404040',
    offset: '1%',
    // rotation: parseInt(heading[i]),
    anchor: new google.maps.Point(10, 25) // orig 10,50 back of car, 10,0 front of car, 10,25 center of car
};

function markerEnd (locations){
    for (i = 0; i < locations.length; i++) {
    marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        icon: icon
    });

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
        }
    })(marker, i));
}
}

// car move ao
    function myTimer() {
        var doo = [];

        var dateStart = $('#dateStart').val();
        var dateEnd = $('#dateEnd').val();
        if(dateStart != "" && dateEnd != ""){

            $.ajax({
                url: '{{ url("/getInfo1") }}',
                type:'get',
                data:{
                    'id':car,
                    'dateStart': dateStart,
                    'dateEnd': dateEnd,
                },
                async: false, 
                success: function(data){
                    if(data.array == null || data.array == ""){
                        swal({
                            title: "Error!",
                            text: "Không có dữ liệu ngày giờ !",
                            icon: "warning"
                          });
        
                    }else{
                        $('#Map').remove();
                        document.getElementById("MapMoi").innerHTML = '<iframe id="mapFrame"  width="100%" height="760" frameborder="0" style="border:0"></iframe>';  
                        var  url_map = '{{ url('/mapxe') }}';
                        var params = "?carid="+car+"&datestart="+dateStart+"&dateend="+dateEnd;
                        document.getElementById("mapFrame").src = url_map + params; 
                   
                    }
                }
            })
        }else{
            swal({
                title: "Error!",
                text: "Bạn cần chọn ngày để di chuyển !",
                icon: "warning"
              });
        }
    }
// end car move ao

@endsection

