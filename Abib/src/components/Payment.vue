<template>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- custom css file link  -->

</head>
<body>

<div class="container">

    <form action="">

        <div class="row">

            <div class="col">

                <h3 class="title">Info Pembayaran</h3>

                <div class="inputBox">
                    <span>Nama Lengkap :</span>
                    <input type="text" placeholder="Isi nama lengkap disini">
                </div>
                <div class="inputBox">
                    <span>Email :</span>
                    <input type="email" placeholder="example@example.com">
                </div>
                <div class="inputBox">
                    <span>Alamat :</span>
                    <input type="text" placeholder="Jalan Buah Batu">
                </div>
                <div class="inputBox">
                    <span>Kota :</span>
                    <input type="text" placeholder="Bandung">
                </div>

                <div class="inputBox">
                    <span>Provinsi :</span>
                    <input type="text" placeholder="Jawa Barat">
                </div>

                <div class="inputBox">
                    <span>Jenis Identitas :</span>
                    <select name="identitas" id="identitas">
                        <option value="KTP">KTP</option>
                        <option value="Kartu Pekerja">Kartu Pekerja</option>
                        <option value="KK">Kartu Keluarga</option>
                        <option value="Kartu Pelajar">Kartu Pelajar</option>
                    </select>
                </div>

                <div class="inputBox">
                    <span>Nomor Identitas :</span>
                    <input type="text" placeholder="1402165976248294">
                </div>

            </div>
        </div>

        <input type="submit" value="Submit" class="submit-btn">

    </form>

</div>    
    
</body>
</html>
</template>

<style scoped>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600&display=swap');

*{
  font-family: 'Poppins', sans-serif;
  margin:0; padding:0;
  box-sizing: border-box;
  outline: none; border:none;
  text-transform: capitalize;
  transition: all .2s linear;

  --body-background-color-one : #17ffc6;
  --body-background-color-two : #89D63E;

  --submit-background-color-one : #4EFA99;
  --submit-background-color-two : #3ED656;
  --submit-background-color-three : #68ED51;
}

.container{
  display: flex;
  justify-content: center;
  align-items: center;
  padding:25px;
  min-height: 100vh;
  background: linear-gradient(90deg, var(--body-background-color-one), var(--body-background-color-two));
}

.container form{
  padding:20px;
  width:700px;
  background: #fff;
  box-shadow: 0 5px 10px rgba(0,0,0,.1);
}

.container form .row{
  display: flex;
  flex-wrap: wrap;
  gap:15px;
}

.container form .row .col{
  flex:1 1 250px;
}

.container form .row .col .title{
  font-size: 20px;
  color:#333;
  padding-bottom: 5px;
  text-transform: uppercase;
}

.container form .row .col .inputBox{
  margin:15px 0;
}

.container form .row .col .inputBox span{
  margin-bottom: 10px;
  display: block;
}

.container form .row .col .inputBox input{
  width: 100%;
  border:1px solid #ccc;
  padding:10px 15px;
  font-size: 15px;
  text-transform: none;
}

.container form .row .col .inputBox input:focus{
  border:1px solid #000;
}

.container form .row .col .flex{
  display: flex;
  gap:15px;
}

.container form .row .col .flex .inputBox{
  margin-top: 5px;
}

.container form .row .col .inputBox img{
  height: 34px;
  margin-top: 5px;
  filter: drop-shadow(0 0 1px #000);
}

.container form .submit-btn{
  width: 100%;
  padding:12px;
  font-size: 17px;
  background-image: linear-gradient(to right, var(--submit-background-color-one) ,var(--submit-background-color-two), var(--submit-background-color-three) );;
  color:#fff;
  margin-top: 5px;
  cursor: pointer;
}

.container form .submit-btn:hover{
  background: #2ecc71;
}

#identitas {
    border: 1px solid black;
}
</style>