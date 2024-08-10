<?php
// يبدأ الجلسة ويتصل بقاعدة البيانات إذا لزم الأمر

// يمكن إضافة أي منطق PHP هنا إذا لزم الأمر

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة المستخدم - مطار طرابلس الدولي</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        
            color: #333;
            background-image: url('images (1).jpeg'); /* يمكنك تغيير الصورة إلى صورة الخلفية التي تريدها */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
        }
        .container {
            
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    max-width: 600px;
    width: 100%;
    text-align: center;

            width: 80%;
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
        
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 2.5em;
            color:#fff;
        }
        .box {
            margin: 20px;
            padding: 20px;
            background: #007BFF;
            color: #fff;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: background 0.3s;
        }
        .box:hover {
            background: #004080;
        }
        .box a {
            color: #fff;
            text-decoration: none;
            font-size: 1.2em;
            display: block;
            margin-top: 10px;
        }
        .box a:hover {
            text-decoration: underline;
        }
        .box.cancel {
            background: #007bff; /* الأحمر لإلغاء الحجز */
        }
        .box.cancel:hover {
            background: gray; /* لون أغمق عند التمرير */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>USER👤🧳</h1>
            <br>
            <br>
            <br>
            <br><br>
        </div>
        <div class="box">
            <a href="booking_form2.php">Book a trip</a>
            <br>
            <br>
            <br>
        </div>
        <div class="box cancel">
            <a href="booking_form2.php">Cancel flight reservation</a>
            <br>
            <br>
            <br>
        </div>
    </div>
</body>
</html>
