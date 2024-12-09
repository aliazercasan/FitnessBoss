<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication Failed</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <div class="error-box">
            <h1 class="error-code">400</h1>
            <h2 class="error-title">Membership Expired</h2>
            <p class="error-message">
                Sorry Arjay your membership is already expired. Go to our cashier to renew your membership
            </p>
            <a href="#" class="back-button">GO BACK</a>
        </div>
    </div>
</body>
</html>


<style>
    body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #1a1a2e;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    border: 2px solid #00e0ff;
    padding: 20px;
    border-radius: 10px;
    background-color: #0f0f1d;
}

.error-box {
    max-width: 500px;
}

.error-code {
    font-size: 3rem;
    color: red;
}

.error-title {
    font-size: 2rem;
    margin-bottom: 10px;
}

.error-message {
    font-size: 1rem;
    margin-bottom: 20px;
}

.error-message a {
    color: #00e0ff;
    text-decoration: none;
}

.error-message a:hover {
    text-decoration: underline;
}

.back-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #ff4500;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s;
}

.back-button:hover {
    background-color: #ff652f;
}

</style>