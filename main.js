//--------------------------------------------------------------------------------------

            //Onload

//--------------------------------------------------------------------------------------

function onload() {
    if (!getQueryParam('page')) { 
        $('#loginPage', '#signUpPage, #createAccountPage, #feedPage, #searchPage, #searchResultsPage, #notificationPage, #accountPage').hide();
        setQueryParam('login');
    }
    else
    {
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

function loadPageContent(pageClass) {
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
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error loading content:', textStatus, errorThrown);
        }
    });
}

//--------------------------------------------------------------------------------------

            //HANDLE PAGE CHANGE

//--------------------------------------------------------------------------------------


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
                setQueryParam('home');
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

    if (username !== '' && password !== '' && password === passwordConfirm) {
        $.ajax({
            type: 'POST',
            url: 'utils/validateSignup.php',
            data: {
                username: username,
                password: password
            },
            success: function(response) {
                alert(response);
                if (response === "username already exists. please choose a different username.") {
                    $('#signupError').html(response);
                    $('#signupError').show();
                } else if (response === "Signup successful!") {
                    setQueryParam('createAccount');
                } else if (response === "error: credentials cannot be empty") {
                    $('#signupError').html(response);
                    $('#signupError').show();
                }
                else
                {
                    $('#signupError').html(response);
                    $('#signupError').show();
                }
            }
        });
    } else {
        if (password !== passwordConfirm) {
            $('#signupError').html('error: passwords do not match');
        } else {
            $('#signupError').html('error: credentials cannot be empty');
        }
        $('#signupError').show();
    }
}
