<style>
	.modal-content{
		max-width: 350px;
		margin: auto;
	}
</style>
<div class="form-edit-pass" ng-submit="save(formChangePass.$valid)">
	<form name="formChangePass">
		<p class="text-title">THAY ĐỔI MẬT KHẨU</p>
		<input type="password" placeholder="Mật khẩu mới" required ng-model="infoPass.password"/><br>
		<input type="password" placeholder="Xác nhận mật khẩu mới" required ng-model="infoPass.password_confirmation"/><br>
		<div class="alert alert-danger" ng-if="errors" style="margin-top:10px;">
		<p ng-repeat="(key, value) in errors"> {{value}}</p>
		</div>
		<input type="submit" class="bz-btn" value="THAY ĐỔI MẬT KHẨU" />
	</form>
</div>