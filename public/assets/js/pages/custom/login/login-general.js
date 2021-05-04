"use strict";

// Class Definition
var KTLogin = function () {
    var _login;


    var _handleSignInForm = function () {
        var validation;

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validation = FormValidation.formValidation(

            KTUtil.getById('kt_login_signin_form'), {
                fields: {
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Username/Email is required'
                            },
                            emailAddress: {
                                message: 'The value is not a valid email address'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Password is required'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        );

    }



    // Public Functions
    return {
        // public functions
        init: function () {
            _handleSignInForm();

        }
    };
}();

// Class Initialization
jQuery(document).ready(function () {
    KTLogin.init();

});
