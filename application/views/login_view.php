<div class="page-content container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-wrapper">
                <div class="box">
                    <div class="content-wrap">
                        <h6>Sign In</h6>
                        <form action="" id="login">
                        <input class="form-control" type="text" name="login" placeholder="Login" value="">
                        <input class="form-control" type="password" name="password" placeholder="Password" value="">
                        </form>
                        <div class="action">
                            <span class="btn btn-primary signup">Login</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $( document ).ready(function() {
        $("span").click(function () {
            $.ajax({
                type:"POST",
                url:'ajax/login/',
                data:$('#login input').serialize(),//only input
                success: function(response){
                    if(response === "success"){
                        $('#error').fadeOut(1000);
                        $('#error').remove();
                        window.location.replace("");
                    }else{
                        $('#error').fadeOut(1000);
                        $('#error').remove();
                        $('.content-wrap').prepend('<div class="panel-title" id="error">Wrong credentials</div>')
                        $('#error').fadeIn(1000);
                    }
                }
            });

        })

    });
</script>