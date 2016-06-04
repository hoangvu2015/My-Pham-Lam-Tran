<style>
    .modal-dialog {max-width:350px;}
    .btn-social{position: relative;}
    .btn-social span{position: absolute;top: 10px;left: 70px;font-size: 15px;color: #fff;}
</style>
<!-- Popup Login -->
<div class="form-login bzPopup bzPopupAnimation" id="popupFormLogin">
    <form name="frmLogin" ng-submit="login(frmLogin.$valid)">
        <a onclick="GA('LoginPopup', 'ClickLoginWithFaceBook', 'LoginPopup')" ng-click="loginFacebook()" href="" class="btn-reg btn-social"><img src="{{url()}}/public/images/signin_facebook.png" class="img-responsive"><span>{{ 'login_facebook'| translate }}</span></a>
        <a onclick="GA('LoginPopup', 'ClickLoginWithGoogle', 'LoginPopup')" ng-click="loginGoogle()" href="" class="btn-reg btn-social"><img src="{{url()}}/public/images/signin_google.png" class="img-responsive"><span>{{ 'login_google'| translate }}</span></a>
        <hr class="or" />
        <p class="or" style="text-transform: capitalize;">{{ 'or' | translate }}</p>
        <div class="form-group">
            <input name="email" type="email" class="form-control" id="exampleInputEmail" placeholder="{{ 'email' | translate }}" ng-model="user.email" required/>
            <!-- <p class="message-error" id="message-email" class="message-error">Email không hợp lệ</p> -->
        </div>
        <div class="form-group">
            <input name="password" type="password" class="form-control" id="exampleInputPass" placeholder="{{ 'password' | translate }}" ng-model="user.password" required/>
            <!-- <p class="message-error" id="message-email" class="message-error">Bạn chưa nhập password</p> -->
        </div>
            <p ng-show="message_lockout_time" class="alert alert-danger">{{message_lockout_time}}</p>
            <p ng-show="errorLogin" class="alert alert-danger">{{ 'valid_login' | translate }}</p>

        <label class="float-left helper"><input onclick="GA('LoginPopup', 'ClickRememberMe', 'LoginPopup')" type="checkbox" style="height: unset;opacity: 1;" ng-model="user.remember"/>{{ 'log_remember' | translate }}</label>
        <a onclick="GA('LoginPopup', 'ClickForgotPassword', 'LoginPopup')" href="" class="float-right helper" style="text-decoration: none;" ng-click="showForget()">{{ 'log_forgot' | translate }}</a>
        <input onclick="GA('LoginPopup', 'ClickSubmitLoginButton', 'LoginPopup')" id="btDangKyBanner" class="btn btn-default bg-onrange register" type="submit" value="{{ 'login' | translate }}">
        <hr style="margin-top: 40px;" />
        <p class="have-account">{{ 'log_reg' | translate }}<a onclick="GA('LoginPopup', 'ClickSignUp', 'LoginPopup')" href="" ng-click="showRegister()"> {{ 'signup' | translate }}</a></p>
    </form>
</div>