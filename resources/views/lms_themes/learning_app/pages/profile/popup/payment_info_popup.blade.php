<div id="mod-payment-info">
    <div class="content">
        <div class="header">
            <h1 class="header-text text-center">
                YOUR PAYMENT INFORMATION
            </h1>
            <p>
                Please provide Antoree your payment information so that we can send payment to you in accordance to our payment guidelines.
            </p>
        </div>
        <form name="profilePaymentPopup" ng-submit="save(profilePaymentPopup.$valid)">
            <div class="text">
                <p>

                    Place of residence
                </p>
                <select name="residence" ng-model="commom.country" class="select" id="select-group" ng-change="selectCountry()">
                    <option value="" disabled selected style="display: none;" href="">
                        Choose place of residence
                    </option>
                    <option ng-repeat="(key, value) in national" value="{{ key }} | {{ value.group }}" href="{{ value.group }}">{{ value.name }}</option>
                </select>

                <div class="bank {{ payment.class.payment_BA1.active }} {{ payment.class.payment_BA1.showbank }}">
                    <input type="hidden" ng-model="payment.payment_BA1.check">
                    <div class="information-input">
                        <p>Bank account number (Vietnam Dong only)</p>
                        <input type="number" class="input-bank" ng-model="payment.payment_BA1.name_account">
                        <p>Bank name</p>
                        <input type="text" class="input-bank" ng-model="payment.payment_BA1.bank_name">
                        <p>Full name of bank account owner</p>
                        <input type="text" class="input-bank" ng-model="payment.payment_BA1.bank_number">
                        <p>Bank's province/city</p>
                        <input type="text" class="input-bank" ng-model="payment.payment_BA1.bank_city">
                        <p>Bank's branch</p>
                        <input type="text" class="input-bank" ng-model="payment.payment_BA1.bank_branch">
                        <p>The bank account above is under your own name or the name of your relative/friend?</p>
                        <select class="select" ng-model="payment.payment_BA1.account_owner">
                            <option value="1" selected>It is under my own name</option>
                            <option value="0">asgasfasdf</option>
                        </select>
                    </div>
                </div>
                <div class="text-provide bank {{ payment.text_class }}" id="text-provide">
                    <p>
                        <i>
                            Please provide as many payment methods as possible (at least one payment method).
                        </i>
                    </p>
                </div>
                <div class="bank {{ payment.class.payment_BA2.active }} {{ payment.class.payment_BA2.showbank }}" >
                    <input type="hidden" id="bank_philippine_check" ng-model="payment.payment_BA2.check">
                    <div class="title">
                        <input id="philippine-group" name="philippine-group" type="checkbox" class="checkbox-bank">
                        <label for="philippine-group" ng-click="showBank('payment_BA2')">
                            <span>
                                Bank account
                            </span>
                        </label>
                    </div>
                    <div class="information-input">
                        <p>Account holder's full name</p>
                        <input type="text" class="input-bank" ng-model="payment.payment_BA2.name_account">
                        <p>Address</p>
                        <input type="text" class="input-bank" ng-model="payment.payment_BA2.address">
                        <p>City</p>
                        <input type="text" class="input-bank" ng-model="payment.payment_BA2.city">
                        <p>Postal Code</p>
                        <input type="number" class="input-bank" ng-model="payment.payment_BA2.postal_code">
                        <p>Bank Name</p>
                        <input type="text" class="input-bank" ng-model="payment.payment_BA2.bank_name">
                        <p>Bank Account Number (Philippine Peso only)</p>
                        <input type="number" class="input-bank" ng-model="payment.payment_BA2.bank_number">
                        <p>Recipient's local phone number</p>
                        <input type="number" class="input-bank" ng-model="payment.payment_BA2.local_phone">
                        <p>The bank account above is under your own name or the name of your relative/friend?</p>
                        <select class="select" ng-model="payment.payment_BA2.account_owner">
                            <option value="1" selected> It is under the name of my relative/friend</option>
                            <option value="0">asgasfasdf</option>
                        </select>
                    </div>
                </div>

                <div class="bank {{ payment.class.payment_BA3.active }} {{ payment.class.payment_BA3.showbank }}">
                    <input type="hidden" id="bank-account-check" ng-model="payment.payment_BA3.check">
                    <div class="title">
                        <input id="bank_account-group" name="bank_account-group" type="checkbox" class="checkbox-bank">
                        <label for="bank_account-group" ng-click="showBank('payment_BA3')">
                            <span>
                                Bank account
                            </span>
                        </label>
                    </div>
                    <div class="information-input">
                        <p>Account holder's full name</p>
                        <input type="text" class="input-bank" ng-model="payment.payment_BA3.name_account">
                        <p>Address</p>
                        <input type="text" class="input-bank" ng-model="payment.payment_BA3.address">
                        <p>City</p>
                        <input type="text" class="input-bank" ng-model="payment.payment_BA3.city">
                        <p>Country</p>
                        <input type="text" class="input-bank" ng-model="payment.payment_BA3.country">
                        <p>Recipient's local phone number</p>
                        <input type="number" class="input-bank" ng-model="payment.payment_BA3.local_phone">
                        <p>Bank Name</p>
                        <input type="text" class="input-bank" ng-model="payment.payment_BA3.bank_name">
                        <p>
                            Bank's SWIFT/BIC Code
                            <span class="option-span">(optional)</span>
                        </p>
                        <input type="number" class="input-bank" ng-model="payment.payment_BA3.bank_code">
                        <p>
                            Local Clearing Code (e.g. Sort Code, BSB, etc.)
                            <span class="option-span">(optional)</span>
                        </p>
                        <input type="number" class="input-bank" ng-model="payment.payment_BA3.local_code">
                        <p>Bank Account Number / IBAN Number</p>
                        <p>
                            <i>
                                (for SEPA countries in Europe, please provide a bank account that can receive EUR currency; for all other countries in the world, please provide a bank account in your LOCAL currency)
                            </i>
                        </p>
                        <input type="number" class="input-bank" ng-model="payment.payment_BA3.bank_number">
                        <p>Other information (if any) <span class="option-span">(optional)</span></p>
                        <input type="text" class="input-bank" ng-model="payment.payment_BA3.orther_info">
                        <p>The bank account above is under your own name or the name of your relative/friend?</p>
                        <select class="select" ng-model="payment.payment_BA3.account_owner">
                            <option value="1" selected> It is under the name of my relative/friend</option>
                            <option value="0">It isn't under the name of my relative/friend</option>
                        </select>
                    </div>
                </div>
                <div class="bank {{ payment.class.payment_PP.active }} {{ payment.class.payment_PP.showbank }}">
                    <input type="hidden" id="bank-paypal-check" value="{{ payment.payment_PP.check }}">
                    <div class="title">
                        <input id="paypal-group" name="paypal-group" type="checkbox" class="checkbox-bank">
                        <label for="paypal-group" ng-click="showBank('payment_PP')">
                            <span>
                                PayPal
                            </span>
                        </label>
                        <a href="https://www.paypal.com/" class="float-right bank_information" target="_blank">
                            Paypal.com
                        </a>
                    </div>
                    <div class="information-input">
                        <p>Your PayPal's email address</p>
                        <input type="email" class="input-bank" ng-model="payment.payment_PP.email">
                        <p>Recipient's full name</p>
                        <input type="text" class="input-bank" ng-model="payment.payment_PP.name_account">
                        <p>Recipient's country of residence</p>
                        <select class="select" ng-model="payment.payment_PP.country">
                            <option value="" disabled selected style="display: none;" href="">
                                Choose place of residence
                            </option>
                            <option ng-repeat="(key, value) in national" value="{{ key }}" href="{{ value.group }}">{{ value.name }}</option>
                        </select>
                    </div>
                </div>

                <div class="bank {{ payment.class.payment_SK.active }} {{ payment.class.payment_SK.showbank }}" >
                    <input type="hidden" id="bank-skrill-check" value="{{ payment.payment_SK.check }}">
                    <div class="title">
                        <input id="skrill-group" type="checkbox" class="checkbox-bank">
                        <label for="skrill-group" ng-click="showBank('payment_SK')">
                            <span>
                                Skrill
                            </span>
                        </label>
                        <a href="https://www.skrill.com" class="float-right bank_information" target="_blank">
                            Skrill.com
                        </a>
                    </div>
                    <div class="information-input">
                        <p>Your Skrill's email address</p>
                        <input type="email" class="input-bank" ng-model="payment.payment_SK.email">
                        <p>Recipient's full name</p>
                        <input type="text" class="input-bank" ng-model="payment.payment_SK.name_account">
                        <p>Recipient's country of residence</p>
                        <select class="select">
                            <option value="" disabled selected style="display: none;" href="">
                                Choose place of residence
                            </option>
                            <option ng-repeat="(key, value) in national" value="{{ key }}" href="{{ value.group }}">{{ value.name }}</option>
                        </select>
                    </div>
                </div>

                <div class="bank {{ payment.class.payment_PO.active }} {{ payment.class.payment_PO.showbank }}">
                    <input type="hidden" id="bank-payoneer-check" ng-model="payment.payment_PO.check">
                    <div class="title">
                        <input id="payoneer-group" name="payoneer-group" type="checkbox" class="checkbox-bank">
                        <label for="payoneer-group" ng-click="showBank('payment_PO')">
                            <span>
                                Payoneer
                            </span>
                        </label>
                        <a href="https://www.payoneer.com/" class="float-right bank_information" target="_blank">
                            Payoneer.com
                        </a>
                    </div>
                    <div class="information-input">
                        <p>Your Payoneer's email address</p>
                        <input type="email" class="input-bank" ng-model="payment.payment_PO.email">
                        <p>Recipient's full name</p>
                        <input type="text" class="input-bank" ng-model="payment.payment_PO.name_account">
                        <p>Recipient's country of residence</p>
                        <select class="select">
                            <option value="" disabled selected style="display: none;" href="">
                                Choose place of residence
                            </option>
                            <option ng-repeat="(key, value) in national" value="{{ key }}" href="{{ value.group }}">{{ value.name }}</option>
                        </select>
                    </div>
                </div>

                <div class="bank {{ payment.class.payment_OPM.active }} {{ payment.class.payment_OPM.showbank }}">
                    <input type="hidden" id="bank-other-check" ng-model="payment.payment_OPM.check">
                    <div class="title">
                        <input id="other-payment-group" name="other-payment-group" type="checkbox" class="checkbox-bank">
                        <label for="other-payment-group" ng-click="showBank('payment_OPM')">
                            <span>
                                Other payment methods
                            </span>
                        </label>
                    </div>

                    <div class="information-input">
                        <p>
                            <i>
                                We are willing to consider other payment methods as well (so if you have any suggestions, please type in the box below). But please note that, due to regulatory issues, Antoree can NOT send payment via Western Union or MoneyGram.
                            </i>
                        </p>
                        <textarea id="other-method" rows="5" class="textarea-bank" ng-model="payment.payment_OPM.orther_pay_method"></textarea>
                    </div>
                </div>
            </div>

            <div class="button">
                <input type="submit" value="SUBMIT" class="submit-btn" ng-click="save()">
            </div>
        </form>
    </div>
</div>