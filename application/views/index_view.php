<button type="button" id="getGift" class="btn btn-lg btn-block btn-primary">Get random gift</button>
<div class="popover fade top in editable-container editable-popup"
     style="position: absolute;top: 66%;left: 44.3%;width: 200px;height: 200px">
    <div class="arrow"></div>
    <h3 class="popover-title">Congratulation!</h3>
    <div class="popover-content">
        <div>
            <div class="editableform-loading" style="display: none;"></div>
            <form class="form-inline editableform" style="">
                <div class="control-group form-group">
                    <div>
                        <div class="editable-input">
                            <p>Your gift is <span id="gift"></span>!!!!! <br>
                                And it's <span id="giftValue"></span>
                            </p>
                        </div>
                        <p>Are you wanna take your gift?</p>
                        <div class="editable-buttons">
                            <span id="exchange" class="btn btn-primary btn-sm" style="display: none">Exchange</span>
                            <input type="hidden" id="giftId" value="">
                            <span id="yes" class="btn btn-primary btn-sm"><i
                                        class="glyphicon glyphicon-ok"></i></span>
                            <span id="no" class="btn btn-danger btn-sm"><i
                                        class="glyphicon glyphicon-remove"></i></span>
                        </div>
                    </div>
                    <div class="editable-error-block help-block" style="display: none;"></div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#getGift').click(function () {
        $(this).prop('disabled', true);
        $.ajax({
            type: "POST",
            url: 'ajax/getGift/',
            success: function (response) {
                response = JSON.parse(response);
                if (response.type === 2) {
                    $('#exchange').show();
                }
                $('#gift').html(response.name);
                $('#giftValue').html(response.value);
                $('#giftId').val(response.type);
                $('.popover').show(500);
            }

        });
    });

    $('#yes').click(function () {
        var id = $('#giftId').val();
        $.ajax({
            type: "POST",
            data: {
                id: id,
                value: $('#giftValue').html(),
                status: 1
            },
            url: 'ajax/saveGift/'
        });
        if(id === '3'){
            $.ajax({
                type: "POST",
                url: 'ajax/updatePoints/',
                success: function (response) {
                    $('#points').fadeOut('slow', function () {
                        $(this).html(response).fadeIn('slow');
                    })
                }
            });
        }

        $('.popover').hide(500);
        $('#exchange').hide();
        $('#getGift').prop('disabled', false);
    });

    $('#no').click(function () {
        $.ajax({
            type: "POST",
            data: {
                id: $('#giftId').val(),
                value: $('#giftValue').html(),
                status: 0
            },
            url: 'ajax/saveGift/'
        });
        $('.popover').hide(500);
        $('#exchange').hide();
        $('#getGift').prop('disabled', false);
    });

    $('#exchange').click(function () {
        $.ajax({
            type: "POST",
            data: {
                id: $('#giftId').val(),
                value: $('#giftValue').html(),
                status: 2
            },
            url: 'ajax/saveGift/'
        });

        $.ajax({
            type: "POST",
            url: 'ajax/updatePoints/',
            success: function (response) {
                $('#points').fadeOut('slow', function () {
                    $(this).html(response).fadeIn('slow');
                })
            }
        });
        $('.popover').hide(500);
        $('#exchange').hide();
        $('#getGift').prop('disabled', false);
    });

</script>