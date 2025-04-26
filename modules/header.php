<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BEST BUY - Phụ kiện điện thoại</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Header chỉ chứa ảnh */
        .header-image {
            width: 100%;
            max-height: 150px; /* Giảm chiều cao so với bản cũ */
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f5f5f5;
        }
        
        .header-image img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            object-position: center;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header-image {
                max-height: 100px;
            }
        }
    </style>
</head>
<body>
    <!-- Header chỉ chứa ảnh -->
    <div class="header-image">
        <img src="https://admin.buyforme.vn/uploads/2023/08/mua-sam-dien-thoai-cu-tren-bestbuy.jpg" 
             alt="BEST BUY Phụ kiện điện thoại"
             title="BEST BUY - Điểm đến tin cậy cho phụ kiện điện thoại">
    </div>
</body>
</html>