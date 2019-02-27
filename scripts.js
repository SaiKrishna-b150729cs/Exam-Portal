function validatesignupForm(){
    form = document.forms['register_form']
    name = form['name'].value
    email = form['email'].value
    mobile = form['mobile'].value
    college = form['college'].value
    pass = form['password'].value
    cpass = form['cpassword'].value
    text = /^[A-Za-z ]+$/
    mail = /^[A-Za-z0-9_. ]+@[A-Za-z]+.[A-Za-z]+[.]?[A-Za-z]*$/
    if (name == null || name == "" || !name.match(text)){
        form.name.focus()
        alert( "Please provide Valid name!" );
        return false
    }
    if (email == null || email == "" || !email.match(mail)){
        form.email.focus()
        alert( "Please provide Valid email address!" );
        return false
    }
    if (college == null || college == ""){
        form.college.focus()
        alert( "Please provide Valid College Name!" );
        return false
    }
    num = /^[1-9][0-9]+/
    if (mobile == null || mobile == "" || mobile.length != 10 || !mobile.match(num)){
        form.mobile.focus()
        alert( "Please provide Valid Phone Number!" );
        return false
    }
    if(pass == null || pass == ""){
        form['password'].focus()
        alert("Enter a password")
        return false
    }
    if(cpass == null || cpass == ""){
        form['cpassword'].focus()
        alert("Enter confirmation password")
        return false
    }
    if(pass != cpass){
        form['password'].focus()
        alert("Passwords must match")
        return false
    }
    return true
}

function validatesigninForm(){
    form = document.forms['login_form']

    email = form['login_email'].value
    pass = form['login_pass'].value


    mail = /^[A-Za-z0-9_. ]+@[A-Za-z]+.[A-Za-z]+$/
    if (email == null || email == "" || !email.match(mail)){
        form.login_email.focus()
        alert( "Please provide Valid email address!" );
        return false
    }
    if(pass == null || pass == ""){
        form.login_pass.focus()
        alert( "Please enter a password !" );
        return false
    }
    console.log("valid login form")
    return true

}

function validateaddtestForm(){
    form = document.forms['addtest_form']
    console.log('add_test form validation')
    name = form['name'].value
    duration = Number(form['duration'].value)
    ques_count = Number(form['count'].value)

    if(name == null || name == ""){
        alert("Enter a valid test name")
        return false
    }
    if(duration == null || duration == "" || !Number.isInteger(duration) || duration == 0){
        alert("Enter a valid test duration")
        return false
    }
    if(ques_count == null || ques_count == "" || !Number.isInteger(ques_count) || ques_count == 0){
        alert("Enter a valid Number of questions")
        return false
    }
    console.log('add_test form valid')
    return true
}


function validatequestionsForm(count){
    console.log(count); 
    form = document.forms['questions_form']
    i = 1
    while(i<=count){
        que = form['question' + i].value
        if(que == null || que == ""){
            alert("Enter valid question " + i)
            return false
        }
        j=1
        while(j<=4){
            opt = form['question' + i + '_' + j].value
            if(opt == null || opt == ""){
                alert("Enter valid option " + j + ' for question ' + i)
                return false
            }
            j++;
        }
        i++;
    }
    //alert("fill all values");
    return true;
}