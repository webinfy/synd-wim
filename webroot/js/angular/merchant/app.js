var app = angular
        .module('merchantApp', ['ui.router', 'oc.lazyLoad', 'ngFileUpload'])
        .config(function ($stateProvider, $urlRouterProvider) {
            $urlRouterProvider.otherwise('/dashboard');
            $stateProvider
                    .state('dashboard', {
                        url: '/dashboard',
                        title: 'Dashboard',
                        controller: 'DashboardCtrl',
                        templateUrl: 'views/merchant/dashboard.html'
                    })
                    .state('basic-web-front-creation', {
                        url: '/basic-web-front-creation',
                        title: 'Basic Web Front Creation',
                        controller: 'WebFrontCtrl',
                        templateUrl: 'views/merchant/basic-web-front-creation.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'datepicker',
                                            files: ['components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', 'components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css']
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('edit-basic-web-front', {
                        url: '/edit-basic-web-front/:id?tab&name&title',
                        title: 'Edit Basic Web Front',
                        controller: 'WebFrontCtrl',
                        templateUrl: 'views/merchant/edit-basic-web-front.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'datepicker',
                                            files: ['components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', 'components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css']
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('webfront-listing', {
                        url: '/webfront-listing',
                        title: 'Webfront Listing',
                        controller: 'WebFrontCtrl',
                        templateUrl: 'views/merchant/webfront-listing.html'
                    })
                    //Advance Webfront Router Section starts here
                    .state('advance-web-front-creation', {
                        url: '/advance-web-front-creation',
                        title: 'Advance Web Front Creation',
                        controller: 'WebFrontCtrl',
                        templateUrl: 'views/merchant/advance-web-front-creation.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'datepicker',
                                            files: ['components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', 'components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css']
                                        },
                                        {
                                            name: 'cropit',
                                            files: ['js/jquery.cropit.js']
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('advance-webfront-listing', {
                        url: '/advance-webfront-listing',
                        title: 'Advance Webfront Listing',
                        controller: 'WebFrontCtrl',
                        templateUrl: 'views/merchant/advance-webfront-listing.html'
                    })
                    .state('edit-advance-web-front', {
                        url: '/edit-advance-web-front/:id/:advance?tab&name&title',
                        title: 'Edit Advance Web Front',
                        controller: 'WebFrontCtrl',
                        templateUrl: 'views/merchant/edit-advance-web-front.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'datepicker',
                                            files: ['components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', 'components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css']
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('advance-view-payments', {
                        url: '/advance-view-payments/:id?title',
                        title: 'View Payments',
                        controller: 'PaymentsCtrl',
                        templateUrl: 'views/merchant/advance-view-payments.html'
                    })
                    //Advance Webfront Router Section ends here
                    .state('view-uploads', {
                        url: '/view-uploads/:id?tab',
                        title: 'View Payments',
                        controller: 'PaymentsCtrl',
                        templateUrl: 'views/merchant/view-uploads.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'fileinput',
                                            files: ['assets/js/src/elements.fileinput.js']
                                        },
                                        {
                                            name: 'datepicker',
                                            files: ['components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js']
                                        },
                                        {
                                            name: 'merchantApp',
                                            insertBefore: '#main-ace-style',
                                            files: [
                                                'components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css'
                                            ]
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('view-payments', {
                        url: '/view-payments/:id?title',
                        title: 'View Payments',
                        controller: 'PaymentsCtrl',
                        templateUrl: 'views/merchant/view-payments.html'
                    })
                    .state('profile-setting', {
                        url: '/profile-setting',
                        title: 'Profile Setting',
                        controller: 'ProfileCtrl',
                        templateUrl: 'views/merchant/profile-setting.html'
                    })
                    .state('change-password', {
                        url: '/change-password',
                        title: 'Change Password',
                        controller: 'ProfileCtrl',
                        templateUrl: 'views/merchant/change-password.html'
                    })
                    .state('import-payments', {
                        url: '/import-payments/:id?title',
                        title: 'Import Payments',
                        controller: 'ImportPaymentsCtrl',
                        templateUrl: 'views/merchant/import-payments.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'fileinput',
                                            files: ['assets/js/src/elements.fileinput.js']
                                        },
                                        {
                                            name: 'datepicker',
                                            files: ['components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js']
                                        },
                                        {
                                            name: 'merchantApp',
                                            insertBefore: '#main-ace-style',
                                            files: [
                                                'components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css'
                                            ]
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('update-excel', {
                        url: '/update-excel/:id',
                        title: 'Update Excel',
                        controller: 'PaymentsCtrl',
                        templateUrl: 'views/merchant/update-excel.html',
                        resolve: {
                            lazyLoad: ['$ocLazyLoad', function ($ocLazyLoad) {
                                    return $ocLazyLoad.load([
                                        {
                                            name: 'fileinput',
                                            files: ['assets/js/src/elements.fileinput.js']
                                        }
                                    ]);
                                }]
                        }
                    })
                    .state('add-new-user', {
                        url: '/add-new-user',
                        title: 'Add New User',
                        controller: 'UserCtrl',
                        templateUrl: 'views/merchant/add-new-user.html'
                    })
                    .state('edit-new-user', {
                        url: '/edit-new-user/:id',
                        title: 'Edit New User',
                        controller: 'UserCtrl',
                        templateUrl: 'views/merchant/edit-new-user.html'
                    })
                    .state('view-all-user', {
                        url: '/view-all-user',
                        title: 'View All User',
                        controller: 'UserCtrl',
                        templateUrl: 'views/merchant/view-all-user.html'
                    })
                    .state('reports', {
                        url: '/reports',
                        title: 'Reports',
                        controller: 'ReportsCtrl',
                        templateUrl: 'views/merchant/reports.html'
                    })
                    .state('view-uploaded-files', {
                        url: '/view-uploaded-files/:id?',
                        title: 'ViewUuploadedFiles',
                        controller: 'ReportsCtrl',
                        templateUrl: 'views/merchant/view-uploaded-files.html'
                    })
                    .state('advance-webfront-payments', {
                        url: '/advance-webfront-payments/:id',
                        title: 'Advance Webfront payments',
                        controller: 'AdvancePaymentsCtrl',
                        templateUrl: 'views/merchant/advance-webfront-payments.html'
                    })

        })
        .run(['$rootScope', '$location', '$state', function ($rootScope, $location, $state) {

                $rootScope.siteUrl = siteUrl;
                $rootScope.$state = $state;
                $rootScope.$on("$stateChangeStart", function (event, toState, toParams, fromState, fromParams) {

                    $("#ui-view").html("");
                    $(".page-loading").removeClass("hidden");

                    $rootScope.authenticated = false;
                    var json = (function () {
                        $.ajax({
                            type: 'GET',
                            async: false,
                            global: false,
                            url: 'users/ajaxCheckLogin',
                            dataType: "json",
                            success: function (response) {
                                if (response.status == 'loggedin') {
                                    $rootScope.authenticated = true;
                                    $rootScope.userSession = response.user;
                                } else {
                                    window.location = siteUrl;
                                }
                            }
                        });
                    })();
                });
                $rootScope.$on('$stateChangeSuccess', function (event, toState, toParams, fromState, fromParams) {
                    $(".page-loading").addClass("hidden");
                });

                $rootScope.success = function (msg) {
                    $html = "";
                    $html += '<div style="display: block;" id="success-msg" class="alert alert-info">';
                    $html += '<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>';
                    $html += '<p><i class="ace-icon fa fa-check"></i>&nbsp;' + msg + '</p>';
                    $html += '</div>';
                    $('#flash-msg').html($html).show().focus();//.delay(8000).fadeOut();
                    $("html, body").animate({scrollTop: 0}, "slow");
                };

                $rootScope.error = function (msg) {
                    $html = "";
                    $html += '<div style="display: block;" id="success-msg" class="alert alert-danger">';
                    $html += '<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>';
                    $html += ' <p><i class="ace-icon fa fa-times"></i>&nbsp;' + msg + '</p>';
                    $html += '</div>';
                    $('#flash-msg').html($html).show().focus();//.delay(8000).fadeOut();
                    $("html, body").animate({scrollTop: 0}, "slow");
                };

                $rootScope.validatePwd = function (value) {
                    if (value) {
                        console.log(value);
                        var pattern = /\d{3}/;
                        if (pattern.test(value)) {
                            $('#pwdValNum').show();
                        } else {
                            $('#pwdValNum').hide();
                        }
                    }
                };

            }]);
//////////////////////////////////Controller Code/////////////////////////////
//*********************Web Front Controller Code Starts here by Prakash*****************************
app.controller('WebFrontCtrl', function ($scope, $http, $timeout, $compile, $window, $stateParams, $state, $rootScope, Upload) {

    if ($('.image-editor').length) {
        $('.image-editor').cropit();
    }

    $scope.cropitStart = function (value) {
        if ($('.image-editor').length) {
//            $('.image-editor').cropit();
        }
    }
    $scope.autoFillMerchantData = function (value) {
        $http.get(siteUrl + "merchant/webfronts/ajaxGetMerchantData").then(function (response) {
            console.log(response.data.merchant);
            $scope.webfront = response.data.webfront;
        });
    }

    $scope.checkUrlAvail = function (value) {
        if (value) {
            $http.get(siteUrl + "merchant/webfronts/ajaxNameAvail?name=" + value).then(function (response) {
                if (response.data.status == 'success') {
                    if (response.data.avail == 1) {
                        $('#name-avail').text('Name available!!').css({'color': 'green'}).show();
                    } else if (response.data.avail == 0) {
                        $('#name-avail').text('Name not available!!').css({'color': 'red'}).show();
                    }
                }
            });
        }
    };

    $scope.createWebfront = function (file) {
        $scope.formUpload = true;
//        if (file != null) {
//            file.upload = Upload.upload({
//                url: siteUrl + "merchant/webfronts/create" + $scope.getReqParams(),
//                data: {webfront: $scope.webfront, file: file}
//            });
//            file.upload.then(function (response) {
//                var data = response.data;
//                if (data.status == 'success') {
//                    $rootScope.success('Webfront created successfully!!');
//                    setTimeout(function () {
//                        $window.location.href = siteUrl + 'merchant/#/edit-basic-web-front/' + data.webfront.id + '?tab=payee-information';
//                    }, 2000);
//                } else {
//                    $rootScope.error(data.msg);
//                }
//            });
//        } else {
        var imageData = $('.image-editor').cropit('export');
//            $('.hidden-image-data').val(imageData);
        $http.post(siteUrl + "merchant/webfronts/create", {webfront: $scope.webfront, croppedImage: imageData}).then(function (response) {
            var data = response.data;
            if (data.status == 'success') {
                $rootScope.success('Webfront created successfully!!');
                setTimeout(function () {
                    $window.location.href = siteUrl + 'merchant/#/edit-basic-web-front/' + data.webfront.id + '?tab=payee-information';
                }, 2000);
            } else {
                $rootScope.error(data.msg);
            }
        });
//        }
    };

    $scope.editWebfront = function (file) {

//        $scope.formUpload = true;
//        if (file != null) {
//            $(".page-loading").removeClass("hidden");
//            file.upload = Upload.upload({
//                url: siteUrl + "merchant/webfronts/edit" + $scope.getReqParams(),
//                data: {webfront: $scope.webfront, file: file}
//            });
//            file.upload.then(function (response) {
//                var data = response.data;
//                $(".page-loading").addClass("hidden");
//                if (data.status == 'success') {
//                    $rootScope.success('Webfront details updated successfully!!');
//                    $scope.webfront = response.data.webfront;
//                    console.log(response);
////                    setTimeout(function () {
//                    //$state.reload();
//                    $('a[href=\'#payee-information\']').click();
////                    }, 2000);                    
//                } else {
//                    $rootScope.error('Some error occured.Please try again!!');
//                }
//            });
//        } else {
        $(".page-loading").removeClass("hidden");
        var imageData = $('.image-editor').cropit('export');
        $http.post(siteUrl + "merchant/webfronts/edit", {webfront: $scope.webfront, croppedImage: imageData}).then(function (response) {
            $(".page-loading").addClass("hidden");
            if (response.data.status == 'success') {
                $scope.webfront = response.data.webfront;
                $('a[href=\'#payee-information\']').click();
                $rootScope.success('Webfront details updated successfully!!');
                if (response.data.webfront.logo != '') {
                    $('#logo .img-logo').attr('src', 'files/webfront_logo/' + response.data.webfront.logo);
                }
                $('.cropit-preview-image').attr('src', '');
                $('.cropit-image-input').val('');
                //$state.reload();               
            } else {
                $rootScope.error('Some error occured.Please try again!!');
            }
        });
//        }
    };

    $scope.myWebfronts = function () {
        $http.get(siteUrl + "merchant/webfronts/ajaxMyBasicWebfronts").then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfronts = response.data.webfronts;
            }
        });
    };

    $scope.deleteWebfront = function (id) {
        confirm("Are you sure you want to delete ? ", function (data) {
            if (data) {
                $http.post(siteUrl + "merchant/webfronts/delete/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $('#webfront-' + id).remove();
                        $rootScope.success('Webfront deleted successfully!!');
                    } else {
                        $rootScope.error('Some Error occured. Please try again!!');
                    }
                });
            }
        }, {return: true});
    };

    $scope.publishWebfront = function (id) {
        confirm("Are you sure you want to Publish ? ", function (data) {
            if (data) {
                $http.post(siteUrl + "merchant/webfronts/publish/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $rootScope.success(response.data.msg);
                        $scope.webfronts = response.data.webfronts;
                    } else {
                        $rootScope.error('Some Error occured. Please try again!!');
                    }
                });
            }
        }, {return: true});
    };

    $scope.unPublishWebfront = function (id) {
        confirm("Are you sure you want to Unpublish ? ", function (data) {
            if (data) {
                $http.post(siteUrl + "merchant/webfronts/unpublish/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $rootScope.success(response.data.msg);
                        $scope.webfronts = response.data.webfronts;
                    } else {
                        $rootScope.error('Some Error occured. Please try again!!');
                    }
                });
            }
        }, {return: true});
    };

    $scope.editCustomerFields = function () {
        $http.post(siteUrl + "merchant/webfronts/ajaxUpdatePayeeFields", {webfront: $scope.webfront, customer_fields: $scope.customer_fields}).then(function (response) {
            if (response.data.status == 'success') {
                $rootScope.success('Customer Fields updated successfully!!');
                $scope.webfront = response.data.webfront;
                $('a[href=\'#payment-information\']').click();
            } else {
                $rootScope.error('Some error occured.Please try again!!');
            }
        });
    };


    $scope.editPaymentFields = function () {
        $http.post(siteUrl + "merchant/webfronts/ajaxUpdatePaymentFields", {webfront: $scope.webfront, payment_fields: $scope.payment_fields}).then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfront = response.data.webfront;
                $rootScope.success('Payment Fields updated successfully!!');
                $('a[href=\'#download-excel\']').click();
            } else {
                $rootScope.error('Some error occured.Please try again!!');
            }
        });
    };

    $scope.getReqParams = function () {
        return $scope.generateErrorOnServer ? '?errorCode=' + $scope.serverErrorCode + '&errorMessage=' + $scope.serverErrorMsg : '';
    };

    if ($stateParams['id'] != 'undefined' && $stateParams['id'] > 0 && !$stateParams['advance']) {
        var id = $stateParams['id'];
        $http.get(siteUrl + "merchant/webfronts/ajaxGetDetails/" + id).then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfront = response.data.webfront;
                if (response.data.webfront.customer_fields.length) {
                    var customer_fields = response.data.webfront.customer_fields;
                    for (var i = 0; i < customer_fields.length; i++) {
                        var filedNo = parseInt(i) + 1;
                        $('#ca' + filedNo + '_chk').trigger('click');
                        if (filedNo == 1)
                            $scope.customer_fields.ca1 = customer_fields[i].name;
                        if (filedNo == 2)
                            $scope.customer_fields.ca2 = customer_fields[i].name;
                        if (filedNo == 3)
                            $scope.customer_fields.ca3 = customer_fields[i].name;
                        if (filedNo == 4)
                            $scope.customer_fields.ca4 = customer_fields[i].name;
                        if (filedNo == 5)
                            $scope.customer_fields.ca5 = customer_fields[i].name;
                        if (filedNo == 6)
                            $scope.customer_fields.ca6 = customer_fields[i].name;

                    }
                }

                ////////////////////////////
                if (response.data.webfront.payment_fields.length) {
                    var payment_fields = response.data.webfront.payment_fields;
                    for (var i = 0; i < payment_fields.length; i++) {
                        var filedNo = parseInt(i) + 1;
                        $('#pa' + filedNo + '_chk').trigger('click');
                        if (filedNo == 1)
                            $scope.payment_fields.pa1 = payment_fields[i].name;
                        if (filedNo == 2)
                            $scope.payment_fields.pa2 = payment_fields[i].name;
                        if (filedNo == 3)
                            $scope.payment_fields.pa3 = payment_fields[i].name;
                        if (filedNo == 4)
                            $scope.payment_fields.pa4 = payment_fields[i].name;
                        if (filedNo == 5)
                            $scope.payment_fields.pa5 = payment_fields[i].name;
                        if (filedNo == 6)
                            $scope.payment_fields.pa6 = payment_fields[i].name;
                        if (filedNo == 7)
                            $scope.payment_fields.pa7 = payment_fields[i].name;
                        if (filedNo == 8)
                            $scope.payment_fields.pa8 = payment_fields[i].name;
                        if (filedNo == 9)
                            $scope.payment_fields.pa9 = payment_fields[i].name;
                        if (filedNo == 10)
                            $scope.payment_fields.pa10 = payment_fields[i].name;

                    }
                }

            }
        });

        if ($stateParams['tab'] != 'undefined' && $stateParams['tab'] != '') {
            $("a[href^='#" + $stateParams['tab'] + "']").click();
        }
    }
    if ($('.datepicker').length) {
        $('.datepicker').datepicker({format: 'yyyy-mm-dd', autoclose: true, startDate: new Date()});
    }


    /////**********************Advance Web front section By prakash starts here**************************

    $scope.createAdvanceWebfront = function (file) {
//        $scope.formUpload = true;
//        if (file != null) {
//            file.upload = Upload.upload({
//                url: siteUrl + "merchant/webfronts/createAdvanceWebfront" + $scope.getReqParams(),
//                data: {webfront: $scope.webfront, file: file}
//            });
//            file.upload.then(function (response) {
//                var data = response.data;
//                if (data.status == 'success') {
//                    $rootScope.success('Webfront created successfully!!');
//                    setTimeout(function () {
//                        $window.location.href = siteUrl + 'merchant/#/edit-advance-web-front/' + data.webfront.id + '/advance?tab=payee-information';
//                    }, 2000);
//                } else {
//                    $rootScope.error(data.msg);
//                }
//            });
//        } else {

        var imageData = $('.image-editor').cropit('export');
//        $http.post(siteUrl + "merchant/webfronts/edit", {webfront: $scope.webfront, croppedImage: imageData}).then(function (response) {

        $http.post(siteUrl + "merchant/webfronts/createAdvanceWebfront", {webfront: $scope.webfront, croppedImage: imageData}).then(function (response) {
            var data = response.data;
            if (data.status == 'success') {
                $rootScope.success('Webfront created successfully!!');
                setTimeout(function () {
                    $window.location.href = siteUrl + 'merchant/#/edit-advance-web-front/' + data.webfront.id + '/advance?tab=payee-information';
                }, 2000);
            } else {
                $rootScope.error(data.msg);
            }
        });
//        }
    };
    $scope.customer_choices = {};
    if ($stateParams['id'] != 'undefined' && $stateParams['id'] > 0 && $stateParams['advance']) {
        var id = $stateParams['id'];
        $http.get(siteUrl + "merchant/webfronts/ajaxAdvanceGetDetails/" + id).then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfront = response.data.webfront;
                $scope.webfront_payment_attributes = response.data.webfront_payment_attributes;
                $scope.webfront_payment_attributes_length = response.data.webfront_payment_attributes.length;
                $scope.total_amount = response.data.total_amount;
                var cust_length = $scope.webfront.customer_fields.length;

                for ($i = 0; $i < cust_length; $i++) {
                    if ($scope.webfront.customer_fields[$i].webfront_field_values.length == 0) {
                        $scope.webfront.customer_fields[$i].webfront_field_values = [{label: 1}];
                    }
                }
                for ($i = 0; $i < 6; $i++) {
                    $scope.customer_choices[$i] = [{label: 'textBox'}];
                }
            }
        });

        if ($stateParams['tab'] != 'undefined' && $stateParams['tab'] != '') {
            $("a[href^='#" + $stateParams['tab'] + "']").click();
        }
    }
    $scope.customerChecked = function (data, i) {
        if (data[i].customer_checkbox != true) {
            //data.splice(i, 1);
            data[i].customer_checkbox = false;
            data[i].name = '';
        }
    };
    $scope.makeCustomerCheckBoxFalse = function (data, i) {
        if (data[i].name == '') {
            data[i].customer_checkbox = false;
        }
    }
    $scope.input_types = [{
            value: 1,
            name: "Textbox"
        }, {
            value: 2,
            name: "Text area"
        }, {
            value: 3,
            name: "Radio Button"
        }, {
            value: 4,
            name: "Dropdown"
        }];

    $scope.validations = [{
            value: 1,
            name: "No Validation"
        }, {
            value: 2,
            name: "Numeric"
        }, {
            value: 3,
            name: "Alphanumeric"
        }, {
            value: 4,
            name: "Character"
        }];

    $scope.finishWebfront = function () {
        $rootScope.success('Webfront created successfully!!');
        setTimeout(function () {
            $window.location = siteUrl + 'merchant/#/advance-webfront-listing';
        }, 2000);
    }

    $scope.editCustomerFieldsAdvance = function () {
        $(".page-loading").removeClass("hidden");
        $http.post(siteUrl + "merchant/webfronts/ajaxUpdateCustomerFieldsAdvance", {webfront: $scope.webfront, customer_fields: $scope.customer_fields, customer_choices: $scope.customer_choices, select_fields: $scope.select_fields, validation_fields: $scope.validation_fields}).then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfront = response.data.webfront;
                var cust_length = $scope.webfront.customer_fields.length;
                for ($i = 0; $i < cust_length; $i++) {
                    if ($scope.webfront.customer_fields[$i].webfront_field_values.length == 0) {
                        $scope.webfront.customer_fields[$i].webfront_field_values = [{label: 1}];
                    }
                }
                $rootScope.success('Customer Fields updated successfully!!');
                $('a[href=\'#payment-information\']').click();
            } else {
                $rootScope.error('Some error occured.Please try again!!');
            }
            $(".page-loading").addClass("hidden");
        });
    };
    $scope.myAdvanceWebfronts = function () {
        $http.get(siteUrl + "merchant/webfronts/ajaxMyAdvanceWebfronts").then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfronts = response.data.webfronts;
            }
        });
    };
    $scope.publishAdvanceWebfront = function (id) {
        confirm("Are you sure you want to Publish ? ", function (data) {
            if (data) {
                $http.post(siteUrl + "merchant/webfronts/publishAdvanceWebfront/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $rootScope.success(response.data.msg);
                        $scope.webfronts = response.data.webfronts;
                    } else {
                        $rootScope.error('Some Error occured. Please try again!!');
                    }
                });
            }
        }, {return: true});
    };

    $scope.unPublishAdvanceWebfront = function (id) {
        confirm("Are you sure you want to Unpublish ? ", function (data) {
            if (data) {
                $http.post(siteUrl + "merchant/webfronts/unPublishAdvanceWebfront/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $rootScope.success(response.data.msg);
                        $scope.webfronts = response.data.webfronts;
                    } else {
                        $rootScope.error('Some Error occured. Please try again!!');
                    }
                });
            }
        }, {return: true});
    };

    $scope.textBoxes = [];
    $scope.addTextBox = function (data) {
        data.push({label: data.length + 1, value: ''});
    }


    $scope.removeTextBox = function (data, i, id) {
        data.splice(i, 1);
        if (id) {
            $http.post(siteUrl + "merchant/webfronts/removeWebfrontFieldValues/" + id).then(function (response) {
            });
        }
    }
    $scope.addNewChoice = function (i) {
        var newItemNo = $scope.customer_choices[i].length + 1;
        $scope.customer_choices[i].push({'label': 'textBox' + newItemNo});
    };
    $scope.removeChoice = function (data, i) {
        data.splice(i, 1);
    }
