# ATM-Mini-Project

In System 2, servlets are in System 2\atm2\src\main\java.

System 2 routes:
- GET /ATMServlet: Displays Login Page
- POST /ATMServlet: Displays Home Page
- POST /CheckBalanceServlet: Checks balance in ATM.jar
- GET /CheckBalanceServlet: Displays balance
- POST /CheckValidAccServlet: Check if the given account number is valid
- POST /DeductMoneyServlet: Deduct the given amount from the given account

In System 4, OTP function is in System 4\netlifyATM\nextjs-toolbox\netlify\functions\otp.js.

System 4 routes:
- Request to send OTP: 
  ```
  curl --request GET \
  --url 'https://helpful-starburst-e40e46.netlify.app/.netlify/functions/otp?email=email'
  ```
  Response:
  ```
  {
    "result": "Success",
    "token": "token",
    "time": "time"
  }
  ```  
  
- Verify OTP:
  ```
  curl --request POST \
  --url https://helpful-starburst-e40e46.netlify.app/.netlify/functions/otp \
  --data email=email \
  --data otp=otp \
  --data token=token \
  --data 'time=time'
  ```
