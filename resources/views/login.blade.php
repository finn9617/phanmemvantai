<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Đăng nhập</title>
        <meta name="description" content="Love Authority." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
        <link rel="stylesheet" href="css/style.css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
           <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body>
        <!--hero section-->
        <section class="hero">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-8 mx-auto">
                        <div class="card border-none">
                            <div class="card-body">
                                <div class="mt-2">
                                    <img src="{{url('img/user.png')}}" class="brand-logo mx-auto d-block img-fluid rounded-circle"/>
                                </div>
                                <p class="mt-4 text-white lead text-center">
                                    ĐĂNG NHẬP
                                </p>
                                <div class="mt-4" action = "#">
                                    <form id = "form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="alert alert-danger">tài khoản: admin, mk: 123456</div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="email" placeholder="Enter username">
                                            <span id="msg_email" class = "msg-item" style = "color:red;">   </span><br/>
                                        </div>
                                        
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password" placeholder="Enter password">
                                            <span id="msg_password" class = "msg-item" style = "color:red;">   </span><br/>
                                        </div>
<!--                                         <label class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description text-white">Keep me logged in</span>
                                        </label>  -->
                                        <button type="submit" onClick="return get_data()" class="btn btn-primary float-left">Đăng nhập</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </section>
        <script>
        	function get_data() {
                var info = {};
                    $(".msg-item").html("");

                    $.each($('form').serializeArray(),function(){
                        info[this.name] = this.value;
                    }); // lấy toàn bộ val cua form 

                   //console.log(info);

                    $.ajax('{{url("/login")}}', {
                        type: 'POST',  
                        data: info,
                        async: false,
                        success: function (data, status, xhr) {
                             //console.log(data);
                            if(data.errors)
                            {
                                if(data.errors.email){
                                    $( '#msg_email' ).html( data.errors.email[0] );
                                }
                                if(data.errors.password){
                                    $( '#msg_password' ).html( data.errors.password[0] );
                                }
                            }
                            if(data.success)
                            {
                                location = "{{url('/operating')}}";
                            }
                            else
                            {
                                swal({
                                  title: "ERROR !",
                                  text: "Tài khoản hoặc mật khẩu nhập sai",
                                  icon: "warning",
                                  dangerMode: true,
                                })
                                .then((willDelete) => {
                                  if (willDelete) {
                                  }
                                });
                            }
                        }
                    });
                return false;
            }
        </script>
    </body>
</html>
