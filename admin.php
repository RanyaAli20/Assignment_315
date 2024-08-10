<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الإدارة - مطار طرابلس الدولي</title>
    <style>
        body {
            background-color: #f0f0f0;
            background-image: url('images (1).jpeg'); /* صورة الخلفية */
            background-size: cover; /* يجعل الصورة تغطي كامل الخلفية */
            background-position: center; /* يضع الصورة في وسط الخلفية */
            background-repeat: no-repeat; /* يمنع تكرار الصورة */
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        
            color: #333;
        }
        .container {
            background:black(19, 19, 19, 0.9); /* استخدم خلفية بيضاء مع شفافية بسيطة لتحسين وضوح النصوص */
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
     background: #004080;;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Admin 👨‍✈️</h1>
        </div>
        <div class="box">
            
            <a href="add_plan.php"> Add aircraft data</a>
        </div>
        <div class="box">
            
            <a href="update_plan.php"> Modify aircraft data</a>
        </div>
        <div class="box">
            
            <a href="delete_plan.php"> Cancel aircraft data</a>
        </div>
        <div class="box">
            
            <a href="add_flight.php">Add a trip</a>
        </div>
        <div class="box">
            
            <a href="update_flight.php">Modify trip data</a>
        </div>
        <div class="box">
        
            
            <a href="delete_flight.php">Cancel a trip</a>
            
            

        </div>
    </div>
</body>
</html>

