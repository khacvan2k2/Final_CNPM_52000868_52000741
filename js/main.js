/* =========================================== */
/* =========================================== */
function validate() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    //Nếu không nhập gì mà nhấn đăng nhập thì sẽ báo lỗi
    if (username == "" && password == "") {
        swal({
            title: "",
            text: "Bạn chưa điền đầy đủ thông tin đăng nhập...",
            icon: "error",
            close: true,
            button: "Thử lại",
          });
         
        return false;
       
    }
    //Nếu không nhập mật khẩu mà đúng tài khoản 
    if (username == "admin" && password == "") {
        swal({
            title: "",
            text: "Bạn chưa nhập mật khẩu...",
            icon: "warning",
            close: true,
            button: "Thử lại",
          });
        return false;
    }
    //Nếu không nhập tài khoản sẽ báo lỗi
    if (username == null || username == "") {
        swal({
            title: "",
            text: "Tài khoản đang để trống...",
            icon: "warning",
            close: true,
            button: "Thử lại",
          });
        return false;
    }
    //Nếu không nhập mật khẩu sẽ báo lỗi
    if (password == null || password == "") {
        swal({
            title: "",
            text: "Mật khẩu đang để trống...",
            icon: "warning",
            close: true,
            button: "Thử lại",
          });
        return false;
    }
    //Nếu trống toàn bộ thì báo lỗi
    else {
      swal({
          title: "",
          text: "Sai thông tin đăng ký hãy kiểm tra lại...",
          icon: "error",
          close: true,
          button: "Thử lại",
        });
        window.location = "index.php";
      return true;
  };
}


/* PHẦN ĐĂNG KÍ TÀI KHOẢN*/
function validateRegister() {
  var username = document.getElementById("username").value;
  var password = document.getElementById("password-field").value;
  var email = document.getElementById("email").value;
  var phone = document.getElementById("phone").value;
  var password_conf = document.getElementById("password-conf").value;

  //Nếu không nhập gì mà nhấn đăng ký thì sẽ báo lỗi
  if (username == "" && password == "") {
      swal({
          title: "",
          text: "Bạn chưa điền đầy đủ thông tin đăng ký...",
          icon: "error",
          close: true,
          button: "Thử lại",
        });
       
      return false;
     
  }

   //Nếu không nhập tài khoản sẽ báo lỗi
   if (username == null || username == "") {
    swal({
        title: "",
        text: "Tài khoản đang để trống...",
        icon: "warning",
        close: true,
        button: "Thử lại",
      });
    return false;
}
    //Nếu không nhập email sẽ báo lỗi
    if (email == null || email == "") {
      swal({
          title: "",
          text: "Email đang để trống...",
          icon: "warning",
          close: true,
          button: "Thử lại",
        });
      return false;
  }

      //Nếu không nhập sdt sẽ báo lỗi
      if (phone == null || phone == "") {
        swal({
            title: "",
            text: "Số điện thoại đang để trống...",
            icon: "warning",
            close: true,
            button: "Thử lại",
          });
        return false;
    }

    //Nếu nhập mật khẩu không đủ 8 kí tự sẽ báo lỗi
    if (password.length<8) {
      swal({
          title: "",
          text: "Mật khẩu không được nhỏ hơn 8 kí tự!",
          icon: "warning",
          close: true,
          button: "Thử lại",
        });
      return false;
  }

  
    //Nếu nhập mật khẩu không trùng với re - mật khẩu tự sẽ báo lỗi
    if (password!=password_conf) {
      swal({
          title: "",
          text: "Mật khẩu không khớp!",
          icon: "warning",
          close: true,
          button: "Thử lại",
        });
      return false;
  }
  //Nếu không nhập mật khẩu sẽ báo lỗi
  if (password == null || password == "") {
      swal({
          title: "",
          text: "Mật khẩu đang để trống...",
          icon: "warning",
          close: true,
          button: "Thử lại",
        });
      return false;
  }
  else {
    swal({
        title: "",
        text: "Thành công!",
        icon: "success",
        close: true,
        button: "Trở lại trang đăng nhập",
      });
      window.location = "index.php";
    return true;
};
  
  
}




/*  PHẦN NỘI DUNG KHÔI PHỤC MẬT KHẨU   */


function RegexEmail(emailInputBox) {
    var emailStr = document.getElementById(emailInputBox).value;
    var emailRegexStr = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    var isvalid = emailRegexStr.test(emailStr);
    if (!isvalid) {
        swal({
            title: "",
            text: "Bạn vui lòng nhập đúng định dạng email...",
            icon: "error",
            close: true,
            button: "Thử lại",
          });
        
        emailInputBox.focus;
    } else {
        swal({
            title: "",
            text: "Chúng tôi vừa gửi cho bạn email hướng dẫn đặt lại mật khẩu vào địa chỉ cho bạn",
            icon: "success",
            close: true,
            button: "Đóng",
          });
        emailInputBox.focus;
        window.location = "#";

    }
}




