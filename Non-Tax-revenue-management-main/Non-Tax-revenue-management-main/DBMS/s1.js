function validateForm() {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var a = "admin@email.com";
    var b = "Admin@123";
  
    if(email==''){
        alert('Please enter an E-mail');
        return false;
    }
     
    var emailadd = /\S+@\S+\.com+/;
    if (!email.match(emailadd)) {
        alert('Invalid email');
        return false;
    }
    var passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
  
    if (!passwordPattern.test(password)) {
        alert('Please enter a valid password (6-20 characters with at least one lowercase letter, one uppercase letter, and one digit)');
        return false;
    }
  
    if(a != email){
      alert('Wrong email and password has been entered');
      return false;
    }
  
    if(b !=password){
      alert('Incorrect Password has been entered');
      return false;
    }
  
    alert("Your login credentials are correct. You will be redirected...");
    window.location.href = "http://localhost/dbms/home.php";
  
    return false;
  }