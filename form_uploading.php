<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Report Lost Item</title>
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
            max-width: 400px;
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
        }

        textarea {
            min-height: 80px;
            resize: vertical;
        }

        input[type="file"] {
            padding: 5px;
            background: #f9f9f9;
        }

        button {
            margin-top: 20px;
            padding: 12px 20px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background: #c82333;
        }

        #preview {
            margin-top: 10px;
            max-height: 200px;
            border-radius: 10px;
            display: none;
        }
    </style>
</head>
<body>

<h2>Submit Lost Item</h2>

<form action="save_lost_item.php" method="POST" enctype="multipart/form-data" autocomplete="off">
    <label for="name">Item Name</label>
    <input type="text" id="name" name="name" placeholder="Item Name" required>

    <label for="description">Item Description</label>
    <textarea id="description" name="description" placeholder="Item Description" required></textarea>

    <label for="location">Lost Location</label>
    <input type="text" id="location" name="location" placeholder="Lost Location" required>

    <label for="date">Date Lost</label>
    <input type="date" id="date" name="date" required>

    <label for="contact">Your Contact Info</label>
    <input type="text" id="contact" name="contact" placeholder="Your Contact Info" required>

    <label for="item_image">Upload Item Image</label>
    <input type="file" id="item_image" name="item_image" accept="image/*" onchange="previewImage()" required>

    <img id="preview" src="#" alt="Image Preview" />

    <input type="hidden" name="status" value="lost">

    <button type="submit">Submit</button>
</form>

<script>
    function previewImage() {
        const file = document.getElementById("item_image").files[0];
        const preview = document.getElementById("preview");

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = "block";
            };

            reader.readAsDataURL(file);
        } else {
            preview.src = "#";
            preview.style.display = "none";
        }
    }
</script>

</body>
</html>
