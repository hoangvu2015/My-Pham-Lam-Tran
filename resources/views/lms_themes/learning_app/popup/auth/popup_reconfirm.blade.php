<style>
	.modal-dialog {max-width:600px;}
	.img-confirm{max-width:100%;}
	.wrap{font-size:16px;margin:35px;}
	.wrap p{margin: 0 0 30px;}
	a:hover{text-decoration: none;}
</style>
<!-- Popup Login -->
<div id="pop-confirm">
	<img src="{{url()}}/public/images/New-Layout/confirm1.png" class="img-confirm">
	<div class="wrap">
		<p translate>{{ 'popup_confirmemail_headline2' | translate }}</p>
		<p>
			<span translate>{{ 'popup_confirmemail_content2' | translate:{email:user.email} }}</span> 
			<a onclick="GA('ConfirmPopUp', 'ClickSendEmail', 'ConfirmPopUp')" href="" style="color:#00AB6B;" translate ng-click="sendMail()">{{ 'act_resent' | translate }}</a>
		</p>
		<a style="margin-left: 90%;text-transform: uppercase;color:#000;cursor: pointer;" translate ng-click="cancel()">{{ 'close' | translate }}</a>
	</div>
</div>