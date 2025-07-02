<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Report Found Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
            text-align: center;
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            display: inline-block;
            text-align: left;
            max-width: 360px;
            width: 100%;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            resize: vertical;
        }
        textarea {
            min-height: 80px;
        }
        button {
            margin-top: 20px;
            padding: 12px 20px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<h2>Submit Found Item</h2>
<form action="save_found_item.php" method="POST" autocomplete="off" enctype="multipart/form-data">
    <label for="name">Item Name</label>
    <input type="text" id="name" name="name" placeholder="Item Name" required>

    <label for="description">Item Description</label>
    <textarea id="description" name="description" placeholder="Item Description" required></textarea>

    <label for="location">Found Location</label>
    <input type="text" id="location" name="location" placeholder="Found Location" required>

    <label for="date">Date Found</label>
    <input type="date" id="date" name="date" required>

    <label for="contact">Your Contact Info</label>
    <input type="text" id="contact" name="contact" placeholder="Your Contact Info" required>

    <label for="image">Upload Image</label>
    <input type="file" id="image" name="image" accept="image/*" required>

    <input type="hidden" name="status" value="found">

    <button type="submit">Submit</button>
</form>

</body>
</html>
