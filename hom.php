<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مطار طرابلس الدولي - حجز تذاكر الطيران</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            background-image: url('images (1).jpeg'); /* صورة الخلفية */
            background-size: cover; /* يجعل الصورة تغطي كامل الخلفية */
            background-position: center; /* يضع الصورة في وسط الخلفية */
            background-repeat: no-repeat; /* يمنع تكرار الصورة */
            background-attachment: fixed; /* يجعل الصورة ثابتة أثناء التمرير */
        }
        
        header {
        
            color: #fff;
            padding: 20px 0;
            text-align: center;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header h1 {
            width: 600px; /* حجم الشعار */
            text-align: center;
           
        }

        .header-right {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .header-box {
            background:#fff(0, 0, 0, 0.7);
            padding: 10px;
            border-radius: 8px;
            color: #fff;
            display: flex;
            gap: 10px; /* المسافة بين الروابط */
        }

        .header-box a {
            color: #fff;
            padding: 30px;
            text-decoration: none;
            background: #004080;
            border-radius: 4px;
        }

        .header-box a:hover {
            background: grey;
        }

        .hero {
            background: url('airport-background.jpg') no-repeat center center/cover;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
        }

        .search-box {
            background: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 8px;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-box input {
            margin: 10px 0;
            padding: 15px;
            width: calc(100% - 32px);
            border: none;
            border-radius: 4px;
            background: #fff;
            color: #333;
        }

        .search-box button {
            background: #004080;
            color: #fff;
            padding: 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        footer {
            background:gray;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Tripoli Airport✈️</h1>
        <div class="header-right">
            <div class="header-box">
                <a href="login.php">login</a>
                <a href="user_registration.php">registration</a>
            </div>
        </div>
    </header>
    <div class="hero">
        <div class="search-box">
            <h2> I was looking for a trip</h2>
            <input type="text" placeholder="from">
            <input type="text" placeholder="to">
            <input type="date" placeholder="date ">
            <button>serch</button>
        </div>
    </div>

    <!-- يمكنك إضافة المزيد من المحتوى هنا -->

</body>
</html>