//payment attribute parts starts here
    $scope.addPaymentAttribute = function () {
        $http.post(siteUrl + "merchant/webfronts/ajaxAddPaymentAttribute", {paymentAttributeData: $scope.paymentAttributeData, webfront_id: $scope.webfront.id}).then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfront_payment_attributes = response.data.webfront_payment_attributes;
                $scope.webfront_payment_attributes_length = response.data.webfront_payment_attributes.length;
                $scope.total_amount = response.data.total_amount;
                $scope.paymentAttributeData = '';
                $rootScope.success('Payment attribute added successfully!!');
            } else {
                $rootScope.error('Some error occured.Please try again!!');
            }

        });
    };

    $scope.editPaymentAttribute = function (payment_attribute) {
        $http.post(siteUrl + "merchant/webfronts/ajaxUpdatePaymentAttribute", {payment_attribute: payment_attribute}).then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfront_payment_attributes = response.data.webfront_payment_attributes;
                $scope.webfront_payment_attributes_length = response.data.webfront_payment_attributes.length;
                $scope.total_amount = response.data.total_amount;
                $rootScope.success('Payment attribute updated successfully!!');
            } else {
                $rootScope.error('Some error occured.Please try again!!');
            }

        });
    };

    $scope.deletePaymentAttribute = function (id) {
        confirm('Are you sure you want to delete ?', function (data) {
            if (data) {
                $http.post(siteUrl + "merchant/webfronts/ajaxDeletePaymentAttribute/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $('#payment-attribute-' + id).remove();
                        $scope.webfront_payment_attributes = response.data.webfront_payment_attributes;
                        $scope.webfront_payment_attributes_length = response.data.webfront_payment_attributes.length;
                        $scope.total_amount = response.data.total_amount;
                        $rootScope.success('Payment attribute deleted successfully');
                    } else {
                        $rootScope.error('Some error occured.Please try again');
                    }
                })
            }
        }, {return: true});
    }
