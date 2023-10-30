//--------------------------------------------------------------------------------------

            //Onload

//--------------------------------------------------------------------------------------

function onload()
{
    if (!getQueryParam('page')) { 
        $('#loginPage', '#signUpPage, #createAccountPage, #feedPage, #searchPage, #searchResultsPage, #notificationPage, #userProfilePage').hide();
        setQueryParam('login');
    }
    else
    {
        $('#loginPage', '#signUpPage, #createAccountPage, #feedPage, #searchPage, #searchResultsPage, #notificationPage, #userProfilePage').hide();
        loadPageBasedOnQueryParam();
    }
}


//--------------------------------------------------------------------------------------

            //SET, DETECT QUERY CHANGE, AND LOAD PAGES

//--------------------------------------------------------------------------------------

function setQueryParam(value) {
    var name = 'page';
    var urlParams = new URLSearchParams(window.location.search);
    var previousValue = urlParams.get(name);

    urlParams.set(name, value);
    var newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + urlParams.toString();
    window.history.pushState({ path: newUrl }, '', newUrl);

    // Hide the previous page if it existed
    if (previousValue) {
        $('#' + previousValue + 'Page').addClass('fade-out');
        setTimeout(() => {
            $('#' + previousValue + 'Page').removeClass('fade-out').hide();
            location.reload();
        }, 300);
    }
    else {
        location.reload();
    }
}


function loadPageBasedOnQueryParam() {
    var pageParam = getQueryParam('page');
    if (pageParam) {
        loadPageContent(pageParam + 'Page');
        $('#' + pageParam + 'Page').addClass('fade-in').show();
        setTimeout(() => {
            $('#' + pageParam + 'Page').removeClass('fade-in');
        }, 300);
    }
    
}

function getQueryParam(name) {
    var urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

window.onpopstate = function(event) {
    loadPageBasedOnQueryParam();
};

//--------------------------------------------------------------------------------------

            //LOAD PAGES

//--------------------------------------------------------------------------------------

let currentParam;
function loadPageContent(pageClass) {
    currentParam = pageClass;
    var filePath = 'pages/' + pageClass + '.html';
    $.ajax({
        url: filePath,
        type: 'GET',
        dataType: 'html',
        success: function(data) {
            // If the request was successful, insert the content into the corresponding div
            $('#' + pageClass).html(data);
            // Add query parameter to the URL
            var queryParam = pageClass.slice(0, -4);
            window.history.pushState({}, document.title, window.location.pathname + '?page=' + queryParam);

            // Check if pageClass is not login, signup, or createAccount
            if (pageClass !== 'loginPage' && pageClass !== 'signupPage' && pageClass !== 'createAccountPage') {
                // Load header content
                $.ajax({
                    url: 'pages/header.html',
                    type: 'GET',
                    dataType: 'html',
                    success: function(headerData) {
                        $('#header').html(headerData);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error loading header content:', textStatus, errorThrown);
                    }
                });
                // Load footer content
                $.ajax({
                    url: 'pages/footer.html',
                    type: 'GET',
                    dataType: 'html',
                    success: function(footerData) {
                        $('#footer').html(footerData);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error loading footer content:', textStatus, errorThrown);
                    }
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error loading content:', textStatus, errorThrown);
        }
    });
}

//--------------------------------------------------------------------------------------

            //LOG IN AND SIGN UP

//--------------------------------------------------------------------------------------
function validateLogin()
{
    $('#loginError').hide();

    var username = $('#username').val();
    var password = $('#password').val();

    if (username !== '' && password !== '') {
        $.ajax({
            type: 'POST',
            url: 'utils/validateLogin.php',
            data: {
                username: username,
                password: password
            },
            success: function(response) {
                if (response === "Invalid username or password") {
                    $('#loginError').html(response);
                    $('#loginError').show();
                } else if (response === "Login successful!") {
                    sessionStorage.setItem('currentUsername', username);
                    setQueryParam('feed');
                }
                else {
                    $('#loginError').html(response);
                    $('#loginError').show();
                }
            }
        });
    }
    else
    {
        $('#loginError').html('error: crendentials cannot be empty');
        $('#loginError').show();
    }
}

function validateSignup() {
    $('#signupError').hide();

    var username = $('#createdUsername').val();
    var password = $('#createdPassword').val();
    var passwordConfirm = $('#createdPasswordConfirm').val();
    console.log(username + ' ' + password + ' ' + passwordConfirm);
    if (username !== '' && password !== '' && password.length >= 8 && password === passwordConfirm) {
        $.ajax({
            type: 'POST',
            url: 'utils/validateSignup.php',
            data: {
                username: username,
                password: password
            },
            success: function(response) {
                if (response === "username already exists. please choose a different username.") {
                    $('#signupError').html(response);
                    $('#signupError').show();
                } else if (response === "Signup successful!") {
                    sessionStorage.setItem('currentUsername', username);
                    setQueryParam('createAccount');
                } else if (response === "error: credentials cannot be empty") {
                    console.log('case 1');
                    $('#signupError').html(response);
                    $('#signupError').show();
                } else {
                    $('#signupError').html(response);
                    $('#signupError').show();
                }
            }
        });
    } else {
        if (password !== passwordConfirm) {
            $('#signupError').html('error: passwords do not match');
        } else if (password.length < 8) {
            $('#signupError').html('error: password must be at least 8 characters');
        } else {
            console.log('case 2');
            $('#signupError').html('error: credentials cannot be empty');
        }
        $('#signupError').show();
    }
}

