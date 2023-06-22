// <!-- $("#BtnRegister").click(function() {
//     e.preventDefault();
//       // console.log("enter here");
//       var name     = $("#stickyName").val();
//       var email    = $("#stickyEmail").val();
//       var mobile   = $("#sticky_mobile").val();
//       var optradio = $("input[type='radio'][name='optradio']:checked").val();
//       var slug     = "campaign/" + "rbi-grade-b";
//       var phoneno  = /^[6789]\d{9}$/;
//       var regex    = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
//       var token    = $('meta[name="csrf-token"]').attr('content');  

//       console.log("slug is "+ slug );

//       $("#eMessage").css("display", "block");
//       // if(name == ""){
//       //   $("#eMessage").empty();
//       //   $("#eMessage").append("Name is required");
//       //   return false;
//       // }


//       if (name == "") {
//           $("#eMessage").empty();
//           $("#eMessage").append("name  is required.");
//           return false;
//       }else{
//           if (/[a-zA-Z'.\\s]{1,40}$/.test(name) == false) {
//           $('#eMessage').empty();
//           $('#eMessage').append("You can not use special letter in name field.");
//           return false;
//       }
//       }



//       if (email == "") {
//           $("#eMessage").empty();
//           $("#eMessage").append("Email is required.");
//           return false;
//       }

//       if (regex.test(email) == false) {
//           $("#eMessage").empty();
//           $("#eMessage").append("Email format is not correct.");
//           return false;
//       }


//       if (mobile == "") {
//           $("#eMessage").empty();
//           $("#eMessage").append("Mobile is required.");
//           return false;
//       }

//       if (!(phoneno.test(mobile))) {
//           $("#eMessage").empty();
//           $("#eMessage").append("Mobile is not in required format.");
//           return false;
//       }

//     if(optradio == undefined){
//         $("#eMessage").empty();
//         $("#eMessage").append("Please choose professional.");
//         return false;

//     }

//       // if(optradio == ""){

//       // }

//       // if (!$("#optradio").prop("checked")) {
//       //   $("#eMessage").empty();
//       //   $("#eMessage").append("Please choose professional.");
//       //   return false;
//       // }
//       console.log(optradio);
       
            

//       if (name && email && mobile && optradio) {
//           $("#eMessage").empty();
//           $("#eMessage").css("display", "none");
//           $.ajax({
//               url: "https://www.ixambee.com/campaign-rbi-grabe-b",
//               type: "post",
//               data: {
//                   name: name,
//                   email: email,
//                   mobile: mobile,
//                   optradio: optradio,
//                   slug: slug,
//                   "_token": token
//               },
//               success: function(data) {
//                   // alert("Thank you!!! Your form submitted successfully.");
//                   // window.location.replace("http://new.ixambee.in/thankyou.html");
//                   window.location.replace("https://www.ixambee.com/online-course/rbi-grade-b");
//                   // window.location.replace("https://www.ixambee.com/demo2020/39/49?redirect_to=online-course/rbi-grade-b");
//               }
//           })
//       }

//   }); -->