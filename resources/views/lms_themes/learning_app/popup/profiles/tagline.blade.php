<style>
	.modal-content{
		max-width: 350px;
		margin: auto;
	}
	.textarea-tagline{
		width: 100%;
	}
</style>
<div class="form-edit-pass" ng-submit="save(formTagline.$valid)">
	<form name="formTagline">
		<p class="text-title">UPDATE TAGLINE</p>
		<textarea ng-model="teacher.tagline" placeholder="Tagline" id="" rows="10" cols="40" required class="textarea-tagline" maxlength="150"></textarea>
		<input type="submit" class="bz-btn" value="Update" />
	</form>
</div>