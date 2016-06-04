<style>
    .modal-dialog {max-width:350px;}
    .btn-social{position: relative;}
    .btn-social span{position: absolute;top: 10px;left: 70px;font-size: 15px;color: #fff;}
    .form-register .selectbox{padding-right: 45px;color: #000;}
    .form-register input#phone{margin-left: 135px;padding-left:0px;}
</style>
<!-- Popup Register -->
<div class="form-register bzPopup bzPopupAnimation" id="popupFormReg">
    <form name="frmRegister" ng-submit="register(frmRegister.$valid)">
        <a onclick="GA('SignUpPopup', 'ClickSignUpWithFacebook', 'SignUpPopup')" ng-click="loginFacebook()" href="" class="btn-reg btn-social"><img src="{{url()}}/public/images/signin_facebook.png" class="img-responsive"><span>{{ 'signup_facebook'| translate }}</span></a>
        <a onclick="GA('SignUpPopup', 'ClickSignUpWithGoogle', 'SignUpPopup')" ng-click="loginGoogle()" href="" class="btn-reg btn-social"><img src="{{url()}}/public/images/signin_google.png" class="img-responsive"><span>{{ 'signup_google'| translate }}</span></a>
        <hr class="or" />
        <p class="or" style="text-transform: capitalize;">{{ 'or' | translate }}</p>
        <div class="form-group">
            <input name="txtName" type="text" class="form-control"  id="exampleInputText" placeholder="{{ 'user_name' | translate }}" ng-model="user.name" required /> 
            <!-- <p class="message-error" id="message-name" ng-show="frmRegister.txtName.$invalid && submitted">Họ tên không được để trống</p> -->
        </div>
        <div class="form-group">
            <div class="bg-input">
                <div class="bg-select">
                    <select class="selectbox" ng-model="user.phone_code" required>
                      <option ng-repeat="(key,option) in conts_country" value="{{key}}">(+{{option.calling_code}}) {{option.name}}</option>
                  </select>
              </div>
              <input type="number" id="phone" placeholder="{{ 'phone' | translate }}" ng-model="user.phone" required>
          </div>
          <!-- <p class="message-error" id="message-phone" ng-show="frmRegister.phone.$invalid && submitted">Số điện thoại phải là số</p> -->
      </div>
      <div class="form-group">
        <input name="email" type="text" class="form-control" id="exampleInputEmail" placeholder="{{ 'email' | translate }}" ng-model="user.email" required/>
        <!-- <p class="message-error" id="message-email" ng-show="frmRegister.email.$invalid && submitted" class="message-error">Email không hợp lệ</p> -->
    </div>
    <div class="form-group">
        <input name="password" type="password" class="form-control" id="exampleInputPass" placeholder="{{ 'password' | translate }}" ng-model="user.password" minlength="6" required/>
        <!-- <p class="message-error" id="message-email" ng-show="frmRegister.password.$invalid && submitted" class="message-error">Bạn chưa nhập password</p> -->
    </div>
    <p class="alert alert-danger" ng-show="errorsRegister" style="color: #a94442;"><span ng-repeat="(key, value) in errorsRegister"><span ng-repeat="(key1, value1) in value">{{value1}}</span><br/></span></p>
    <p class="agree-to-terms">{{ 'term_register1' | translate }} <a onclick="GA('SignUpPopup', 'ClickTermService', 'SignUpPopup')" href="{{URL_TERMS_SERVICE}}" target="_blank" class="link">{{ 'term_register2' | translate }}</a></p>
    <input onclick="GA('SignUpPopup', 'ClickSubmitSignUpButton', 'SignUpPopup')" id="btDangKyBanner" class="btn btn-default bg-onrange register" type="submit" value="{{ 'signup' | translate }}">
    <hr/>
    <p class="have-account">{{ 'is_account' | translate }} <a onclick="GA('SignUpPopup', 'ClickLogin', 'SignUpPopup')" href="" ng-click="showLogin()">{{ 'login' | translate }}</a></p>
</form>
</div>