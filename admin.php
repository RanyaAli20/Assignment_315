<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الإدارة - مطار طرابلس الدولي</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            color: #333;
        }
        .container {
            width: 80%;
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
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
            color: #004080;
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
            background: #0056b3;
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