//    payment attribute parts ends here
    /////*****************Advance Web front section By prakash ends here***********************


});
//*********************Web Front Controller Code Ends here*****************************//


//app.controller('ImportPaymentsCtrl', function ($scope) {

app.controller('ImportPaymentsCtrl', function ($scope, $http, $timeout, $compile, $stateParams, $rootScope, Upload) {

    $scope.title = $stateParams['title'];

    $scope.importExcel = function (file) {
        $(".page-loading").removeClass("hidden");
        $scope.formUpload = true;
        if (file != null) {
            file.upload = Upload.upload({
                url: siteUrl + "merchant/webfronts/ajaxImportPayments" + $scope.getReqParams(),
                data: {id: $stateParams['id'], payment_cycle_date: $scope.payment_cycle_date, file: file}
            });
            file.upload.then(function (response) {
                $(".page-loading").addClass("hidden");
                if (response.data.status == 'success') {
                    $rootScope.success('File Imported Successfully!!.');
                    $('#fileinput').closest('form').get(0).reset();
                } else if (response.data.status == 'error') {
                    $rootScope.error(response.data.msg);
                }
            });
        }
    };

    $scope.getReqParams = function () {
        return $scope.generateErrorOnServer ? '?errorCode=' + $scope.serverErrorCode + '&errorMessage=' + $scope.serverErrorMsg : '';
    };

    //datepicker value and options
    if ($('.datepicker').length) {
        $('.datepicker').datepicker({format: 'yyyy-mm-dd', autoclose: true, startDate: new Date()});
    }

});

