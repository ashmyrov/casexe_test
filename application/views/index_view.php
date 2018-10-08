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
                            <input type="hidden" id="giftId" value="">
                            <button type="submit" id="yes" class="btn btn-primary btn-sm editable-submit"><i
                                        class="glyphicon glyphicon-ok"></i></button>
                            <button type="button" id="no" class="btn btn-default btn-sm editable-cancel"><i
                                        class="glyphicon glyphicon-remove"></i></button>
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
            type:"POST",
            url:'ajax/getGift/',
            success: function(response){
                response = JSON.parse(response);
                    $('#gift').html(response.name);
                    $('#giftValue').html(response.value);
                    $('#giftId').html(response.type);
                    $('.popover').show(500);
                }

        });
    });

    $('#yes').click(function () {
        $.ajax({
            type:"POST",
            url:'ajax/saveGift/',
            success: function(response){


                $('#getGift').prop('disabled', false);
            }

        });
    }
</script>