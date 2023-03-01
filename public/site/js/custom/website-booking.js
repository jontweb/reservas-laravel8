(function ($) {
    "use strict";
    var initTelephone;
    var serviceStepar;
    var isBookingSuccess = false;
    $(document).ready(function () {
        serviceStepar = $("#serviceStep").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            autoFocus: true,
            onStepChanging: function (event, currentIndex, newIndex) {
                if (currentIndex > newIndex)
                    return true;
                var branch = $("#cmn_branch_id");
                var categoryId = $("#sch_service_category_id");
                var serviceId = $("#sch_service_id");
                var employeeId = $("#sch_employee_id");
                var serviceTime = $("input[name='service_time']");
                if (currentIndex == 0) {
                    if (!branch.val()) {
                        branch.addClass('border-red');
                    }
                    else if (!categoryId.val()) {
                        categoryId.addClass('border-red');
                    }
                    else if (!serviceId.val()) {
                        serviceId.addClass('border-red');
                    }
                    else if (!employeeId.val()) {
                        employeeId.addClass('border-red');
                    } else if (serviceTime.length < 1 || typeof $("input[name='service_time']:checked").val() == 'undefined') {
                        Message.Warning("Select service time.");
                        $(".divTimeSlot").addClass('border-red');
                    } else {
                        SiteManager.GetCustomerLoginInfo();
                        return true;
                    }
                } else if (currentIndex == 1) {
                    var fullName = $("#full_name");
                    var email = $("#email");
                    var phone = $("#phone_no");
                    if (!fullName.val()) {
                        fullName.addClass('border-red');
                    }
                    else if (!isValidEmail(email.val())) {
                        email.addClass('border-red');
                    }
                    else if (!phone.val()) {
                        phone.addClass('border-red');
                    } else {
                        return true;
                    }
                }
                else if (currentIndex == 2) {
                    if (isBookingSuccess == false) {
                        SiteManager.SaveBooking();
                    } else {
                        return true;
                    }

                } else if (currentIndex == 3) {
                    return true;
                }

            },
            onFinished: function (event, currentIndex) {
                window.location = JsManager.BaseUrl() + "/client-dashboard";
            }
            ,
            labels: {
                loading: "Loading ..."
            }
        });

        $(".form-control").on("click", function () {
            $(this).removeClass('border-red');
        });


        SiteManager.LoadBranchDropDown();
        SiteManager.LoadServiceCategoryDropDown();
        SiteManager.PaymentType();

        $("#sch_service_category_id").on("change", function () {
            SiteManager.LoadServiceDropDown($(this).val());
        });

        $("#sch_service_id").on("change", function () {
            SiteManager.LoadEmployeeDropDown($(this).val());
        });

        $("#iNextDate").on("click", function () {
            $('#divServiceDate').datetimepicker('destroy');
            var nextDate = moment($('#serviceDate').val(), 'Y-M-D').add(1, 'days');
            SiteManager.ServiceDatePicker(nextDate);
        });
        $("#iPrvDate").on("click", function () {

            var nextDate = moment($('#serviceDate').val(), 'Y-M-D').subtract(1, 'days');
            if (nextDate >= moment(moment(new Date()).format('Y-M-D'), 'Y-M-D')) {
                $('#divServiceDate').datetimepicker('destroy');
                SiteManager.ServiceDatePicker(nextDate);
            }
        });

        $(".serviceInput").on("change", function () {
            let selectedPropId = $(this).attr('id');
            if (selectedPropId == "cmn_branch_id") {
                $("#sch_employee_id").val('');
                $("#sch_service_category_id").val('');
                $("#sch_service_id").val('');
            }
            else if (selectedPropId == "sch_service_category_id") {
                $("#sch_employee_id").val('');
                $("#sch_service_id").val('');
            } else if (selectedPropId == "sch_service_id") {
                $("#sch_employee_id").val('');
                SiteManager.LoadServiceTimeSlot($(this).val(), $("#sch_employee_id").val());
            } else if (selectedPropId == "sch_employee_id") {
                SiteManager.LoadServiceTimeSlot($("#sch_service_id").val(), $(this).val());
            }
        });

        $(".iChangeDate").on("click", function () {
            SiteManager.LoadServiceTimeSlot($("#sch_service_id").val(), $("#sch_employee_id").val());
        });

        initTelephone = window.intlTelInput(document.querySelector("#phone_no"), {
            allowDropdown: true,
            autoHideDialCode: false,
            dropdownContainer: document.body,
            excludeCountries: [],
            formatOnDisplay: false,
            geoIpLookup: function (callback) {
                var jsonParam = '';
                var serviceUrl = "get-requested-country-code";
                JsManager.SendJson('GET', serviceUrl, jsonParam, onSuccess, onFailed);

                function onSuccess(jsonData) {
                    if (jsonData.status == 1) {
                        callback(jsonData.data);
                    } else {
                        callback("US");
                    }
                }
                function onFailed(xhr, status, err) {
                }
            },
            hiddenInput: "full_number",
            initialCountry: "auto",
            nationalMode: true,
            placeholderNumberType: "MOBILE",
            separateDialCode: true,
            utilsScript: "js/lib/tel-input/js/utils.js",
        });
        var date = new Date();
        SiteManager.ServiceDatePicker(date);
    });


    $(document).on('click', ".payment-chose-div", function () {
        $(this).find('input').prop('checked', true);
        $(".payment-chose-div").removeClass('payment-chose');
        $(this).addClass('payment-chose');
    });

    $(document).on("click", ".divTimeSlot", function () {
        $(".divTimeSlot").removeClass('border-red');
    });

    $(document).on("click", ".divTimeSlot", function () {
        $(this).find('input').prop('checked', true);
        $('.divTimeSlot').removeClass('divTimeSlotActive');
        $(this).addClass('divTimeSlotActive');
        SiteManager.SetServiceProperty($("#serviceDate").val(), $(this).find('.divStartTime').text());
    });

    var SiteManager = {
        PaymentType: function () {
            var jsonParam = '';
            var serviceUrl = "get-site-payment-type";
            JsManager.SendJson('GET', serviceUrl, jsonParam, onSuccess, onFailed);

            function onSuccess(jsonData) {
                $("#divPaymentType").empty();
                if (jsonData.status == 1) {
                    $.each(jsonData.data, function (i, v) {
                        let typeIcon = '<i class="fas fa-money-bill-alt float-start m-1 fa-2x"></i>';
                        let checkStatus = false;
                        if (v.type == 2) {
                            typeIcon = '<i class="fab fa-cc-paypal float-start m-1 fa-2x"></i>';
                            checkStatus = true;
                        }else if(v.type==3){
                            typeIcon = '<i class="fab fa-cc-stripe float-start m-1 fa-2x"></i>';
                        }

                        $("#divPaymentType").append('<div class="col-md-10 offset-md-2 mt-2">' +
                            '<div class="payment-chose-div">' +
                            '<input checked=' + checkStatus + ' type="radio" name="payment_type" id="payment_type" value="' + v.id + '" class="float-start payment-radio d-none" />' +
                            typeIcon +
                            '<div class="float-start color-black p-2">' + v.name + '</div>' +
                            '</div>' +
                            '</div>');

                    });
                }
            }
            function onFailed(xhr, status, err) {
                Message.Exception(xhr);
            }
        },
        ServiceDatePicker: function (startDate) {
            $('#divServiceDate').datetimepicker({
                format: 'Y-m-d',
                inline: true,
                timepicker: false,
                minDate: new Date(),
                startDate: startDate._d,
                onChangeDateTime: function (dp, $input) {
                    $("#serviceDate").val($input.val());
                    SiteManager.SetServiceProperty($input.val());
                    SiteManager.LoadServiceTimeSlot($("#sch_service_id").val(), $("#sch_employee_id").val())
                }
            });
            SiteManager.SetServiceProperty(startDate);
        },
        SetServiceProperty: function (startDate, time) {
            let longDate = moment(startDate).format('dddd, MMMM, DD, yyyy');
            $("#serviceDate").val(JsManager.DateFormatDefault(startDate));
            $("#divDaysName").text(longDate);
            if (time) {
                $("#iSelectedServiceText").text("You've Selected " + time + " On " + longDate);
            } else {
                $("#iSelectedServiceText").text("You've Selected " + longDate);
            }
        },
        LoadServiceCategoryDropDown: function () {
            var jsonParam = '';
            var serviceUrl = "get-site-service-category";
            JsManager.SendJson('GET', serviceUrl, jsonParam, onSuccess, onFailed);

            function onSuccess(jsonData) {
                JsManager.PopulateCombo("#sch_service_category_id", jsonData.data, "Select One", '');
            }
            function onFailed(xhr, status, err) {
                Message.Exception(xhr);
            }
        },
        LoadServiceDropDown: function (categoryId) {
            var jsonParam = { sch_service_category_id: categoryId };
            var serviceUrl = "get-site-service";
            JsManager.SendJson('GET', serviceUrl, jsonParam, onSuccess, onFailed);

            function onSuccess(jsonData) {
                JsManager.PopulateCombo("#sch_service_id", jsonData.data, "Select One", '');
            }
            function onFailed(xhr, status, err) {
                Message.Exception(xhr);
            }
        },
        LoadBranchDropDown: function () {
            var jsonParam = '';
            var serviceUrl = "get-site-branch";
            JsManager.SendJson('GET', serviceUrl, jsonParam, onSuccess, onFailed);

            function onSuccess(jsonData) {
                JsManager.PopulateCombo("#cmn_branch_id", jsonData.data);
            }
            function onFailed(xhr, status, err) {
                Message.Exception(xhr);
            }
        },
        LoadEmployeeDropDown: function (serviceId) {
            var jsonParam = { sch_service_id: serviceId, cmn_branch_id: $("#cmn_branch_id").val() };
            var serviceUrl = "get-site-employee-service";
            JsManager.SendJson('GET', serviceUrl, jsonParam, onSuccess, onFailed);

            function onSuccess(jsonData) {
                JsManager.PopulateCombo("#sch_employee_id", jsonData.data, "Select One", '');
            }
            function onFailed(xhr, status, err) {
                Message.Exception(xhr);
            }
        },
        LoadServiceTimeSlot: function (serviceId, employeeId) {
            if (employeeId > 0 && serviceId > 0 && $("#serviceDate").val() && $("#cmn_branch_id").val() > 0) {
                JsManager.StartProcessBar();
                var jsonParam = {
                    sch_service_id: serviceId,
                    sch_employee_id: employeeId,
                    date: $("#serviceDate").val(),
                    cmn_branch_id: $("#cmn_branch_id").val()
                };
                var serviceUrl = "get-site-service-time-slot";
                JsManager.SendJson('GET', serviceUrl, jsonParam, onSuccess, onFailed);
                function onSuccess(jsonData) {
                    if (jsonData.status == 1) {
                        $("#divServiceAvaiableTime").empty();
                        $.each(jsonData.data, function (i, v) {
                            let disabledClass = "";
                            let disabledServiceText = "";
                            if (v.is_avaiable == 0) {
                                disabledClass = "disabled-service";
                                disabledServiceText = "disabled-service-text";
                            }
                            let serviceTime = v.start_time + '-' + v.end_time;
                            $("#divServiceAvaiableTime").append(
                                '<div class="divTimeSlot ' + disabledClass + '" title="' + serviceTime + '">' +
                                '<div class="float-start w-100">' +
                                '<div class="float-start">' +
                                '<input type="radio" class="serviceTime d-none" name="service_time" value="' + serviceTime + '"/>' +
                                '</div>' +
                                '<div class="float-start cp divStartTime text-center w-100 ' + disabledServiceText + '">' + moment('1990-01-01 ' + v.start_time).format('hh:mm A') + '</div>' +
                                '</div>' +
                                '</div>');
                        });
                    }
                    JsManager.EndProcessBar();
                }
                function onFailed(xhr, status, err) {
                    if (xhr.responseJSON.status == 5) {
                        $("#divServiceAvaiableTime").empty();
                        $("#divServiceAvaiableTime").append('<div class="mt-3">' + xhr.responseJSON.data + '</div>');
                    } else if (xhr.responseJSON.status == 2) {
                        //service is not available today
                    } else {
                        Message.Exception(xhr);
                    }
                    JsManager.EndProcessBar();
                }
            } else {
                $("#divServiceAvaiableTime").empty();
            }
        },
        SaveBooking: function () {
            return new Promise(function (resolve, reject) {
                if (Message.Prompt()) {
                    JsManager.StartProcessBar();
                    var jsonParam = $("#formServiceBooking").serialize() + "&phone_no=" + initTelephone.getNumber();
                    var serviceUrl = "save-site-service-booking";
                    JsManager.SendJson("POST", serviceUrl, jsonParam, onSuccess, onFailed);

                    function onSuccess(jsonData) {
                        if (jsonData.status == "1") {
                            Message.Success("save");
                            isBookingSuccess = true;
                            if (jsonData.paymentType == "paypal") {
                                if (jsonData.data.returnUrl.status = 201) {
                                    window.location.href = jsonData.data.returnUrl.data.links[1].href;
                                } else {
                                    //order will be cancel by redirect
                                    SiteManager.CancelBooking(jsonData.data.returnUrl.purchase_units[0].reference_id)
                                }
                            }
                            if (jsonData.paymentType == "stripe") {
                                    window.location.href = jsonData.data.returnUrl.redirectUrl;                                
                            }
                            else {
                                //local payment done
                                serviceStepar.steps("next");
                                isBookingSuccess = false;
                            }
                            JsManager.EndProcessBar();
                        } else {
                            Message.Error("save");
                            JsManager.EndProcessBar();
                        }
                        JsManager.EndProcessBar();
                    }

                    function onFailed(xhr, status, err) {
                        JsManager.EndProcessBar();
                        Message.Exception(xhr);
                    }
                    isBookingSuccess = false;
                }
            });
        },

        CancelBooking: function (bookingId) {
            if (Message.Prompt()) {
                JsManager.StartProcessBar();
                var jsonParam = { serviceBookingId: bookingId };
                var serviceUrl = "site-cancel-booking";
                JsManager.SendJson("POST", serviceUrl, jsonParam, onSuccess, onFailed);

                function onSuccess(jsonData) {
                    if (jsonData.status == "1") {
                        Message.Success("Cancel Successfully");
                    } else {
                        Message.Error("save");
                    }
                    JsManager.EndProcessBar();
                }

                function onFailed(xhr, status, err) {
                    JsManager.EndProcessBar();
                    Message.Exception(xhr);
                    return false;
                }
            }
        },

        GetCustomerLoginInfo: function () {
            JsManager.StartProcessBar();
            var jsonParam = '';
            var serviceUrl = "get-site-login-customer-info";
            JsManager.SendJson("POST", serviceUrl, jsonParam, onSuccess, onFailed);

            function onSuccess(jsonData) {
                if (jsonData.status == "1") {
                    let data = jsonData.data;
                    if (data.full_name)
                        $("#full_name").val(data.full_name).attr('readonly', true);
                    if (data.email)
                        $("#email").val(data.email).attr('readonly', true);
                    initTelephone.setNumber(data.phone_no);
                    if (data.state)
                        $("#state").val(data.state).attr('readonly', true);
                    if (data.city)
                        $("#city").val(data.city).attr('readonly', true);
                    if (data.postal_code)
                        $("#postal_code").val(data.postal_code).attr('readonly', true);
                    if (data.street_address)
                        $("#street_address").val(data.street_address).attr('readonly', true);
                    if (data.street_address)
                        $("#street_address").val(data.street_address).attr('readonly', true);
                }
                JsManager.EndProcessBar();
            }

            function onFailed(xhr, status, err) {
                JsManager.EndProcessBar();
                Message.Exception(xhr);
            }

        },
    };
})(jQuery);