app.controller('PaymentsCtrl', function ($scope, $http, $timeout, $compile, $state, $stateParams, $rootScope, $window, Upload) {

    $scope.importExcel = function (file) {
        $(".page-loading").removeClass("hidden");
        $scope.formUpload = true;
        if (file != null) {
            file.upload = Upload.upload({
                url: siteUrl + "merchant/webfronts/ajaxImportPayments" + $scope.getReqParams(),
                data: {id: $stateParams['id'], payment_cycle_date: $scope.payment_cycle_date, file: file}
            });
            file.upload.then(function (response) {
                $(".page-loading").addClass("hidden");
                if (response.data.status == 'success') {
                    $rootScope.success('File Imported Successfully!!.');
                    $scope.viewUploads();
                    $('#fileinput').closest('form').get(0).reset();
                    $('#upload-excel-section').hide(), $('#uploaded-file-section').show();
                } else if (response.data.status == 'error') {
                    //$rootScope.error(response.data.msg);                    
                    $html = '<div style="display: block;" id="success-msg" class="alert alert-danger">';
                    $html += '<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>';
                    $html += ' <p><i class="ace-icon fa fa-times"></i>&nbsp;' + response.data.msg + '</p>';
                    $html += '</div>';
                    $('#upload-flash-msg').html($html).show();//.delay(8000).fadeOut();
                    $("html, body").animate({scrollTop: 0}, "slow");
                }
            });
        }
    };

    $scope.getReqParams = function () {
        return $scope.generateErrorOnServer ? '?errorCode=' + $scope.serverErrorCode + '&errorMessage=' + $scope.serverErrorMsg : '';
    };

    //datepicker value and options
    if ($('.datepicker').length) {
        $('.datepicker').datepicker({format: 'yyyy-mm-dd', autoclose: true, startDate: new Date()});
    }


    $scope.viewUploads = function () {
        var webfrontId = $stateParams['id'];
        $scope.tab = $stateParams.tab;
        //$(".page-loading").removeClass("hidden");
        $http({
            method: "POST",
            url: siteUrl + "merchant/payments/ajaxViewUploads/" + webfrontId,
            data: {},
        }).then(function (response) {
            if (response.data.status == 'success') {
                $scope.uploaded_payment_files = response.data.data.uploaded_payment_files;
                $scope.webfront = response.data.data.webfront;
                console.log(response.data.data);
            }
            //$(".page-loading").addClass("hidden");
        });
        return false;
    };


    $scope.appendRecords = function ($event) {
        $event.preventDefault();
        var id = $($event.currentTarget).attr('data-uploaded_payment_file_id');
        var formId = $($event.currentTarget).attr('id');
        var formData = new FormData($($('#' + formId))[0]);
        $.ajax({
            url: siteUrl + "merchant/webfronts/ajaxAppendRecords",
            type: 'POST',
            data: formData,
            dataType: 'JSON',
            async: false,
            success: function (response) {
                if (response.status == 'success') {
                    $('#appendRecord' + id).hide();
                    $scope.viewUploads();
                    $rootScope.success('New Records Added Successfully!!.');
                } else {
                    var msg = '<div style="display: block;" id="success-msg" class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><p><i class="ace-icon fa fa-check"></i>&nbsp;<span class="msg">' + response.msg + '</span></p></div>';
                    $('#append_records_error_' + id).html(msg).show();
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    }


    $scope.uploadReuse = function ($event) {
        $event.preventDefault();
        var id = $($event.currentTarget).attr('data-uploaded_payment_file-id');
        var formId = $($event.currentTarget).attr('id');
        var formData = $('#' + formId).serialize();
        $http({
            method: "POST",
            dataType: 'JSON',
            url: siteUrl + "merchant/payments/ajaxUploadReuse",
            data: formData,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if (response.data.status == 'success') {
                $('#reuseUpload' + id).hide();
                $scope.viewUploads();
                $rootScope.success('Copied Successfully!!.');
            } else {
                $('#reuse_upload_error_' + id).html('<div style="display: block;" id="success-msg" class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><p><i class="ace-icon fa fa-check"></i>&nbsp;' + response.data.msg + '</p></div>').show();
            }
        });
        return false;
    };

    $scope.deleteUploadedFile = function (uploadedFile) {
        confirm(' You are going to delete all the records uploads. Are you sure you want to delete ?', function (data) {
            if (data) {
                $http({
                    method: "POST",
                    url: siteUrl + "merchant/payments/ajaxDeleteUploadedFile/" + uploadedFile.id,
                }).then(function (response) {
                    if (response.data.status == 'success') {
                        $('#uploaded-payment-file-' + uploadedFile.id).remove();
                        $rootScope.success('Records deleted Successfully!!.');
                    }
                });
            }
        }, {return: true});
    }

    $scope.downloadReport = function () {
        var status = $scope.status;
        var msg = "Are you sure you want all the invoices report ?";
        var option = 0;
        if (status == 'paid') {
            option = 1;
            msg = "Are you sure you want all the paid invoices report ?";
        } else if (status == 'unpaid') {
            option = 2;
            msg = "Are you sure you want all the unpaid invoices report ?";
        }
        confirm(msg, function (data) {
            if (data) {
                $window.location = siteUrl + 'merchant/payments/downloadReport/' + $scope.webfront.id + '/' + option;
            }
        }, {return: true});
    }

    $scope.viewPayments = function (page) {
        var paymentFileId = $stateParams['id'];
        $(".page-loading").removeClass("hidden");
        var page = (typeof page === 'undefined') ? 1 : page;
        var searchby = $('#searchby').val();
        var keyword = $('#keyword').val();
        //$scope.status = (status === undefined || status === null) ? 'all' : status;
        var dataString = {'page': page, 'status': $scope.status, 'searchby': searchby, 'keyword': keyword};
        $http({
            method: "POST",
            url: siteUrl + "merchant/payments/ajaxViewPayments/" + paymentFileId,
            data: dataString,
        }).then(function (response) {
            if (response.data.status == 'success') {
                var payments = response.data.payments;
                var newPayments = [];
                for (var i = 0; i < payments.length; i++) {
                    if (payments[i]['payee_custom_fields'])
                        payments[i].payee_custom_fields = JSON.parse(payments[i]['payee_custom_fields']);
                    if (payments[i]['payment_custom_fields'])
                        payments[i].payment_custom_fields = JSON.parse(payments[i]['payment_custom_fields']);
                    newPayments.push(payments[i]);
                }
                $scope.payments = newPayments;
//                $scope.payments = response.data.payments;
                $scope.webfront = response.data.webfront;
                console.log(response.data.webfront);
                $scope.file = response.data.file;
                $scope.counter = response.data.counter;
                $('#pagination-paginate .pagination').html(response.data.paging);
            } else {
//                $('#simple-table tbody').html("<tr><td colspan='8' style='text-align:center; color:red;'>No Data Found.</td></tr>");
            }
            $(".page-loading").addClass("hidden");
        }, function myError(response) {
            //Error Code//
        });

        return false;
    };

    $scope.advanceViewPayments = function (page) {
        var paymentFileId = $stateParams['id'];
        $(".page-loading").removeClass("hidden");
        var page = (typeof page === 'undefined') ? 1 : page;
        var searchby = $('#searchby').val();
        var keyword = $('#keyword').val();
        var dataString = {'page': page, 'searchby': searchby, 'keyword': keyword};

        $http({
            method: "POST",
            url: siteUrl + "merchant/payments/ajaxViewPayments/" + paymentFileId,
            data: dataString,
        }).then(function (response) {
            if (response.data.status == 'success') {
                var payments = response.data.payments;
                var newPayments = [];
                for (var i = 0; i < payments.length; i++) {
                    if (payments[i]['payee_custom_fields'])
                        payments[i].payee_custom_fields = JSON.parse(payments[i]['payee_custom_fields']);
                    if (payments[i]['payment_custom_fields'])
                        payments[i].payment_custom_fields = JSON.parse(payments[i]['payment_custom_fields']);
                    newPayments.push(payments[i]);
                }
                $scope.payments = newPayments;
//                $scope.payments = response.data.payments;
                $scope.webfront = response.data.webfront;
                console.log(response.data.webfront);
                $scope.file = response.data.file;
                $scope.counter = response.data.counter;
                $('#pagination-paginate .pagination').html(response.data.paging);
            } else {
//                $('#simple-table tbody').html("<tr><td colspan='8' style='text-align:center; color:red;'>No Data Found.</td></tr>");
            }
            $(".page-loading").addClass("hidden");
        }, function myError(response) {
            //Error Code//
        });

        return false;
    };

    $scope.deletePayment = function (payment) {
        var uniq_id = payment.uniq_id;
        var msg = "Are you sure you want to delete bill for <b>" + payment.name + "</b> ?";
        confirm(msg, function (data) {
            if (data) {
                $http.post(siteUrl + "merchant/payments/ajaxDeletePayment/" + uniq_id).success(function (data, status, headers, config) {
                    if (data.status == 'success') {
                        $('#payment-' + uniq_id).remove();
                        $rootScope.success('Payment details deleted successfully!!.');
                    } else {
                        $rootScope.error('Some error occured.Please try again.');
                    }
                });
            }
        }, {return: true});
    };

    $scope.deleteSelectedPayments = function () {
        if ($('.chk_payment:checked').length <= 0) {
            alert('Please select atlest one row to delete.');
            return flase;
        }
        var msg = "Are you sure you want to delete selected payment details ?";
        confirm(msg, function (data) {
            if (data) {
                var checkValues = $('input[class=chk_payment]:checked').map(function () {
                    return $(this).val();
                }).get();
                $http.post(siteUrl + "merchant/payments/ajaxDeleteSelectedPayments", {'ids': checkValues}).success(function (data, status, headers, config) {
                    if (data.status == 'success') {
                        for (var i = 0; i < checkValues.length; i++) {
                            $('#payment-' + checkValues[i]).remove();
                        }
                        $rootScope.success('Selected rows deleted successfully!!.');
                    } else {
                        $rootScope.error('Some error occured.Please try again.');
                    }
                });
            }
        }, {return: true});
    };


    $scope.remindPayment = function (payment) {
        var msg = "Are you sure you want to send reminder email ?";
        confirm(msg, function (data) {
            if (data) {
                $(".page-loading").removeClass("hidden");
                $http.post(siteUrl + "merchant/payments/ajaxRemindPayment/" + payment.id).success(function (data, status, headers, config) {
                    if (data.status == 'success') {
                        $rootScope.success('Reminder email sent successfully!!.');
                    } else {
                        $rootScope.error('Some error occured.Please try again.');
                    }
                    $(".page-loading").addClass("hidden");
                });
            }
        }, {return: true});
    };

    $scope.remindSelectedPayment = function (payment) {
        if ($('.chk_payment:checked').length <= 0) {
            alert('Please select atlest one row to send email.');
            return flase;
        }
        confirm("Are you sure you want to send reminder email ?", function (data) {
            if (data) {
                $(".page-loading").removeClass("hidden");
                var checkValues = $('input[class=chk_payment]:checked').map(function () {
                    return $(this).val();
                }).get();
                $http.post(siteUrl + "merchant/payments/ajaxRemindSelectedPayment", {'ids': checkValues}).success(function (data, status, headers, config) {
                    if (data.status == 'success') {
                        $rootScope.success('Reminder email sent to selected customers successfully!!.');
                    } else {
                        $rootScope.error('Some error occured.Please try again!!.');
                    }
                    $(".page-loading").addClass("hidden");
                });
            }
        }, {return: true});
    };

    $scope.updatePayment = function ($event) {
        $event.preventDefault();
        var paymentId = $($event.currentTarget).attr('data-payment-id');
        var formId = $($event.currentTarget).attr('id');
        var formData = $('#' + formId).serialize();
        $http({
            method: "POST",
            dataType: 'josn',
            url: siteUrl + "merchant/payments/ajaxEditPayment",
            data: formData,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if (response.data.status == 'success') {
                $('#edit-payment-success-' + paymentId).show().focus().delay(5000).fadeOut();
                setTimeout(function () {
                    $scope.viewPayments();//$state.reload();
                }, 2000);
            } else {
                $('#edit-payment-error-' + paymentId).show().focus().delay(5000).fadeOut();
            }
        });
        return false;
    };

    $scope.emailReceipt = function (uniq_id) {
        var msg = "Are you sure you want to send email receipt ?";
        confirm(msg, function (data) {
            if (data) {
                $(".page-loading").removeClass("hidden");
                $http.post(siteUrl + "customer/payments/ajaxEmailReceipt/" + uniq_id).success(function (data, status, headers, config) {
                    if (data.status == 'success') {
                        $rootScope.success('Email receipt sent successfully!!.');
                    } else {
                        $rootScope.error('Some error occured.Please try again.');
                    }
                    $(".page-loading").addClass("hidden");
                });
            }
        }, {return: true});
    };

    $scope.parJson = function (json) {
        return JSON.parse(json);
    }

    $scope.viewPaymentsPagination = function (event) {
        var $this = angular.element(event.target);
        if ($this.parents('li').hasClass('active') || $this.parents('li').hasClass('disabled')) {
            return false;
        }
        var url = $this.attr('href');
        var key = 'page';
        var page = unescape(url.replace(new RegExp("^(?:.*[&\\?]" + escape(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
        page = (typeof page === 'undefined') ? 1 : page;
        $scope.viewPayments(page);
        return false;
    }


    $scope.getUploadedFiles = function () {
        $http({
            method: "GET",
            url: siteUrl + "merchant/payments/ajaxGetUploadedFiles"
        }).then(function mySucces(response) {
            if (response.data.status == 'success') {
                $scope.uploaded_payment_files = response.data.data;
            } else {
//                $('#simple-table tbody').html("<tr><td colspan='8' style='text-align:center; color:red;'>No files are uploaded yet.</td></tr>");
            }
        }, function myError(response) {
            //Error Code//
        });
    }

    $scope.deletePaymentUpload = function (id) {
        confirm("Are you sure you want to delete ? ", function (data) {
            if (data) {
                $http.get(siteUrl + "merchant/payments/ajaxDeletePaymentFile/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $('#file-no-' + id).remove();
                    }
                });
            }
        }, {return: true});
    }

    $scope.fetchCustomFields = function () {
        var paymentFileId = $stateParams['id'];
        $http.get(siteUrl + "merchant/payments/ajaxfetchCustomFields/" + paymentFileId).then(function (response) {
            if (response.data.status == 'success') {
                $scope.custom_fields = response.data.data;
            }
        });
    }

    $scope.confirmUpload = function (id) {
        var paymentFileId = $stateParams['id'];
        confirm("Are you sure you want to confirm ? ", function (data) {
            if (data) {
                window.location = siteUrl + "merchant/payments/confirmUpload/" + paymentFileId
            }
        }, {return: true});
    }

    $scope.cancelUpload = function (id) {
        var paymentFileId = $stateParams['id'];
        confirm("Are you sure you want to cancel ? ", function (data) {
            if (data) {
                window.location = siteUrl + "merchant/payments/cancelUpload/" + paymentFileId
            }
        }, {return: true});
    }

});


app.controller('ProfileCtrl', function ($scope, $rootScope, $http, $timeout, $compile, Upload) {

    if ($('.image-editor').length) {
        $('.image-editor').cropit();
    }

    $scope.editMerchant = function (file, editId) {

//        $scope.formUpload = true;
//        if (file != null) {
//            file.upload = Upload.upload({
//                url: siteUrl + "merchant/users/ajaxEditMerchant/" + editId + '/' + $scope.getReqParams(),
//                data: {merchant: $scope.merchant, file: file}
//            });
//            file.upload.then(function (response) {
//                $("html, body").animate({scrollTop: 0}, "slow");
//                var data = response.data;
//                if (data.status == 'success') {
//                    $scope.merchant = data.merchant
//                    $rootScope.success(data.msg);
//                } else if (data.status == 'error') {
//                    $rootScope.error(data.msg);
//                } else {
//                    $rootScope.error('Some error occured. Please try again!!.');
//                }
//            });
//        } else {

        var imageData = $('.image-editor').cropit('export');
        $http.post(siteUrl + "merchant/users/ajaxEditMerchant/" + editId, {
            merchant: $scope.merchant,
            merchant_profile: $scope.merchant_profile,
            croppedImage: imageData
        }).success(function (response, status, headers, config) {
            $("html, body").animate({scrollTop: 0}, "slow");
            var data = response;
            if (data.status == 'success') {
                $scope.merchant = data.merchant
                $rootScope.success(data.msg);
            } else if (data.status == 'error') {
                $rootScope.error(data.msg);
            } else {
                $rootScope.error('Some error occured. Please try again!!.');
            }
        });
//        }
    };

    $scope.getReqParams = function () {
        return $scope.generateErrorOnServer ? '?errorCode=' + $scope.serverErrorCode + '&errorMessage=' + $scope.serverErrorMsg : '';
    };

    $scope.getProfileData = function () {
        $http.get(siteUrl + "merchant/users/ajaxGetProfileData").then(function (response) {
            var data = response.data;
            if (data.status == 'success') {
                $scope.merchant = data.merchant;
                $scope.merchant_profile = data.merchant.merchant_profile;
            } else {
                $scope.merchant = [];
            }
        });
    }

    $scope.updateProfile = function () {
        $http.post(siteUrl + "users/ajaxUpdateProfile", {
            'user': $scope.user
        }).success(function (data, status, headers, config) {
            if (data.status == 'success') {
                $('#success-msg').show().delay(2000).slideUp();
            } else {
                $('#error-msg').show().delay(4000).slideUp();
            }
        });
        return false;
    }

    $scope.changePassword = function () {
        $http.post(siteUrl + "users/ajaxChangePasssword", {
            'old_password': $scope.old_password,
            'password1': $scope.password1,
            'password2': $scope.password2
        }).success(function (response, status, headers, config) {
            if (response.status == 'success') {
                $('#changePassword')[0].reset();
                $rootScope.success('Password Changed Successfully!!.');
            } else {
                $rootScope.error(response.msg);
            }
        });
        return false;
    }
});

///////////User Section By prakash starts here\\\\\\\\\\\\\\
app.controller('UserCtrl', function ($scope, $http, $stateParams, $window, $timeout) {

    $scope.checkNameAvail = function (value) {
        if (value) {
            $http.get(siteUrl + "merchant/users/ajaxNameAvail?name=" + value).then(function (response) {
                if (response.data.status == 'success') {
                    if (response.data.avail == 1) {
                        $('#name-avail').text('Name available!!').css({'color': 'green'}).show().delay(3000).fadeOut();
                    } else if (response.data.avail == 0) {
                        $('#name-avail').text('Name not available!!').css({'color': 'red'}).show().delay(3000).fadeOut();
                    }
                }
            });
        }
    };
    $scope.checkEmailAvail = function (value) {
        if (value) {
            $http.get(siteUrl + "merchant/users/ajaxEmailAvail?email=" + value).then(function (response) {
                if (response.data.status == 'success') {
                    if (response.data.avail == 1) {
                        $('#email-avail').text('Email available!!').css({'color': 'green'}).show().delay(3000).fadeOut();
                    } else if (response.data.avail == 0) {
                        $('#email-avail').text('Email not available!!').css({'color': 'red'}).show().delay(3000).fadeOut();
                    }
                }
            });
        }
    };


    $scope.addUser = function () {
        $http.post(siteUrl + "merchant/users/ajaxAddUser", {
            'user': $scope.user
        }).success(function (response, status, headers, config) {
            if (response.status == 'success') {
                $window.location.href = siteUrl + 'merchant/#/view-all-user';
                $('#view-success-msg').show().delay(4000).slideUp();
                $('#view-suc-msg-content').html(response.msg).show();

//                    $('#success-msg').show().delay(4000).slideUp();
//                    $('#suc-msg-content').html(data.msg).show();
            } else {
                $('#error-msg').show().delay(4000).slideUp();
                $('#err-msg-content').html(response.msg).show();
            }
        });
    }
    $scope.getReqParams = function () {
        return $scope.generateErrorOnServer ? '?errorCode=' + $scope.serverErrorCode + '&errorMessage=' + $scope.serverErrorMsg : '';
    };
    $scope.getUser = function () {
        $http.get(siteUrl + "merchant/users/ajaxFetchUsers").then(function (response) {
            if (response.data.status == 'success') {
                $scope.listingUsers = response.data.data;
            }
        });
    }
    $scope.getEditUser = function () {
        var userId = $stateParams['id'];
        $http.get(siteUrl + "merchant/users/ajaxGetEditUser/" + userId).then(function (response) {
            if (response.data.status == 'success') {
                $scope.user = response.data.data;
            }
        });
    }
    $scope.editUser = function (editId) {
        if (editId) {
            $http.post(siteUrl + "merchant/users/ajaxEditUser/" + editId, {
                'user': $scope.user
            }).success(function (response, status, headers, config) {
                if (response.status == 'success') {
                    $('#success-msg').show().delay(4000).slideUp();
                    $('#suc-msg-content').html(response.msg).show();
                } else {
                    $('#error-msg').show().delay(4000).slideUp();
                    $('#err-msg-content').html(response.msg).show();
                }
            });
        }
    };
    $scope.deleteUser = function (id) {
        var msg = "Are you sure you want to delete this user?";
        confirm(msg, function (data) {
            if (data) {
                $http.get(siteUrl + "merchant/users/ajaxDeleteUser/" + id).then(function (response) {
                    if (response.data.status == 'success') {
                        $('#user-id-' + id).remove();
                        $('#view-success-msg').show().delay(4000).slideUp();
                        $('#view-suc-msg-content').html(response.data.msg).show();
                    }
                });
            }
        }, {return: true});
    }
    $scope.inActivateUser = function (id) {
        var msg = "Are you sure you want to inactivate this user?";
        confirm(msg, function (data) {
            if (data) {
                $http.get(siteUrl + "merchant/users/ajaxInActivateUser/" + id).then(function (response) {
                    if (response.data.status == 'success') {
//                        $window.location.reload();
                        $('#view-success-msg').show().delay(4000).slideUp();
                        $('#view-suc-msg-content').html(response.data.msg).show();
                        $scope.listingUsers = response.data.users;
                    }
                });
            }
        }, {return: true});
    }
    $scope.activateUser = function (id) {
        var msg = "Are you sure you want to activate this user?";
        confirm(msg, function (data) {
            if (data) {
                $http.get(siteUrl + "merchant/users/ajaxActivateUser/" + id).then(function (response) {
                    if (response.data.status == 'success') {
//                        $window.location.reload();
                        $('#view-success-msg').show().delay(4000).slideUp();
                        $('#view-suc-msg-content').html(response.data.msg).show();
                        $scope.listingUsers = response.data.users;
                    }
                });
            }
        }, {return: true});
    }
});
///////////User Section By prakash ends here\\\\\\\\\

app.controller('ReportsCtrl', function ($scope, $http, $stateParams, $window, $timeout) {

    $scope.fetchWebfronts = function () {
        $http.get(siteUrl + "merchant/webfronts/ajaxMyWebfronts").then(function (response) {
            if (response.data.status == 'success') {
                $scope.webfronts = response.data.webfronts;
            }
        });
    };

    $scope.viewWebfrontFiles = function () {
        var id = $stateParams.id;
        $http.get(siteUrl + "merchant/payments/ajaxViewUploads/" + id).then(function (response) {
            if (response.data.status == 'success') {
                $scope.uploaded_payment_files = response.data.data.uploaded_payment_files;
                $scope.webfront = response.data.data.webfront;
            }
        });
    };

});

app.controller('AdvancePaymentsCtrl', function ($scope, $http, $timeout, $compile, $stateParams, $rootScope, $window, Upload) {

    var webfrontId = $stateParams['id'];

    $scope.advanceWebfrontReport = function () {
        var status = $scope.status;
        var msg = "Are you sure you want all the invoices report ?";
        var option = 0;
        if (status == 'paid') {
            option = 1;
            msg = "Are you sure you want all the paid invoices report ?";
        } else if (status == 'unpaid') {
            option = 2;
            msg = "Are you sure you want all the unpaid invoices report ?";
        }
        confirm(msg, function (data) {
            if (data) {
                $window.location = siteUrl + 'merchant/payments/webfront-report/' + $scope.webfront.id + '/' + option;
            }
        }, {return: true});
    }

    $scope.advanceWebfrontPayments = function () {
        $(".page-loading").removeClass("hidden");
        var dataString = {'status': $scope.status};
        $http({
            method: "POST",
            url: siteUrl + "merchant/payments/ajaxAdvanceWebfrontPayments/" + webfrontId,
            data: dataString
        }).then(function (response) {
            if (response.data.status == 'success') {
                var payments = response.data.payments;
                var newPayments = [];
                for (var i = 0; i < payments.length; i++) {
                    if (payments[i]['payee_custom_fields'])
                        payments[i].payee_custom_fields = JSON.parse(payments[i]['payee_custom_fields']);
                    if (payments[i]['payment_custom_fields'])
                        payments[i].payment_custom_fields = JSON.parse(payments[i]['payment_custom_fields']);
                    newPayments.push(payments[i]);
                }
                $scope.payments = newPayments;
                $scope.webfront = response.data.webfront;
                $scope.file = response.data.file;
                $scope.counter = response.data.counter;
                $('#pagination-paginate .pagination').html(response.data.paging);
            }
            $(".page-loading").addClass("hidden");
        });
    }

});

app.controller('DashboardCtrl', function ($scope, $http, $timeout, $compile, $stateParams, $rootScope, $window, Upload) {
    $scope.getMerchantData = function () {
        $http.get(siteUrl + "merchant/users/ajaxGetProfileData").then(function (response) {
            $scope.merchant = response.data.merchant
        });
    }
});

//////////////////////////////////
function getParameterByName(name, url) {
    if (!url)
        url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
    if (!results)
        return null;
    if (!results[2])
        return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
//JQuery Code for Menu Active & In-Active
$(function () {
    $(document).on('click', '.nav-list a', function () {
        $('.nav-list').find('li.nav-list-2').removeClass('active').removeClass('open').find('ul.submenu').addClass('nav-hide').removeClass('nav-show');
        $(this).parents('li.nav-list-2').addClass('active').addClass('open');

        $('.nav-list').find('li').removeClass('active');
        $(this).parent('li').addClass('active');
        $('#sidebar').removeClass('display');
    });
});

$(function () {
    var page = 1;
    $(document).on('click', '#uploaded_file_paginate a', function () {
        if (!$(this).parent('li').hasClass('disabled') && !$(this).parent('li').hasClass('active')) {
            var pageUrl = $(this).attr('href');
            page = getParameterByName('page', pageUrl);
            if (page == null || page == '') {
                page = 1;
            }
            getUploadedFiles();
        }
        return false;
    });
});