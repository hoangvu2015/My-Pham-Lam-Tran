<style>
    .modal-dialog {max-width:350px;}
    h3{text-align: center;margin: 0 0 25px 0;color: #000;}
</style>
<!-- Popup Login -->
<div class="form-login bzPopup bzPopupAnimation" id="popupFormForget">
    <form name="frmForget" ng-submit="forgetAct(frmForget.$valid)">
        <h3>{{ 'pwd_mess' | translate }}</h3>
        <div class="form-group" style="margin-bottom: 30px;">
            <input name="email" type="email" class="form-control" id="exampleInputEmail" placeholder="{{ 'email' | translate }}" ng-model="forgerPass.email" required/>
            <!-- <p class="message-error" id="message-email" class="message-error">Email không hợp lệ</p> -->
        </div>
        <input onclick="GA('ForgotPasswordPopUp', 'ClickSubmitReset', 'ForgotPasswordPopUp')" id="btDangKyBanner" class="btn btn-default bg-onrange register" type="submit" value="{{ 'pwd_reset' | translate }}">
    </form>
</div>