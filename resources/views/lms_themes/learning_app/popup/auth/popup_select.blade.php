<style>
    .modal-content{ box-shadow: none; background: none; border: none;}
    #popupSelect{ max-width: 350px; border-radius: 3px; padding: 25px;}
    #popupSelect .btn-submit{ width: 100%; color: white; font-size: 16px; font-weight: 600px; padding: 10px 0; border-radius: 3px; margin: 0 0 10px; border: none; text-decoration: none; display: block;}
    #popupSelect .header{ margin: 0 auto 40px; font-size: 16px; font-weight: 400;}
    #popupSelect .tutor{ background-color: #00ab6b; }
    #popupSelect .student{ background-color: #f5a623; }
</style>
<div class="form-select bzPopup bzPopupAnimation" id="popupSelect">
    <form name="frmSelect">
        <p class="header text-center">
            {{ 'user_label_userbecome' | translate}}
        </p>
        <input type="button" name="student" value="{{ 'user_button_learner' | translate}}" ng-click="select()" class="btn-submit text-center student" onclick="GA('UserBecomePopup', 'ClickLearnerButton', 'UserBecomePopup')">
        <a href="{{ link }}" title="" class="btn-submit text-center tutor" onclick="GA('UserBecomePopup', 'ClickTutorButton', 'UserBecomePopup')">{{ 'user_button_tutor' | translate }}</a>
    </form>
</div>