<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
  <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
  <script defer src="/js/add-page.js"></script>
  <title>Add page</title>
</head>

<body>
  <form action="/handlers/submit-add-page.php" method="post">
    <input type="text" name="title" placeholder="Title">
    <input type="text" name="description" placeholder="Description">
    <textarea name="content" id="content" cols="30" rows="10" placeholder="Content"></textarea>
    <input type="submit" value="Add page">
  </form>
</body>

</html>