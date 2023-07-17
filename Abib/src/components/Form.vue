<template>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Page</title>

        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    </head>

    <body>

        <div class="main">
            <div class="logo"></div>
            <div class="title">Masukkan Kode Anggota</div>
            <form action="">
                <div class="credentials">
                    <div class="pin">
                        <span class="material-symbols-outlined">
                            person
                        </span>
                        <input type="number" name="pin" id="pin" required="true" placeholder="Pin">
                    </div>
                </div>

               <router-link to="/homepage"><button class="submit" type="submit">{{ textbutton }}</button></router-link> 
            </form>
        </div>

        <router-view></router-view>



    </body>

    </html>
</template>

<style scoped>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;

    --body-background-color-one: #17ffc6;
    --body-background-color-two: #89D63E;

    --main-background-color: #fff;

    --font-color: #555;

    --submit-background-color-one: #4EFA99;
    --submit-background-color-two: #3ED656;
    --submit-background-color-three: #68ED51;

    --submit-box-shadow: #b1b1b1;
}

body {
    height: 100vh;
    display: flex;
    align-items: center;
    /* color: #03a1fc; */
    background-image: linear-gradient(to right, var(--body-background-color-one), var(--body-background-color-two));
    justify-content: center;
}

.main {
    width: 450px;
    padding: 60px 35px 35px 35px;
    border-radius: 20px;
    transition: all 1s ease;
    background-color: var(--main-background-color);
    font-family: sans-serif;
    font-weight: 700;
    overflow: auto;
}

.logo {
    background-image: url("../assets/money-dynamic-color.svg");
    width: 100%;
    height: 140px;
    background-repeat: no-repeat;
    background-position: center;
}

.title {
    text-align: center;
    font-size: 28px;
    color: var(--font-color);
    letter-spacing: .5px;
    margin: 35px;
}

.credentials {
    width: 100%;
    padding: 2px 5px 0 5px;
}

.credentials input {
    border: none;
    outline: none;
    background: none;
    font-size: 18px;
    color: var(--font-color);
    padding: 20px 10px 20px 5px;
    width: 85%;
}

.pin {
    margin-bottom: 20px;
    border-bottom: 2px solid #c2c4c3;
    transition: .5s ease;
}

.password {
    margin-bottom: 30px;
    border-bottom: 2px solid #c2c4c3;
    transition: .5s ease;
}

.submit {
    outline: none;
    border: none;
    width: 100%;
    height: 60px;
    border-radius: 30px;
    color: #fff;
    font-size: 20px;
    font-weight: 700;
    text-align: center;
    background-image: linear-gradient(to right, var(--submit-background-color-one), var(--submit-background-color-two), var(--submit-background-color-three));
    background-size: 200%;
    box-shadow: 3px 3px 8px var(--submit-box-shadow),
        -3px 3px 8px var(--main-background-color);
    transition: .5s;
}

.submit:hover {
    background-position: right;
    cursor: pointer;
}


@media (max-width: 540px) {
    .main {
        width: 100%;
        min-height: 100%;
        border-radius: 0;
    }
}
</style>

<script>
export default {
    props: ['textbutton'],
}
</script>   