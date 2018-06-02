<html>
    <head>
        <meta charset="utf-8">
        <title>Slim 3</title>
        <link rel="stylesheet" href="http://yegor256.github.io/tacit/tacit.min.css">
    </head>
    <body>
        <h1>Upload a file</h1>
        <form method="POST" action="./../public/addQuestions" enctype="multipart/form-data">
            <label>Select file to upload:</label>
            <input type="text" name="course">
            <input type="file" name="questions">
            <button type="submit">Upload</button>
        </form>
    </body>
</html>